<?php

/**
 * @package     Joomla.Site
 * @subpackage  Formwx
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

class FormwxModelFormulario extends JModelForm {

    private $item;

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->setItem();
    }

    public function getForm($data = array(), $loadData = true) {
        if (!isset($this->item->id)) {
            return false;
        }

        
        
            $nome_formulario = $this->item->nome . $this->item->id;
            FormularioHelper::SalvarXml($this->item->id, $nome_formulario);
        

        // Get the form.
        $form = $this->loadForm(
                'com_formwx.formulario', "$nome_formulario", array(
            'control' => 'jform',
            'load_data' => $loadData
                )
        );

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    protected function loadFormData() {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState(
                'com_formwx.edit.formulario.data', array()
        );

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    public function getItem() {
        return $this->item;
    }

    private function setItem() {
        $id_formulario = JFactory::getApplication()->input->get('id_formulario');
        if($id_formulario):
             $db = JFactory::getDbo();
             $query = $db->getQuery(true);
             $query->select("*");
             $query->from("#__formwx_formulario");
             $query->where("id=$id_formulario");
             $db->setQuery($query);
            $this->item = $db->loadObject();
        endif;
       
    }

    public function saveRegistroDatabase($campos, $post) {
        $user = JFactory::getUser();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $columns = array('id_campo', 'valor', "usuario", 'data');
        $values = array();


        foreach ($campos as $campo):
            $id_campo = $db->quote($campo->id);
            $value_campo = $db->quote(isset($post[$campo->nome]) ? $post[$campo->nome] : '');
            $usuario = $user->id ? $user->username . "($user->name)" : '';
            $data = date("Y-m-d H:i:s");
            $values[] = "$id_campo, $value_campo, '$usuario', '$data' ";
        endforeach;

        $query->insert($db->quoteName('#__formwx_registro'));
        $query->columns($columns);
        $query->values($values);
        $db->setQuery($query);
        $db->query();
    }

    public function saveRegistroJsonDatabase($campos, $post) {
        
        $id_formulario=0;
        $data = [];
        foreach ($campos as $campo):
            $data[$campo->rotulo] = $post[$campo->nome];
            $id_formulario=$campo->id_formulario;
        endforeach;
       
        $dadosJson = json_encode($data);

        $dados = new stdClass(); //dados gerais a serem gravados no banco
        $user = JFactory::getUser();
        $dados->usuario = $user->id ? $user->username . "($user->name)" : '';
        $dados->data = date("Y-m-d H:i:s");
        $dados->dados = $dadosJson; // dados json dentro de dados gerais
        $dados->id_formulario= $id_formulario;

        $db = JFactory::getDbo();

        $result = $db->insertObject('#__formwx_registro_json', $dados);
        if ($result):
            return $db->insertid(); //retornando o id da inclusão
        endif;

        return false; // retorno falso caso não haja incusão de registro com sucesso
    }
    
    
    public function getRegistro($id_registro){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("*");
        $query->from("#__formwx_registro_json");
        $query->where("id=$id_registro");
        $db->setQuery($query);
        return $db->loadObject();
    }

}

