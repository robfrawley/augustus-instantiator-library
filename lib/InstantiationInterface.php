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

interface InstantiationInterface
{
    /**
     * Instantiate an object using the specified constructor arguments.
     *
     * @param string|object $object       Class name or instance to instantiate
     * @param mixed         ...$arguments Arguments to pass to constructor
     *
     * @return object
     */
    public static function instantiate($object, ...$arguments);
}

/* EOF */
