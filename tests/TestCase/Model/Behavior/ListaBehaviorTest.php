<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\ListaBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\ListaBehavior Test Case
 */
class ListaBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Behavior\ListaBehavior
     */
    public $Lista;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Lista = new ListaBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Lista);

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
