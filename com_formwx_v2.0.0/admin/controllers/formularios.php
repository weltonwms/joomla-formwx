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
use Joomla\Utilities\ArrayHelper;

class FormwxControllerFormularios extends JControllerAdmin
{
	
	public function getModel($name = 'Formulario', $prefix = 'FormwxModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
        
        public function duplicate(){
            // Check for request forgeries
		$this->checkToken();

		$pks = $this->input->post->get('cid', array(), 'array');
		$pks = ArrayHelper::toInteger($pks);

		try
		{
			if (empty($pks))
			{
				throw new Exception(JText::_("COM_FORMWX_FORMULARIO_NOT_SELECT"));
			}

			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(JText::_(count($pks)." ".JText::_("COM_FORMWX_FORMULARIO_DUPLICADO")));
		}
		catch (Exception $e)
		{
              		JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
			
		}
                

		$this->setRedirect('index.php?option=com_formwx&view=formularios');
        }
}
