<?php
/**
 * @package     Joomla.Administrator
 * @subpackage 
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die('Restricted access');
?>

<table>
    <tr>
        <td> <?php echo JText::_("COM_FORMWX_SEND_USER"); ?> </td>
        <td> <?php echo JText::_("COM_FORMWX_SEND_DATE"); ?> </td>
        <td> <?php echo JText::_("COM_FORMWX_FIELD_ID"); ?> </td>
        <td> <?php echo JText::_("COM_FORMWX_FORMULARIO_NOME_LABEL"); ?> </td>
       
        <td> <?php echo JText::_("COM_FORMWX_VALUE"); ?> valor</td>
        <td> <?php echo JText::_("COM_FORMWX_CAMPO_ID_FORMULARIO_LABEL"); ?> </td>
    </tr>

    <tbody>

        <?php foreach ($this->items as $item): ?>
            <tr>

                <td><?php echo $item->usuario ?></td>
                <td><?php echo $item->data ?></td>
                <td><?php echo $item->id_campo ?></td>
                <td><?php echo $item->nome ?></td>
                <td><?php echo $item->valor ?></td>
                <td><?php echo $item->nome_formulario ?></td>
            </tr>

        <?php endforeach; ?>

</table>


