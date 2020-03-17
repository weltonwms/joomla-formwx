<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_formwx
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

abstract class FormwxHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($submenu) {

        JHtmlSidebar::addEntry(
                JText::_('COM_FORMWX_MENU_FORMULARIOS'), 'index.php?option=com_formwx', $submenu == 'formularios'
        );

        JHtmlSidebar::addEntry(
                JText::_('COM_FORMWX_MENU_CAMPOS'), 'index.php?option=com_formwx&view=campos', $submenu == 'campos'
        );
         
        JHtmlSidebar::addEntry(
                JText::_('COM_FORMWX_MENU_REGISTROS'), 'index.php?option=com_formwx&view=registros', $submenu == 'registros'
        );
        JHtmlSidebar::addEntry(
                JText::_('COM_FORMWX_MENU_LANCAMENTOS'), 'index.php?option=com_formwx&view=lancamentos', $submenu == 'lancamentos'
        );
        
    }

    public static function excluirArquivosFormulario($formularios) {
        $path = JPATH_COMPONENT_SITE . "/models/forms/";
        $num_delete = 0;
        foreach ($formularios as $formulario):
             
            $arquivo = $path . $formulario->nome . $formulario->id . ".xml";
        
            if (file_exists($arquivo) ):
               
                unlink($arquivo);
                $num_delete++;
            endif;
        endforeach;
        
        return $num_delete;
    }

}
