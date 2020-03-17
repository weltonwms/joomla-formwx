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

JHtml::_('formbehavior.chosen', 'select');

$listOrder = $this->escape($this->filter_order);
$listDirn = $this->escape($this->filter_order_Dir);
?>
<form action="index.php?option=com_formwx&view=registros" method="post" id="adminForm" name="adminForm">
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
        <?php
        // Search tools bar
        echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array())); ?>
          <?php if (empty($this->items)) : ?>
            <div class="alert alert-no-items">
                <?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
            </div>
        <?php else : ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="1%"><?php echo JText::_('COM_FORMWX_NUM'); ?></th>
                         <th width="2%">
                            <?php echo JHtml::_('grid.checkall'); ?>
                        </th>
                        
                        <th width="10%">
                            <?php echo JHtml::_('grid.sort', 'COM_FORMWX_SEND_DATE', 'usuario', $listDirn, $listOrder); ?>
                        </th>
                        
                       
                        <th width="10%">
                            <?php echo JHtml::_('grid.sort', 'COM_FORMWX_SEND_DATE', 'data', $listDirn, $listOrder); ?>
                        </th>
                        
                        
                        
                        <th width="1%">
                            <?php echo JHtml::_('grid.sort', 'COM_FORMWX_FIELD_ID', 'id_campo', $listDirn, $listOrder); ?>
                        </th>
                        
                         <th width="10%" >
                            <?php echo JHtml::_('grid.sort', 'COM_FORMWX_FORMULARIO_NOME_LABEL', 'nome', $listDirn, $listOrder); ?>
                        </th>
                        
                        <th >
                            <?php echo JHtml::_('grid.sort', 'COM_FORMWX_VALUE', 'valor', $listDirn, $listOrder); ?>
                        </th>
                        
                         <th width="5%">
                            <?php echo JHtml::_('grid.sort', 'COM_FORMWX_CAMPO_ID_FORMULARIO_LABEL', 'formulario', $listDirn, $listOrder); ?>
                        </th>

                       
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <?php echo $this->pagination->getListFooter(); ?>
                        </td>
                    </tr>
                </tfoot>
                <tbody>

                 <?php foreach ($this->items as $i=>$item):?>
                    <tr>
                        
                        <td><?php echo $this->pagination->getRowOffset($i); ?></td>
                        <td><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
                        <td><?php echo $item->usuario?></td>
                      
                        <td><?php echo $item->data?></td>
                        <td><?php echo $item->id_campo?></td>
                        <td><?php echo $item->nome?></td>
                        <td><?php echo $item->valor?></td>
                         <td><?php echo $item->nome_formulario?></td>
                       
                    </tr>
                    
                    <?php                    endforeach;?>

                </tbody>
            </table>
        <?php endif; ?>
        
        <input type="hidden" name="task" value=""/>
        <input type="hidden" name="boxchecked" value="0"/>
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
        <?php echo JHtml::_('form.token'); ?>
</form>



