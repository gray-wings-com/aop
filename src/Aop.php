<?php

namespace GrayWings\Aop;

use ReflectionMethod;

abstract class Aop
{
    final public function __call(string $name, array $arguments)
    {
        if (
            !(method_exists($this, $name) &&
                (new ReflectionMethod($this, $name))->isProtected())
        ) {
            //TODO: BadMethodCall();
            throw new \Exception();
        }

        $handleMethod = new ReflectionMethod($this, $name);
        $hookAttributes = $handleMethod->getAttributes(Hook::class);
        if (!count($hookAttributes)) {
            throw new \Exception();
        }

        $hook = $hookAttributes[0]->newInstance();
        $hook->before($this, $name, $arguments);
        $handleMethod->invoke($this, ...$arguments);
        $hook->after($this, $name, $arguments);
    }
}
