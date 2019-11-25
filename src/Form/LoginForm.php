<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * Login Form.
 */
class LoginForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema)
    {
        return $schema
            ->addField('email', 'string')
            ->addField('senha', 'string');
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    //protected function _buildValidator(Validator $validator)
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('email', 'length', ['rule' => ['minLength', 10], 'message' => __('O campo e-mail é obrigatório !')])
            ->add('senha', 'length', ['rule' => ['minLength', 8], 'message' => __('O campo senha é obrigatório !')]);

        return $validator;
    }

    /**
     * Defines what to execute once the From is being processed
     *
     * @param array $data Form data.
     * @return bool
     */
    protected function _execute(array $data)
    {
        $isValid = $this->validate($data);
        if ( !$isValid) return false; else return true;
    }
}
