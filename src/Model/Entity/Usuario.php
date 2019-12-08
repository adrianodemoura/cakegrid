<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Usuario Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $senha
 * @property bool $ativo
 * @property \Cake\I18n\FrozenTime $ultimo_acesso
 * @property int $municipio_id
 */
class Usuario extends Entity {
    /**
     * Campos que p odem ser atribuídos usando newEntity() or patchEntiry().
     *
     * Observe que quando '*' é definido para verdadeiro, isso permite todos os campos não especificado 
     * sejam atribuídos em massa. Por questões de segurança, é recomendável definir '*' como false ou removido
     * e configure cada campo individualmente.
     *
     * @var array
     */
    protected $_accessible =
    [
        'nome'              => true,
        'email'             => true,
        'senha'             => false,
        'ativo'             => true,
        'ultimo_acesso'     => true,
        'municipio_id'      => true
    ];

    /**
     * Alias para da campo.
     * 
     * @var     array
     */
    protected $_aliasField =
    [
        'Código'        => 'id',
        'Nome'          => 'nome',
        'Senha'         => 'senha',
        'Ativo'         => 'ativo',
        'Ult. Acesso'   => 'ultimo_acesso',
        'id Município'  => 'municipio_id'
    ];

    /**
     * Campos protegidos
     *
     * @var     array
     */
    protected $_hidden = ['senha'];

    /**
     * encriptando a senha
     */
    protected function _setSenha($senha)
    {
        return (new DefaultPasswordHasher)->hash($senha);
    }

    /**
     * Retorna a Descrição do campo ativo
     *
     * @return  string  string  Descrição do campo ativo.
     */
    protected function _getDativo()
    {
        $listaSimNao = [0=>'Não', 1=>'Sim'];

        return $listaSimNao[$this->ativo];
    }

    /**
     * Retorna a descrição do campo município_id.
     *
     * @return  string  $municipio  Descrição do campo município.
     */
    public function _getCidade()
    {
        return $this->municipio->nome . '/' . $this->municipio->uf;
    }
}
