<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class ExempleTest extends TestCase
{
    /**
     * {@inheritDoc}
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    protected function setUp(): void
    {
        echo "\nAvant chaque test ...";
        
    }

    /**
     * {@inheritDoc}
     * @see \PHPUnit\Framework\TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass(): void
    {
        echo "\nAvant tous les tests ...";
        
    }

    /**
     * {@inheritDoc}
     * @see \PHPUnit\Framework\TestCase::tearDown()
     */
    protected function tearDown(): void
    {
        echo "\nAprès chaque test ...";
        
    }

    /**
     * {@inheritDoc}
     * @see \PHPUnit\Framework\TestCase::tearDownAfterClass()
     */
    public static function tearDownAfterClass(): void
    {
        echo "\nAprès tous les tests ...";
        
    }
    
    public function test1(): void
    {
        echo "\nTest1 ...";
        $this->assertTrue(true);
    }
    
    public function test2(): void
    {
        echo "\nTest2 ...";
        $this->assertTrue(true);
        
    }
    

    public function testSomething(): void
    {
        $this->assertTrue(true);
    }
    
    
}
