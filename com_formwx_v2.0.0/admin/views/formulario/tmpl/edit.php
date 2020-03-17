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
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
    Joomla.submitbutton = function (task)
    {

        if (task == 'formulario.cancel' || document.formvalidator.isValid(document.id('adminForm')))
        {

            Joomla.submitform(task, document.getElementById('adminForm'));
        }

    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_formwx&layout=edit&id=' . (int) $this->item->id); ?>"
      method="post" name="adminForm" id="adminForm" class="form-validate">
    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
        <?php foreach ($this->form->getFieldsets() as $name => $fieldset): ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', $name, JText::_($fieldset->label)); ?>
           <?php if($name=="details"):?>
            <p class="text-error">
                <?php echo JText::_("COM_FORMWX_MESSAGE_SPECIAL_CARACTERES1"); ?>
            </p>
            <?php endif;?>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset($name) as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php endforeach; ?>
        <?php echo JHtml::_('bootstrap.endTabSet'); ?>
    </div>
    <input type="hidden" name="task" value="formulario.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>








