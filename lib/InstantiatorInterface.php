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

interface InstantiatorInterface
{
    /**
     * Instantiate an object using the specified constructor arguments.
     *
     * @param string|object $class Class name or instance to instantiate
     * @param mixed         ...$constructorArguments Arguments to pass to constructor
     *
     * @return object
     */
    public static function instantiate($class, ...$constructorArguments);
}

/* EOF */
