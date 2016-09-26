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

final class StatefulInstantiator extends AbstractInstantiator
{
    /**
     * @var object[]
     */
    private static $cachedInstances;

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
        $qualified = static::getQualifiedClassName($class);

        if (isset(static::$cachedInstances[$qualified])) {
            return clone static::$cachedInstances[$qualified];
        }

        return parent::instantiate($class, ...$constructorArguments);
    }

    /**
     * @param string $qualified
     * @param mixed[] ...$constructorArguments
     *
     * @return object
     */
    protected static function buildAndCache(string $qualified, ...$constructorArguments)
    {
        $instance = parent::buildAndCache($qualified, ...$constructorArguments);

        if (ClassInfo::getReflection($qualified)->isCloneable()) {
            static::$cachedInstances[$qualified] = clone $instance;
        }

        return $instance;
    }
}
