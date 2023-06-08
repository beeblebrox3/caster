<?php

namespace Beeblebrox3\Caster;

use Beeblebrox3\Caster\Contracts\Rule;
use Beeblebrox3\Caster\Exceptions\RuleNotFound;
use InvalidArgumentException;

use function is_callable;

class Caster
{
    protected array $cachedRules = [];

    protected array $customRules = [];

    public function addCustomRule(string $ruleName, $ruleBody): self
    {
        if (!is_string($ruleBody) && !is_callable($ruleBody)) {
            throw new InvalidArgumentException('$ruleBody must be string or callable.');
        }

        $this->customRules[$ruleName] = $ruleBody;
        return $this;
    }

    /**
     * @throws RuleNotFound
     */
    public function cast(array $types, array $data, bool $fillWithNull = false): array
    {
        $res = dot([]);
        $data = dot($data);

        foreach ($types as $key => $rules) {
            if (!$data->has($key)) {
                if ($fillWithNull) {
                    $res->add($key, null);
                }
                continue;
            }

            $res->add($key, $this->handleValue($rules, $data->get($key)));
        }

        return $res->all();
    }

    /**
     * @throws RuleNotFound
     */
    protected function handleValue(string $rules, $value): mixed
    {
        $rules = explode("|", $rules);

        $res = $value;
        foreach ($rules as $rule) {
            $ruleArgs = explode(":", $rule);
            $ruleName = array_shift($ruleArgs);

            if (count($ruleArgs) > 1) {
                $ruleArgs = [implode(':', $ruleArgs)];
            }

            if ($ruleArgs) {
                $ruleArgs = explode(",", $ruleArgs[0]);
            }

            array_unshift($ruleArgs, $res);

            $ruleObject = $this->getRuleBody($ruleName);
            $ruleObject = is_callable($ruleObject) ? $ruleObject : [$ruleObject, "handle"];

            $res = call_user_func_array($ruleObject, $ruleArgs);
        }

        return $res;
    }

    /**
     * @throws RuleNotFound
     */
    protected function getRuleBody(string $ruleName): Rule | callable
    {
        if (!isset($this->cachedRules[$ruleName])) {
            $ruleAccessor = $this->getRuleAccessor($ruleName);

            if (is_callable($ruleAccessor)) {
                $this->cachedRules[$ruleName] = $ruleAccessor;
            } elseif (!class_exists($ruleAccessor)) {
                throw new RuleNotFound($ruleName, $ruleAccessor);
            } else {
                $this->cachedRules[$ruleName] = new $ruleAccessor();
            }
        }

        return $this->cachedRules[$ruleName];
    }

    protected function getRuleAccessor(string $ruleName): string | callable
    {
        if (isset($this->customRules[$ruleName])) {
            return $this->customRules[$ruleName];
        }

        $ruleName = explode("_", $ruleName);
        $ruleName = array_map(function ($slice) {
            return ucfirst($slice);
        }, $ruleName);

        return __NAMESPACE__ . "\\Rules\\" . implode("", $ruleName) . "Rule";
    }
}
