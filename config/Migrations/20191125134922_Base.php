<?php
/**
 * Class Base
 *
 * @package     cakegrid.Config.Migrations
 */
use Migrations\AbstractMigration;
/**
 * Mantém o banco de dados inicial.
 *
 * $ bin/cake migrations create Base // este comando irá criar as tabelas, não rode aqui.
 * $ bin/cake migrations migrate
 * $ bin/cake migrations rollback
 * $ bin/cake migrations status
 */
class Base extends AbstractMigration {
    /**
     * Migrate Up.
     */
    public function up()
    {
        // tabela municípios
        $this->table('municipios')
            ->addColumn('nome',         'string', ['default' => '-', 'limit' => 100, 'null' => false])
            ->addColumn('uf',           'string', ['default' => '-', 'limit' => 2, 'null' => false])
            ->addColumn('codi_estd',    'string', ['default' => '-', 'limit' => 2,'null' => false])
            ->addColumn('desc_estd',    'string', ['default' => '-', 'limit' => 50, 'null' => false])
            ->addIndex(['uf', 'nome'])
            ->create();
        $this->updateMunicipios();

        $this->table('papeis')
            ->addColumn('nome',         'string', ['default' => '-', 'limit' => 100, 'null' => false])
            ->addColumn('ativo',        'boolean',['default' => true, 'null' => false])
            ->create(['nome']);
        $this->updatePapeis();

        $this->table('unidades')
            ->addColumn('nome',         'string', ['default' => '-', 'limit' => 100, 'null' => false])
            ->addColumn('ativo',        'boolean',['default' => true, 'null' => false])
            ->create(['nome']);
        $this->updateUnidades();

        // tabela usuários
        $this->table('usuarios')
            ->addColumn('nome',         'string', ['default' => '', 'limit' => 100, 'null' => false])
            ->addColumn('email',        'string', ['default' => '', 'limit' => 100, 'null' => false])
            ->addColumn('senha',        'string', ['default' => '', 'limit' => 100, 'null' => false])
            ->addColumn('ativo',        'boolean',['default' => true, 'null' => false])
            ->addColumn('ultimo_acesso','timestamp', ['default' => 0, 'null' => false])
            ->addColumn('municipio_id', 'integer',['default' => 3106200, 'limit' => 11, 'null' => false])
            ->addIndex(['municipio_id'])
            ->addIndex(['ativo'])
            ->create();
        $this->table('usuarios')
            ->addForeignKey('municipio_id', 'municipios', 'id', ['update' => 'CASCADE', 'delete' => 'CASCADE'])
            ->update();

        // tabela de recursos
        $this->table('recursos')
            ->addColumn('url',          'string',   ['default'=>'', 'limit'=>100, 'null'=>false])
            ->addColumn('titulo',       'string',   ['default'=>'', 'limit'=>100, 'null'=>false])
            ->addColumn('menu',         'string',   ['default'=>'', 'limit'=>100, 'null'=>false])
            ->addColumn('ativo',        'boolean',  ['default' => true, 'null' => false])
            ->addIndex(['url'])
            ->addIndex(['ativo'])
            ->create();
        $this->updateRecursos();

        $this->table('associacoes')
            ->addColumn('usuario_id',   'integer',  ['limit'=>11])
            ->addColumn('papel_id',     'integer',  ['limit'=>11])
            ->addColumn('unidade_id',   'integer',  ['limit'=>11])
            ->create();
        $this->table('associacoes')
            ->addForeignKey('usuario_id',   'usuarios', 'id',   ['update' => 'CASCADE', 'delete' => 'CASCADE'])
            ->addForeignKey('papel_id',     'papeis', 'id',     ['update' => 'CASCADE', 'delete' => 'CASCADE'])
            ->addForeignKey('unidade_id',   'unidades', 'id',   ['update' => 'CASCADE', 'delete' => 'CASCADE'])
            ->update();
        $this->updateAssociacoes();

        echo "\n";
    }
 
    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('associacoes')->drop()->save();
        $this->table('usuarios')->dropForeignKey('municipio_id')->save();
        $this->table('municipios')->drop()->save();
        $this->table('usuarios')->drop()->save();
        $this->table('recursos')->drop()->save();
        $this->table('papeis')->drop()->save();
        $this->table('unidades')->drop()->save();

        echo "\n";
    }

    /**
     */
    private function updateAssociacoes()
    {
        $this->execute('delete from associacoes');
        $table = $this->table('associacoes');

        $data   = [];
        $data[] = ['usuario_id'=>1, 'papel_id'=>1, 'unidade_id'=>1];
        $data[] = ['usuario_id'=>1, 'papel_id'=>1, 'unidade_id'=>2];
        $data[] = ['usuario_id'=>1, 'papel_id'=>1, 'unidade_id'=>3];

        $table->insert($data)->save();
    }

    /**
     * Atualiza a tabela de papeis
     *
     * @return  void
     */
    private function updatePapeis()
    {
        $this->execute('delete from papeis');
        $table = $this->table('papeis');

        $data   = [];
        $data[] = ['nome'=>'ADMINISTRADOR'];
        $data[] = ['nome'=>'SUPERVISOR'];
        $data[] = ['nome'=>'USUÁRIO'];
        $data[] = ['nome'=>'VISITANTE'];

        $table->insert($data)->save();
    }

    /**
     * Atualiza a tabela de papeis
     *
     * @return  void
     */
    private function updateUnidades()
    {
        $this->execute('delete from unidades');
        $table = $this->table('unidades');

        $data   = [];
        $data[] = ['nome'=>'GERAL'];
        $data[] = ['nome'=>'REGIONAL NORTE'];
        $data[] = ['nome'=>'REGIONAL LESTE'];

        $table->insert($data)->save();
    }

    /**
     * Atualiza a tabela de municipios
     *
     * @return  void
     */
    private function updateMunicipios()
    {
        $data   = [];
        $arq    = ROOT . DS . 'config' . DS . 'schema' . DS . 'municipios.csv';
        $csvFile= file($arq);
        foreach ($csvFile as $_l => $_linha)
        {
            if ($_l)
            {
                $arrCmps = str_getcsv($_linha);
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
                {
                    $arrCmps[1] = utf8_decode($arrCmps[1]);
                    $arrCmps[4] = utf8_decode($arrCmps[4]);
                }
                $data[] = 
                [
                    'id'        => (int)$arrCmps[0], 
                    'nome'      => trim($arrCmps[1]), 
                    'uf'        => trim($arrCmps[2]), 
                    'codi_estd' => (int)$arrCmps[3], 
                    'desc_estd' => trim($arrCmps[4])
                ];
            }
        }
        $this->execute('delete from municipios');
        $table = $this->table('municipios');
        $table->insert($data)->save();
    }

    /**
     * Atualiza a tabela de recursos
     *
     * @return  void
     */
    private function updateRecursos()
    {
        $this->execute('delete from recursos');
        $table = $this->table('recursos');

        $data   = [];
        $data[] = ['url'=>'/painel/index',         'titulo'=> 'Página inicial'];

        $data[] = ['url'=>'/usuarios/index',       'menu'=>'Cadastros', 'titulo'=> 'Usuários'];
        $data[] = ['url'=>'/municipios/index',     'menu'=>'Cadastros', 'titulo'=>'Municípios'];
        $data[] = ['url'=>'/auditorias/index',     'menu'=>'Cadastros', 'titulo'=>'Auditorias'];
        $data[] = ['url'=>'/usuarios/permissoes',  'titulo'=>'Permissões'];
        $data[] = ['url'=>'/usuarios/info',        'titulo'=>'Informações do Usuário'];

        $data[] = ['url'=>'/ferramentas/limpar-cache', 'menu'=>'Ferramentas', 'titulo'=>'Limpar Cache'];
        $data[] = ['url'=>'/ferramentas/recarregar-permissoes', 'menu'=>'Ferramentas', 'titulo'=>'Recarregar as Permissões'];
        $data[] = ['url'=>'/ferramentas/alterar-unidade', 'menu'=>'Ferramentas', 'titulo'=>'Alterar Unidade'];

        $data[] = ['url'=>'/relatorios/usuarios',  'menu'=>'Relatórios', 'titulo'=>'Usuários'];

        $data[] = ['url'=>'/ajuda/manual',         'menu'=>'Ajuda', 'titulo'=>'Manual'];
        $data[] = ['url'=>'/ajuda/sobre',          'menu'=>'Ajuda', 'titulo'=>'Sobre'];

        $table->insert($data)->save();
    }
}
