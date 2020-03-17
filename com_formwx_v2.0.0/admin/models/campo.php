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


class FormwxModelCampo extends JModelAdmin
{
	
	public function getTable($type = 'Campo', $prefix = 'JTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
			'com_formwx.campo',
			'campo',
			array(
				'control' => 'jform',
				'load_data' => $loadData
			)
		);

		if (empty($form))
		{
			return false;
		}

		return $form;
	}
	
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState(
			'com_formwx.edit.campo.data',
			array()
		);

		if (empty($data)):
		
			$data = $this->getItem();
                        $x=JFactory::getApplication()->input->get("id_formulario",'');
                        if(!$data->get('id_formulario')){
                             $data->set('id_formulario', $x);
                        }
               
		endif;
               
                
		return $data;
	}
        
        public function validate($form, $data, $group = null) {
            $data['nome']=  JFilterOutput::stringURLSafe($data['nome']);
            return parent::validate($form, $data, $group);
        }
        

	
}
