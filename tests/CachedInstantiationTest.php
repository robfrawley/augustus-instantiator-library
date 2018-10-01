<?php

/*
 * This file is part of the `src-run/augustus-instantiator-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Instantiate\Test;

use PHPUnit\Framework\TestCase;
use SR\Instantiate\CachedInstantiation;
use SR\Utilities\Query\ClassQuery;

/**
 * @covers \SR\Instantiate\AbstractInstantiation
 * @covers \SR\Instantiate\CachedInstantiation
 */
class CachedInstantiationTest extends TestCase
{
    public function testInstantiateFromObject(): void
    {
        $obj = new ClassQuery();
        $one = CachedInstantiation::instantiate($obj);

        $this->assertInstanceOf(ClassQuery::class, $one);

        $two = CachedInstantiation::instantiate($one);
        $this->assertInstanceOf(ClassQuery::class, $two);

        $this->assertNotSame($obj, $one);
        $this->assertNotSame($one, $two);
        $this->assertNotSame($obj, $two);
    }

    public function testInstantiateFromClassName(): void
    {
        $obj = ClassQuery::class;
        $one = CachedInstantiation::instantiate($obj);

        $this->assertInstanceOf($obj, $one);

        $two = CachedInstantiation::instantiate($one);

        $this->assertInstanceOf($obj, $two);
        $this->assertNotSame($one, $two);
    }

    public function testInstantiateWithInternal(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        CachedInstantiation::instantiate(ClassInternal::class);
    }
}

/**
 * Fixture class for test.
 */
class ClassInternal extends ClassInternalParent
{
}

/**
 * Fixture class for test.
 */
class ClassInternalParent extends \SplFileInfo
{
    public function __construct()
    {
        parent::__construct(__FILE__);
    }
}

/* EOF */
