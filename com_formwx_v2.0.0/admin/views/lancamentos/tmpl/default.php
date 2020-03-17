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
<form action="index.php?option=com_formwx&view=lancamentos" method="post" id="adminForm" name="adminForm">
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
        <div class="row-fluid">
            <button   type="button" id="exportar_xls" class="btn btn-success pull-right"><?php echo JText::_("COM_FORMWX_EXPORT_XLS"); ?></button><br><br>
        </div>

        <?php
        // Search tools bar
        echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this), null, array('debug' => false));
        ?> 
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="2%">
                        <?php echo JHtml::_('grid.checkall'); ?>
                    </th>
                    <?php foreach ($this->campos as $campo): ?>
                        <th><?php echo $campo->rotulo ?></th>
                    <?php endforeach; ?>
                    <th><?php echo JText::_("COM_FORMWX_SEND_DATE"); ?></th>
                    <th><?php echo JText::_("COM_FORMWX_SEND_USER"); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($this->items as $i => $reg):
                    $dados = json_decode($reg->dados);
                    ?>
                    <tr>
                        <td>
                            <?php echo JHtml::_('grid.id', $i, $reg->id); ?>
                        </td>
                        <?php foreach ($this->campos as $campo): ?>
                            <td>
                                <?php
                                $rotulo = $campo->rotulo;
                                echo $dados->$rotulo
                                ?>
                            </td>
                        <?php endforeach; ?>
                        <td><?php echo $reg->data ?></td>
                        <td><?php echo $reg->usuario ?></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr>
                    <?php $nr_colunas = count($this->campos) + 2 ?>
                    <td colspan="<?php echo $nr_colunas +1 ?>">
                        <?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>
            </tfoot>
        </table>

        <input type="hidden" name="task" value=""/>
        <input type="hidden" name="boxchecked" value="0"/>
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>


<script>
    jQuery("#exportar_xls").click(submeterExport);
    function submeterExport() {
        jQuery('#adminForm [name=task]').val('lancamentos.exportar');
        jQuery('#adminForm').submit();
        jQuery('#adminForm [name=task]').val(''); //limpar o export
    }
</script>



