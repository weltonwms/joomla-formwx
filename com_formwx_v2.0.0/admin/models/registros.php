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


class FormwxModelRegistros extends JModelList
{
	
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
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
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select(array('r.*', 'c.rotulo', 'c.descricao','c.nome','c.id_formulario','f.nome as nome_formulario'))
                   ->from($db->quoteName('#__formwx_registro','r'))
                   ->join('INNER', $db->quoteName('#__formwx_campo', 'c') . ' ON (' . $db->quoteName('r.id_campo') . ' = ' . $db->quoteName('c.id') . ')')
                   ->join('INNER', $db->quoteName('#__formwx_formulario', 'f') . ' ON (' . $db->quoteName('c.id_formulario') . ' = ' . $db->quoteName('f.id') . ')');         

		// Filter: like / search
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			$like = $db->quote('%' . $search . '%');
			$query->where('r.valor LIKE ' . $like. ' OR c.nome LIKE '. $like);
		}
                 $id_formulario = $this->getState('filter.id_formulario');
                 if ($id_formulario) {
                    $query->where("c.id_formulario = $id_formulario");
                }
                
                $id_campo = $this->getState('filter.id_campo');
                 if ($id_campo) {
                    $query->where("c.id = $id_campo");
                }

		
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'usuario');
		$orderDirn 	= $this->state->get('list.direction', 'asc');

		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
                //echo "<pre>"; print_r($query->__toString()); exit();
		return $query;
	}
       
        
        
}
