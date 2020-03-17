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

class FormwxViewCampo extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $script;
	protected $canDo;

	
	public function display($tpl = null)
	{
		// Get the Data
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
   
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JFactory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');
			return false;
		}

		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	
	protected function addToolBar()
	{
		$input = JFactory::getApplication()->input;

		// Hide Joomla Administrator Main menu
		$input->set('hidemainmenu', true);

		$isNew = ($this->item->id == 0);

		JToolBarHelper::title($isNew ? JText::_('COM_FORMWX_MANAGER_CAMPO_NEW')
		                             : JText::_('COM_FORMWX_MANAGER_CAMPO_EDIT'), 'campo');
		
		JToolBarHelper::apply('campo.apply', 'JTOOLBAR_APPLY');
		JToolBarHelper::save('campo.save', 'JTOOLBAR_SAVE');
                 JToolBarHelper::custom('campo.save2new', 'save-new.png', 'save-new_f2.png','JTOOLBAR_SAVE_AND_NEW', false);
 		JToolBarHelper::cancel('campo.cancel', 'JTOOLBAR_CLOSE');
		
	}
	
	protected function setDocument() 
	{
		$isNew = ($this->item->id == 0);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_FORMWX_CAMPO_CREATING')
		                           : JText::_('COM_FORMWX_CAMPO_EDITING'));
		
	}
}

