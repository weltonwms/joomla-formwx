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

class FormwxModelLancamentos extends JModelList {

    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id',
                'usuario',
                'id_formulario',
                'id_campo'
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to build an SQL query to load the list data.
     *
     * @return      string  An SQL query
     */
    protected function getListQuery() {
        $id_formulario = $this->getState('filter.id_formulario');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("*");
        $query->from($db->quoteName('#__formwx_registro_json'));

        if ($id_formulario):
            $query->where("id_formulario=$id_formulario");
        endif;

        // Filter: like / search
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            $like = $db->quote('%' . $search . '%');
            $query->where('dados LIKE ' . $like);
        }

        $query->order('data ASC');

        return $query;
    }

    public function getItems() {
        $id_formulario = $this->getState('filter.id_formulario');
        if ($id_formulario):
            return parent::getItems();
        endif;
        return array();
    }

    public function getCampos() {
        $id_formulario = $this->getState('filter.id_formulario');
        if ($id_formulario):
            JLoader::register('FormularioHelper', JPATH_COMPONENT_SITE . '/helpers/formulario.php');
            return FormularioHelper::getCamposFormulario($id_formulario);
        endif;
    }

    /**
     * Mesmo método do getListQuery(), porém usado sem paginação para exportar
     * @return type
     */
    public function getRegistrosJson() {
        $id_formulario = $this->getState('filter.id_formulario');
        if ($id_formulario):
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $query->select("*");
            $query->from($db->quoteName('#__formwx_registro_json'));
            $query->where("id_formulario=$id_formulario");
            $query->order('data ASC');


            $db->setQuery($query);
            $results = $db->loadObjectList();

            return $results;
        endif;
    }

    /**
     * Override importante para preservar o estado do id_formulario
     * @param type $ordering
     * @param type $direction
     */
    protected function populateState($ordering = null, $direction = null) {
        $app = JFactory::getApplication('administrator');
        $currentIdFormulario = $app->getUserState($this->context . '.id_formulario', '');
        $id_formulario = $app->input->getString('id_formulario', $currentIdFormulario);

        if ($id_formulario) {
            $app->setUserState($this->context . '.id_formulario', $id_formulario);
        } else {
            $app->setUserState($this->context . '.id_formulario', '');
        }

        $this->setState('filter.id_formulario', $id_formulario);


        parent::populateState($ordering, $direction);
    }

}
