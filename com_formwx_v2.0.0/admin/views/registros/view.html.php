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
		
		
		// Get application
		$app = JFactory::getApplication();
                //echo "<pre>"; print_r($this->get('State')); exit('asdf');
		$context = "formwx.list.admin.registros";
		// Set the submenu
		FormwxHelper::addSubmenu('registros');
                $this->sidebar = JHtmlSidebar::render();
                //$modelRespostas = JModelLegacy::getInstance('Respostas', 'FormwxModel');
                //$this->items		= $modelRespostas->getItems();
               
                $this->items		= $this->get('Items');
                //echo "<pre>"; print_r($this->items); exit();
                $this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		$this->filter_order	= $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'usuario', 'cmd');
		$this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');
		$this->filterForm    	= $this->get('FilterForm');
		$this->activeFilters 	= $this->get('ActiveFilters');
                
                if (count($errors = $this->get('Errors')))
		{
			JFactory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');

			return false;
		}
                
                
		// Set the toolbar and number of found items
		$this->addToolBar();

		// Display the template
                
                
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	
	protected function addToolBar()
	{
		$title = JText::_('COM_FORMWX_VIEW_REGISTROS');

		

		JToolBarHelper::title($title);
		
		JToolBarHelper::custom('registros.exportar', 'download.png', 'save.png', 'Exportar', false);
                JToolBarHelper::deleteList('COM_FORMWX_CONFIRM_DELETE', 'registros.delete', 'JTOOLBAR_DELETE');
		if (JFactory::getUser()->authorise('core.admin', 'com_formwx')) 
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_formwx');
		}
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_FORMWX_ADMINISTRATION'));
	}

	
	
}
