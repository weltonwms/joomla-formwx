<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class FormwxModelCampos extends JModelList {

    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id',
                'nome',
                'requerido',
                'rotulo',
                'tipo'
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
        // Initialize variables.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Create the base select statement.
        $query->select('c.id, c.nome,c.requerido, c.rotulo, c.tipo, c.id_formulario, f.nome as nome_formulario');
        $query->from($db->quoteName('#__formwx_campo', 'c'));
        $query->join('LEFT', $db->quoteName('#__formwx_formulario', 'f') . ' ON c.id_formulario = f.id');

        // Filter: like / search
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            $like = $db->quote('%' . $search . '%');
            $query->where('c.nome LIKE ' . $like);
        }

        $id_formulario = $this->getState('filter.id_formulario');
        if ($id_formulario) {
            $query->where("id_formulario = $id_formulario");
        }

        $requerido = $this->getState('filter.requerido');
        //var_dump($requerido); exit();
        if ($requerido != "") {
            $query->where("requerido = $requerido");
        }
        
        $tipo = $this->getState('filter.tipo');
        if ($tipo) {
            $query->where("tipo = '$tipo'");
        }



        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'nome');
        $orderDirn = $this->state->get('list.direction', 'asc');

        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

        return $query;
    }

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
