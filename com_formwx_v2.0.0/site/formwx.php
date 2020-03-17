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


$controller = JControllerLegacy::getInstance('Formwx');
JLoader::register("FormularioHelper", JPATH_COMPONENT_SITE.'/helpers/formulario.php');
$document= JFactory::getDocument();
$document->addStyleSheet("components/com_formwx/assets/css/formwx.css");
// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
