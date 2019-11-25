<?php
namespace Bootstrap\Test\TestCase\View\Helper;

use Bootstrap\View\Helper\MenuHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * Bootstrap\View\Helper\MenuHelper Test Case
 */
class MenuHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Bootstrap\View\Helper\MenuHelper
     */
    public $Menu;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Menu = new MenuHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Menu);

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
