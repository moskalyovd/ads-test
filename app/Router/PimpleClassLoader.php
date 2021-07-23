<?php

namespace App\Router;

use Pecee\SimpleRouter\ClassLoader\IClassLoader;
use Pimple\Psr11\Container;
use ReflectionMethod;

class PimpleClassLoader implements IClassLoader
{
    /**
     * @var Container $container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Load class
     *
     * @param string $class
     * @return object
     */
    public function loadClass(string $class)
    {
        if (\class_exists($class) === false) {
            throw new NotFoundHttpException(sprintf('Class "%s" does not exist', $class), 404);
        }

        if ($this->container->has($class)) {
            return $this->container->get($class);
        }

        return new $class();
    }

    /**
     * Called when loading class method
     * @param object $class
     * @param string $method
     * @param array $parameters
     * @return object
     */
    public function loadClassMethod($class, string $method, array $parameters)
    {
        $reflectionMethod = new ReflectionMethod($class, $method);
        $methodParams = $reflectionMethod->getParameters();

        $loadedParams = [];

        foreach ($methodParams as $param) {
            if ($this->container->has($param->getType()->getName())) {
                $loadedParams[] = $this->container->get($param->getType()->getName());
            } elseif (isset($parameters[$param->getName()])) {
                $loadedParams[] = $parameters[$param->getName()];
            }
        }

        return call_user_func_array([$class, $method], $loadedParams);
    }

    /**
     * Load closure
     *
     * @param Callable $closure
     * @param array $parameters
     * @return mixed
     */
    public function loadClosure(Callable $closure, array $parameters)
    {
        return \call_user_func_array($closure, array_values($parameters));
    }
}