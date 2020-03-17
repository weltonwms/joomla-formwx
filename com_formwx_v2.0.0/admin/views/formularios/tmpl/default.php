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
<form action="index.php?option=com_formwx&view=formularios" method="post" id="adminForm" name="adminForm">
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
        <?php
        // Search tools bar
        echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array('filterButton' => false))); ?>
         
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
                        <th width="90%">
                            <?php echo JHtml::_('grid.sort', 'COM_FORMWX_FORMULARIOS_N0ME', 'nome', $listDirn, $listOrder); ?>
                        </th>

                        <th width="2%">
                            <?php echo JHtml::_('grid.sort', 'COM_FORMWX_ID', 'id', $listDirn, $listOrder); ?>
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

                    <?php
                    foreach ($this->items as $i => $row) :
                        $link = JRoute::_('index.php?option=com_formwx&view=campos&id_formulario=' . $row->id);
                        ?>
                        <tr>
                            <td><?php echo $this->pagination->getRowOffset($i); ?></td>
                            <td>
                                <?php echo JHtml::_('grid.id', $i, $row->id); ?>
                            </td>
                            <td>
                               <a href="<?php echo $link; ?>" >
                                  <?php echo $row->nome; ?>
                                </a>
                            </td>

                            <td align="center">
                                <?php echo $row->id; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        <?php endif; ?>
        <input type="hidden" name="task" value=""/>
        <input type="hidden" name="boxchecked" value="0"/>
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
        <?php echo JHtml::_('form.token'); ?>
</form>




