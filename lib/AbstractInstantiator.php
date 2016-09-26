<?php

/*
 * This file is part of the `src-run/augustus-instantiator-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Instantiator;

use SR\Util\Info\ClassInfo;

abstract class AbstractInstantiator implements InstantiatorInterface
{
    /**
     * Instantiate an object using the specified constructor arguments.
     *
     * @param string|object $class Class name or instance to instantiate
     * @param mixed         ...$constructorArguments Arguments to pass to constructor
     *
     * @return object
     */
    public static function instantiate($class, ...$constructorArguments)
    {
        return static::buildAndCache(static::getQualifiedClassName($class), ...$constructorArguments);
    }

    /**
     * @param string|object $name
     *
     * @return string
     */
    protected static function getQualifiedClassName($name)
    {
        return ClassInfo::getNameQualified($name);
    }

    /**
     * @param string $qualified
     * @param mixed[] ...$constructorArguments
     *
     * @return object
     */
    protected static function buildAndCache(string $qualified, ...$constructorArguments)
    {
        $reflectionClass = ClassInfo::getReflection($qualified);

        if (!static::isInstantiable($reflectionClass)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" is not instantiable.', $qualified));
        }

        return $reflectionClass->newInstanceArgs($constructorArguments);
    }

    /**
     * @param \ReflectionClass $reflection
     *
     * @return bool
     */
    protected static function isInstantiable(\ReflectionClass $reflection)
    {
        return !static::hasInternalAncestors($reflection) && !$reflection->isAbstract();
    }

    /**
     * @param \ReflectionClass $reflection
     *
     * @return bool
     */
    protected static function hasInternalAncestors(\ReflectionClass $reflection)
    {
        do {
            if ($reflection->isInternal()) {
                return true;
            }
        } while ($reflection = $reflection->getParentClass());

        return false;
    }
}

/* EOF */
