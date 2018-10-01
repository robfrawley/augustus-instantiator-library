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

final class CachedInstantiation extends AbstractInstantiation
{
    /**
     * @var object[]
     */
    private static $cachedInstances;

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
        $qualified = static::getQualifiedClassName($object);

        if (isset(static::$cachedInstances[$qualified])) {
            return clone static::$cachedInstances[$qualified];
        }

        return parent::instantiate($object, ...$arguments);
    }

    /**
     * @param string  $qualified
     * @param mixed[] ...$arguments
     *
     * @return object
     */
    protected static function doInstantiation(string $qualified, ...$arguments)
    {
        $instance = parent::doInstantiation($qualified, ...$arguments);

        if (ClassQuery::getReflection($qualified)->isCloneable()) {
            static::$cachedInstances[$qualified] = clone $instance;
        }

        return $instance;
    }
}
