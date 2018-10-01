<?php

/*
 * This file is part of the `src-run/augustus-instantiator-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Instantiate;

use SR\Utilities\Query\ClassQuery;

/**
 * @internal
 */
abstract class AbstractInstantiation implements InstantiationInterface
{
    /**
     * Instantiate an object using the specified constructor arguments.
     *
     * @param string|object $object       Class name or instance to instantiate
     * @param mixed         ...$arguments Arguments to pass to constructor
     *
     * @return object
     */
    public static function instantiate($object, ...$arguments)
    {
        return static::doInstantiation(
            static::getQualifiedClassName($object), ...$arguments
        );
    }

    /**
     * @param string|object $object
     *
     * @return string
     */
    protected static function getQualifiedClassName($object): string
    {
        return ClassQuery::getNameQualified($object);
    }

    /**
     * @param string  $qualified
     * @param mixed[] ...$arguments
     *
     * @return object
     */
    protected static function doInstantiation(string $qualified, ...$arguments)
    {
        $reflectionClass = ClassQuery::getReflection($qualified);

        if (static::isInstantiable($reflectionClass)) {
            return $reflectionClass->newInstanceArgs($arguments);
        }

        throw new \InvalidArgumentException(
            sprintf('Class "%s" is not instantiable.', $qualified)
        );
    }

    /**
     * @param \ReflectionClass $reflection
     *
     * @return bool
     */
    protected static function isInstantiable(\ReflectionClass $reflection): bool
    {
        return false === static::hasInternalAncestors($reflection)
            && false === $reflection->isAbstract();
    }

    /**
     * @param \ReflectionClass $reflection
     *
     * @return bool
     */
    protected static function hasInternalAncestors(\ReflectionClass $reflection): bool
    {
        do {
            $internal = $reflection->isInternal();
        } while (true !== $internal && $reflection = $reflection->getParentClass());

        return $internal;
    }
}

/* EOF */
