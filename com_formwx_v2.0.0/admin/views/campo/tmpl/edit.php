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
JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
    Joomla.submitbutton = function (task)
    {

        if (task == 'campo.cancel' || document.formvalidator.isValid(document.id('adminForm')))
        {

            Joomla.submitform(task, document.getElementById('adminForm'));
        }

    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_formwx&layout=edit&id=' . (int) $this->item->id); ?>"
      method="post" name="adminForm" id="adminForm" class="form-validate">
    <div class="form-horizontal">
        <?php foreach ($this->form->getFieldsets() as $name => $fieldset): ?>
            <fieldset class="adminform">
                <legend><?php echo JText::_($fieldset->label); ?></legend>
                <p class="text-error">
                    <?php echo JText::_("COM_FORMWX_MESSAGE_SPECIAL_CARACTERES"); ?>
                </p>
                <div class="row-fluid">
                    <div class="span3">
                        <?php foreach ($this->form->getFieldset("details") as $field): ?>
                            <div class="control-group">
                                <div class="control-label"><?php echo $field->label; ?></div>
                                <div class="controls"><?php echo $field->input; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="span6">
                        <div id="listaOptions">
                            <h4> <?php echo JText::_("COM_FORMWX_LIST_OPTIONS"); ?></h4>
                            <btn class="btn btn-success" id="adicionar">
                                 <?php echo JText::_("COM_FORMWX_ADD"); ?> <i class="icon-plus"></i>
                            </btn>
                        </div>
                    </div>
                </div>
            </fieldset>
        <?php endforeach; ?>
    </div>
    <input type="hidden" name="task" value="campo.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>

<script>


    function addItemOption(item) {
        var labelNome=" <?php echo  JText::_("COM_FORMWX_NAME") ?>";
        var labelEmail=" <?php echo  JText::_("COM_FORMWX_EMAIL") ?>";
        var valNome = "";
        var valEmail = "";
        var tipo = jQuery('#jform_tipo').val();

        if (item) {
            valNome = item.nome;
            valEmail = item.email;

        }
        var itemList = '<div class="item-list">';
        itemList += '<input class="vl" type="text" placeholder="'+labelNome+'" name="nome" value="' + valNome + '" />';
        if (tipo == '1') {
            itemList += '<input class="vl" type="text" placeholder="'+labelEmail+'" name="email" value="' + valEmail + '" />';
        }
        itemList += '<a href="#" class="remove_field"><i class=" text-error icon-minus"></i></a>';
        itemList += '</div>';

        jQuery("#listaOptions").append(itemList); //add input box
    }


    function store() {
        var items = new Array();
        var item = null;
        var tipo = jQuery('#jform_tipo').val();
        jQuery('.item-list').each(function (i, elemento) {
            elemento = jQuery(elemento);
            item = new Object();
            item['nome'] = elemento.find('input[name=nome]').val();
             if (tipo == '1') {
                item['email'] = elemento.find('input[name=email]').val();
             }
            items[i] = item;

        });

        items = JSON.stringify(items);
        items = items.replace(/"/g, "|qq|");
        jQuery('#jform_options').val(items);

    }

    function callItemsList() {
        var items = jQuery.parseJSON(jQuery('#jform_options').val().replace(/\|qq\|/g, "\""));
        items = Array.isArray(items) ? items : [];//trasnformar em array vazio se não houver array.

        if (items.length) {
            jQuery(items).each(function (i, item) {
                addItemOption(item);
            });//fim each

        }// fim if(items.length)
    }//fim calllItemsList()


    function garbageOptions() {
        var tipo = jQuery('#jform_tipo').val();
        if (tipo != 'list' && tipo != 'radio' && tipo != '1') {
            jQuery("#jform_options").val('');
        }


    }

    function controlarVisibilidadeOptions() {
        var tipo = jQuery('#jform_tipo').val();
        if (tipo == 'list' || tipo == 'radio' || tipo == '1') {
            jQuery("#listaOptions").show();
        } else {
            jQuery("#listaOptions").hide();
        }
    }
    
    function limparListaOptions(){
        var tipo = jQuery('#jform_tipo').val();
        //if (tipo == '1') {
            jQuery("#listaOptions .item-list").remove();
        //} 
    }


    jQuery(document).ready(function () {
        callItemsList();
        controlarVisibilidadeOptions();

        jQuery("#adicionar").click(function (e) { //on add input button click
            addItemOption();
        });

        jQuery("#listaOptions").on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            jQuery(this).parent('div').remove();
            store();

        });

        jQuery(document).on('change', '.item-list input', function (e) {
            store();

        });

        jQuery(document).on('change', '#jform_tipo', function (e) {
            limparListaOptions();
            controlarVisibilidadeOptions();

        });

        jQuery(document).on('submit', '#adminForm', function (e) {
            garbageOptions();

        });
    }); //fim ready




</script>

