<?php
namespace App\Test\TestCase\Form;

use App\Form\LoginForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\LoginForm Test Case
 */
class LoginFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\LoginForm
     */
    public $Login;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Login = new LoginForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Login);

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
