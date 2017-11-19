<?php

namespace Beeblebrox3\Caster;

use Beeblebrox3\Caster\Rules\IRule;
use Exception;

class Caster
{
    protected $cachedRules = [];

    /**
     * @param array $types
     * @param array $data
     * @param bool $fillWithNull
     * @return array
     * @throws Exception
     */
    public function cast(array $types, array $data, bool $fillWithNull = false) : array
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
     * @param string $rules
     * @param $value
     * @return mixed|null
     * @throws Exception
     */
    protected function handleValue(string $rules, $value)
    {
        $rules = explode("|", $rules);

        $res = null;
        foreach ($rules as $rule) {
            $ruleArgs = explode(":", $rule);
            $ruleName = array_shift($ruleArgs);

            if (count($ruleArgs) > 1) {
                $ruleArgs = [implode(':', $ruleArgs)];
            }

            if ($ruleArgs) {
                $ruleArgs = explode(",", $ruleArgs[0]);
            }

            array_unshift($ruleArgs, $value);

            $ruleObject = $this->getRuleObject($ruleName);
            $res = call_user_func_array([$ruleObject, "handle"], $ruleArgs);
        }

        return $res;
    }

    /**
     * @param string $ruleName
     * @return mixed
     * @throws Exception
     */
    protected function getRuleObject(string $ruleName) : IRule
    {
        if (!isset($this->cachedRules[$ruleName])) {
            $ruleQualifiedName = $this->getRuleClassName($ruleName);

            if (!class_exists($ruleQualifiedName)) {
                throw new Exception($ruleName);
            }

            $this->cachedRules[$ruleName] = new $ruleQualifiedName();
        }

        return $this->cachedRules[$ruleName];
    }

    protected function getRuleClassName(string $ruleName) : string
    {
        $ruleName = explode("_", $ruleName);
        $ruleName = array_map(function ($slice) {
            return ucfirst($slice);
        }, $ruleName);

        return __NAMESPACE__ . "\\Rules\\" . implode("", $ruleName) . "Rule";
    }
}