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

class FormwxControllerCampo extends JControllerForm {

    protected function allowAdd($data = array()) {
        return parent::allowAdd($data);
    }

    public function add() {
        $app = JFactory::getApplication();
        $result = parent::add();

        if ($result) {
            $menuType = $app->getUserStateFromRequest($this->context . '.filter.id_formulario', 'id_formulario', '', 'cmd');
            $this->setRedirect(JRoute::_('index.php?option=com_formwx&view=campo&id_formulario=' . $menuType . $this->getRedirectToItemAppend(), false));
        }

        return $result;
    }
    
    public function save($key = null, $urlVar = null) {
       
        $app = JFactory::getApplication();
        $result =parent::save($key, $urlVar);
        $task     = $this->getTask();
        
        if ($result && $task=="save2new" ) {
            $menuType = $app->getUserStateFromRequest($this->context . '.filter.id_formulario', 'id_formulario', '', 'cmd');
            $this->setRedirect(JRoute::_('index.php?option=com_formwx&view=campo&id_formulario=' . $menuType . $this->getRedirectToItemAppend(), false));
        }

        return $result;
        
    }
    
   

}
