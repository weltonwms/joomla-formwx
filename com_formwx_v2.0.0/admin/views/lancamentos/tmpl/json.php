<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

?>

<table class="table table-bordered">
    <thead>
        <tr>
            <?php foreach ($this->campos as $campo): ?>
            <th><?php echo $campo->rotulo?></th>

            <?php endforeach; ?>
            <th><?php echo JText::_("COM_FORMWX_SEND_DATE"); ?></th>
            <th><?php echo JText::_("COM_FORMWX_SEND_USER"); ?></th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($this->items as $reg):
            $dados= json_decode($reg->dados);
            
         ?>
        <tr>
            <?php foreach($this->campos as $campo):?>
            <td><?php $rotulo=$campo->rotulo; echo $dados->$rotulo?></td>
            <?php             endforeach;?>
             <td><?php echo $reg->data?></td>
             <td><?php echo $reg->usuario?></td>
        </tr>
        
        <?php endforeach;?>
    </tbody>
</table>




