<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Exception;

/**
 * Instalacao command.
 */
class InstalacaoCommand extends Command
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

        try
        {
            $email = @$args->getArgumentAt(0);
            $senha = @$args->getArgumentAt(1);

            if ( !$email )
            {
                throw new Exception(__("e-mail inválido !"), 1);
            }
            if ( !$senha )
            {
                throw new Exception(__("senha inválida !"), 2);
            }

            $Usuario = $this->Usuarios->newEntity();
            $Usuario->email = $email;
            $Usuario->senha = $senha;

            if ( !$this->Usuarios->save($Usuario) )
            {
                $erros = $Usuario->getErrors();
                $this->log($erros);

                throw new Exception( __('Erro ao tentar salvar usuário, verifique os logs.'), 3);
            }

            echo "Usuário Administrador instalado com sucesso. abra o seu browser e acesse o sistema.";
        } catch (Exception $e)
        {
            echo $e->getCode().' - '.$e->getMessage();
        }


        echo "\n\n-- FIM \n\n";

    }
}
