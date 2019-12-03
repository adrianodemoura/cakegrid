<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Log\Log;

/**
 * PermissoesUsuario command.
 */
class PermissoesUsuarioCommand extends Command {

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

        $idUsuario      = (int) $args->getArgumentAt(0);
        $permissoes     = $this->Usuarios->getPermissoes($idUsuario);

        $this->log($permissoes, 'debug');
    }
}
