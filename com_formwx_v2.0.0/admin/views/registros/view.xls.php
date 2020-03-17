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


class FormwxViewRegistros extends JViewLegacy
{
	
	function display($tpl = null)
	{
		
		
		
                $model = JModelLegacy::getInstance('Registros', 'FormwxModel');
                $app= JFactory::getApplication();
                //$app->input->set('list', array('limit'=>0)); //retirar o limite para exportação
                 
               
                
                $this->items		= $model->getItems();
                $this->setLayout('modal');
                
              
                
                if (count($errors = $this->get('Errors')))
		{
			JFactory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');

			return false;
		}
                
                
		
		// Display the template
                
                
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	
	
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_FORMWX_ADMINISTRATION'));
	}

	
	
}
