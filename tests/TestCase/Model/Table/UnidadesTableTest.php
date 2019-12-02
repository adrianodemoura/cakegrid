<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UnidadesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UnidadesTable Test Case
 */
class UnidadesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UnidadesTable
     */
    public $Unidades;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Unidades',
        'app.Vinculacoes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Unidades') ? [] : ['className' => UnidadesTable::class];
        $this->Unidades = TableRegistry::getTableLocator()->get('Unidades', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Unidades);

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
}
