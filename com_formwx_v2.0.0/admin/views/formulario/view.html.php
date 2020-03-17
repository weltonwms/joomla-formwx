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

class FormwxViewFormulario extends JViewLegacy
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
                
                $this->verificaFormPadrao();
                
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

		JToolBarHelper::title($isNew ? JText::_('COM_FORMWX_MANAGER_FORMULARIO_NEW')
		                             : JText::_('COM_FORMWX_MANAGER_FORMULARIO_EDIT'), 'formulario');
		
		JToolBarHelper::apply('formulario.apply', 'JTOOLBAR_APPLY');
		JToolBarHelper::save('formulario.save', 'JTOOLBAR_SAVE');
               
 		JToolBarHelper::cancel('formulario.cancel', 'JTOOLBAR_CLOSE');
		
	}
	
	protected function setDocument() 
	{
		$isNew = ($this->item->id == 0);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_FORMWX_FORMULARIO_CREATING')
		                           : JText::_('COM_FORMWX_FORMULARIO_EDITING'));
		
	}
        
        private function verificaFormPadrao(){
	   /*	
            if($this->item->id==1):
                $this->form->setFieldAttribute('nome', 'readonly', 'readonly');
            endif;
	*/
        }
}

