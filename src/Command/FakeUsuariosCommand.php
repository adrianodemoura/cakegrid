<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * FakeUsuario command.
 */
class FakeUsuariosCommand extends Command
{
    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/3.0/en/console-and-shells/commands.html#defining-arguments-and-options
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser)
    {
        $parser = parent::buildOptionParser($parser);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $this->loadModel('Usuarios');

        $total              = (int) $args->getArgumentAt(0);
        $listaMunicipios    = $this->Usuarios->Municipios->getLista();
        $totalMunicipios    = (count($listaMunicipios)-1);

        for($i=0; $i<$total; $i++)
        {
            $nome   = str_repeat("nome $i ", 100);
            $email  = str_repeat("email $i ", 100);
            $senha  = str_repeat("senha $i ", 100);

            $itemSorteado = rand(0,$totalMunicipios);

            $Usuario = $this->Usuarios->newEntity();
            $Usuario->nome  = $nome;
            $Usuario->email = $email;
            $Usuario->senha = $senha;
            $Usuario->ativo = rand(0,1);
            $Usuario->ultimo_acesso = rand(100000000,200000000);
            $Usuario->municipio_id  = array_keys($listaMunicipios)[$itemSorteado];

            if ( !$this->Usuarios->save($Usuario) )
            {
                debug($Usuario->erros());
            }

        }

        $totalUsuarios = $this->Usuarios->find()->count();

        echo "\nTotal de usuários salvo com sucesso: $total\nTotal Geral de Usuários: $totalUsuarios\n\n";
    }
}
