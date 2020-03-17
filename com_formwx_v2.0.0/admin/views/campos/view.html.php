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


class FormwxViewCampos extends JViewLegacy
{
	
	function display($tpl = null)
	{
		
		// Get application
		$app = JFactory::getApplication();
		$context = "formwx.list.admin.campos";
		// Get data from the model
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		$this->filter_order	= $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'nome', 'cmd');
		$this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');
		$this->filterForm    	= $this->get('FilterForm');
		$this->activeFilters 	= $this->get('ActiveFilters');

		//echo "<pre>"; print_r($this->items); exit();
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JFactory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');

			return false;
		}

		// Set the submenu
		FormwxHelper::addSubmenu('campos');
                $this->sidebar = JHtmlSidebar::render();

		// Set the toolbar and number of found items
		$this->addToolBar();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	
	protected function addToolBar()
	{
		$title = JText::_('COM_FORMWX_MANAGER_CAMPOS');

		if ($this->pagination->total)
		{
			//$title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
		}

		JToolBarHelper::title($title);
		JToolBarHelper::addNew('campo.add', 'JTOOLBAR_NEW');
		JToolBarHelper::editList('campo.edit', 'JTOOLBAR_EDIT');
		JToolBarHelper::deleteList('COM_FORMWX_CONFIRM_DELETE', 'campos.delete', 'JTOOLBAR_DELETE');
		
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
