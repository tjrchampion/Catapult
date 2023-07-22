<?php

namespace Catapult\Container;

use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use Catapult\Exceptions\NotFoundException;

class Container
{
    /**
     * array of classes to be "autowired"
     *
     * @var array
     */
    protected $items = [];

    /**
     * setting a callable into the items array
     *
     * @param String|class $name
     * @param callable $closure
     * @return void
     */
    public function set($name, callable $closure) : void
    {
        $this->items[$name] = $closure;
    }

    /**
     * Singleton of the set method,
     * will not be instancated every time it is called.
     *
     * @param String|class $name
     * @param callable $closure
     * @return Closure
     */
    public function share($name, callable $closure)
    {
        $this->items[$name] = function() use ($closure) {

            static $resolved;

            if(!$resolved) {
                $resolved = $closure($this);
            }
            return $resolved;
        };
    }
    /**
     * Do we have it in $items?
     *
     * @param String|class $name
     * @return boolean
     */
    public function has($name) : bool
    {
        return isset($this->items[$name]);
    }
    /**
     * Get me from $items
     *
     * @param String|class $name
     * @return void
     */
    public function get($name)
    {
        if($this->has($name)) {
            return $this->items[$name]($this);
        }

        return $this->auto($name);
    }
    /**
     * autowiring
     *
     * @param class $name
     * @return class
     */
    protected function auto($name)
    {
        if(!class_exists($name)) {
            throw new NotFoundException;
        }

        $reflector = $this->getReflector($name);

        if(!$reflector->isInstantiable()) {
            throw new NotFoundException;
        }

        if($constructor = $reflector->getConstructor()) {
            return $reflector->newInstanceArgs(
                $this->getConstructorDeps($constructor)
            );
        }

        return new $name();
    }
    /**
     * Array of any resolved constructors
     *
     * @param ReflectionMethod $constructor
     * @return Array
     */
    protected function getConstructorDeps(ReflectionMethod $constructor) : Array
    {
        return array_map(function($dep) {
            return $this->resolveReflectedDep($dep);
        }, $constructor->getParameters());
    }
    /**
     * Resolve class.
     * Can we add a union return type here.
     *
     * @param ReflectionParameter $dep
     * @return NotFoundException|Object
     */
    protected function resolveReflectedDep(ReflectionParameter $dep)
    {
        if(is_null($dep->getType())) {
            return throw new NotFoundException;
        }

        return $this->get(
            $dep->getType()->getName()
        );
    }
    /**
     * PHP reflection API to set up a new instance
     * of a given class.
     *
     * @param Class $class
     * @return ReflectionClass
     */
    protected function getReflector($class) : ReflectionClass
    {
        return new ReflectionClass($class);
    }
    /**
     * Magic method __get() will allow for $container->{class}->{method}
     *
     * @param [type] $name
     * @return void
     */
    public function __get($name)
    {
        return $this->get($name);
    }
}