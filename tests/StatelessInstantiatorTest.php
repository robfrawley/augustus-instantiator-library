<?php

/*
 * This file is part of the `src-run/augustus-instantiator-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Instantiator\Test;

use SR\Instantiator\StatelessInstantiator;
use SR\Util\Info\ClassInfo;

/**
 * Class StatelessInstantiatorTest.
 */
class StatelessInstantiatorTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiateFromObject()
    {
        $obj = new ClassInfo();
        $one = StatelessInstantiator::instantiate($obj);

        $this->assertInstanceOf('SR\Util\Info\ClassInfo', $one);

        $two = StatelessInstantiator::instantiate($one);
        $this->assertInstanceOf('SR\Util\Info\ClassInfo', $two);

        $this->assertNotSame($obj, $one);
        $this->assertNotSame($one, $two);
        $this->assertNotSame($obj, $two);
    }

    public function testInstantiateFromClassName()
    {
        $obj = 'SR\Util\Info\ClassInfo';
        $one = StatelessInstantiator::instantiate($obj);

        $this->assertInstanceOf($obj, $one);

        $two = StatelessInstantiator::instantiate($one);

        $this->assertInstanceOf($obj, $two);
        $this->assertNotSame($one, $two);
    }

    public function testInstantiateWithInternal()
    {
        $this->expectException('\InvalidArgumentException');

        StatelessInstantiator::instantiate('SR\Instantiator\Test\ClassInternal');
    }
}

/**
 * Fixture class for test.
 */
class StatelessClassInternal extends StatelessClassInternalParent
{
}

/**
 * Fixture class for test.
 */
class StatelessClassInternalParent extends \SplFileInfo
{
    public function __construct()
    {
        parent::__construct(__FILE__);
    }
}

/* EOF */
