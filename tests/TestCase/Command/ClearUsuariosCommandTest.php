<?php
namespace App\Test\TestCase\Command;

use App\Command\ClearUsuariosCommand;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Command\ClearUsuariosCommand Test Case
 *
 * @uses \App\Command\ClearUsuariosCommand
 */
class ClearUsuariosCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->useCommandRunner();
    }
    /**
     * Test buildOptionParser method
     *
     * @return void
     */
    public function testBuildOptionParser()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test execute method
     *
     * @return void
     */
    public function testExecute()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
