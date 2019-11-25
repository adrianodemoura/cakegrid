<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Usuario Entity
 *
 * @property int $id
 * @property string $email
 * @property string $senha
 */
class Usuario extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'email' => true,
        'senha' => true
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
}