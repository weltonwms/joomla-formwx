<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_formwx
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class FormwxModelFormulario extends JModelAdmin {

    public function getTable($type = 'Formulario', $prefix = 'JTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true) {
        // Get the form.
        $form = $this->loadForm(
                'com_formwx.formulario', 'formulario', array(
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

    public function delete(&$pks) {
        $retorno1 = $this->verificaFormPadrao($pks);
        //echo "<pre>"; print_r($pks); exit();

        if ($retorno1):
            $formularios = $this->getFormularios($pks);

            if (parent::delete($pks)) {
                FormwxHelper::excluirArquivosFormulario($formularios);
                return $this->deletarCamposFormularios($pks);
            }
        endif;
        return FALSE;
    }

    private function verificaFormPadrao($pks) {
	/*
        if (in_array(1, $pks)):
            $this->setError("Não é possível excluir o Formulario Padrão! ");
            return false;
        endif;
	*/
        return true;
    }

    private function deletarCamposFormularios(&$pks) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $ids_implodidos = implode(',', $pks);
        $query->delete($db->quoteName('#__formwx_campo'));
        $query->where("id_formulario IN ($ids_implodidos)");
        $db->setQuery($query);
        return $db->execute();
    }

    private function getFormularios($pks) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $ids_implodidos = implode(',', $pks);
        $query->select('*');
        $query->from($db->quoteName('#__formwx_formulario'));
        $query->where("id IN ($ids_implodidos)");
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    public function validate($form, $data, $group = null) {
        $data['nome'] = JFilterOutput::stringURLSafe($data['nome']);
        //echo "<pre>"; print_r($data); exit();
        return parent::validate($form, $data, $group);
    }

    public function duplicate(&$pks) {

        $user = JFactory::getUser();
        $db = $this->getDbo();

        // Access checks.
        if (!$user->authorise('core.create', 'com_formwx')) {
            throw new Exception(JText::_('JERROR_CORE_CREATE_NOT_PERMITTED'));
        }

        $table = $this->getTable();

        foreach ($pks as $pk):
	    /*		
            if($pk==1):
                throw new Exception(JText::_('Não é possível duplicar o formulário padrão'));
            endif;
            */
            if ($table->load($pk, true)):
                // Reset the id to create a new record.
                $table->id = 0;

                // Alter the title.
                $m = null;

                if (preg_match('#\((\d+)\)$#', $table->nome, $m)) {
                    $table->nome = preg_replace('#\(\d+\)$#', '(' . ($m[1] + 1) . ')', $table->nome);
                } else {
                    $table->nome = $table->nome . "(1)";
                }

                if (!$table->check() || !$table->store()) {
                    throw new Exception($table->getError());
                }
                //quando $table acionou o store() recebeu um novo id

                $query = $db->getQuery(true)
                        ->select("*")
                        ->from($db->quoteName('#__formwx_campo'))
                        ->where($db->quoteName('id_formulario') . ' = ' . (int) $pk);
                $db->setQuery($query);
                $rows = $db->loadObjectList(); //linhas a serem copiadas
                $this->duplicaCampos($rows, $table);

            else :
                throw new Exception($table->getError());
            endif;

        endforeach;

        return true;
    }

    /**
     * Cria novos campos
     * @param array $rows campos a serem duplicados
     * @param Object $table formulario dos campos a serem duplicados
     * @return boolean
     */
    private function duplicaCampos($rows, $table) {
        $tuples = [];
        $columns = ['nome', 'tipo', 'options', 'rotulo', 'descricao', 'requerido', 'id_formulario'];
        $db = $this->getDbo();
        foreach ($rows as $row) {
            $values = [
                $db->quote($row->nome),
                $db->quote($row->tipo),
                $db->quote($row->options),
                $db->quote($row->rotulo),
                $db->quote($row->descricao),
                $db->quote($row->requerido),
                $table->id
            ];
            $tuples[] = implode(",", $values);
        }


        $query = $db->getQuery(true)
                ->insert($db->quoteName('#__formwx_campo'))
                ->columns($db->quoteName($columns))
                ->values($tuples);

        $db->setQuery($query);
        try {
            $db->execute();
        } catch (RuntimeException $e) {
	    return JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }
        return true;
    }

}
