<?php
namespace Bootstrap\Test\TestCase\Controller\Component;

use Bootstrap\Controller\Component\FilterComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * Bootstrap\Controller\Component\FilterComponent Test Case
 */
class FilterComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Bootstrap\Controller\Component\FilterComponent
     */
    public $Filter;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Filter = new FilterComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Filter);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
