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

class FormwxControllerRegistros extends JControllerAdmin
{
	
	public function getModel($name = 'Registro', $prefix = 'FormwxModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
        
        
        public function exportar(){
            
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=registros.xls");
            header("Pragma: no-cache");
           
            $view = $this->getView( 'Registros', 'xls' );
            $view->display();
            
            exit();
        }
}
