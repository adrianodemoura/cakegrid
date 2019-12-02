<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VinculacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VinculacoesTable Test Case
 */
class VinculacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VinculacoesTable
     */
    public $Vinculacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Vinculacoes',
        'app.Sistemas',
        'app.Unidades',
        'app.Usuarios',
        'app.Papeis'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Vinculacoes') ? [] : ['className' => VinculacoesTable::class];
        $this->Vinculacoes = TableRegistry::getTableLocator()->get('Vinculacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Vinculacoes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
