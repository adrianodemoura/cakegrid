<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Recurso Entity
 *
 * @property int $id
 * @property string $url
 * @property string $titulo
 * @property string $menu
 * @property int $ativo
 */
class Recurso extends Entity {
    /**
     * Accessibilidade aos campos
     *
     * @var array
     */
    protected $_accessible = 
    [
        'url'   => true,
        'titulo'=> true,
        'menu'  => true,
        'ativo' => true
    ];
}