<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_formwx
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class FormwxViewFormulario extends JViewLegacy
{
    protected $form; //formulário xml em si
    protected $item; // informações do formulario
    protected $params; // parametros da Aplicação 
            
	function display($tpl = null)
	{
          // Getting menu Param
            $this->params= JFactory::getApplication()->getParams();
            $this->input = JFactory::getApplication()->input;
            $this->form= $this->get('Form');
            $this->item=  $this->get('Item');
            
            
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

			return false;
		}

		parent::display($tpl);
	}
}
