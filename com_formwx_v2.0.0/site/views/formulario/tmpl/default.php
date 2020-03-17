<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_formwx
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;
$tamanho_imagem = $this->params->get('tamanho_imagem');
$tamanho_info = $this->params->get('tamanho_info');
$page_title = $this->params->get('page_title');
$type_component=$this->input->get('tmpl')?"&tmpl=".$this->input->get('tmpl'):"";
$button_text= $this->item->button_text?$this->item->button_text:JText::_('COM_FORMWX_SEND_MAIL');

//echo "<pre>"; print_r($this->params); exit();
?>


<div class="formwx-container">
    <?php if ($this->params->get('show_page_heading')): ?>
        <div class="module" >
            <div class="outstanding-header">
                <h2 class="outstanding-title"><?php echo $this->params->get('page_heading', $page_title) ?></h2>
            </div>
        </div>
    <?php endif; ?>  
		


    <?php if ($this->item && $this->form) : ?>  
        <div class=" row-fluid">
            <div class="span<?php echo $tamanho_imagem; ?>">
                <?php
                if ($this->item->imagem):
                    echo JHtml::_('image', $this->item->imagem, '', array('align' => 'middle', 'class' => 'img-rounded'));
                endif;
                ?>
            </div>

            <div class="span<?php echo $tamanho_imagem?$tamanho_info:'12'; ?>">
                <?php echo $this->item->informacoes; ?>   
            </div>

        </div>




        <br>
        <form action="<?php echo JRoute::_("index.php?option=com_formwx$type_component"); ?>"
              method="post" name="adminForm" id="adminForm" class="form-validate well formwx-form module">
            <p class="formwx-info2"> <?php echo $this->item->outras_informacoes; ?></p><br>
            <div class="form-horizontal">
                <?php foreach ($this->form->getFieldsets() as $name => $fieldset): ?>
                    <fieldset class="adminform">

                        <div class="row-fluid">
                            <div class="">
                                <?php foreach ($this->form->getFieldset($name) as $field): ?>
                                    <div class="control-group">
                                        <div class="control-label"><?php echo $field->label; ?></div>
                                        <div class="controls"><?php echo $field->input; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </fieldset>
                <?php endforeach; ?>
                <div class="control-group">
                    <div class="controls">
                        <?php
                        if ($this->params->get('captch_ecc', 0)):
                            echo "{easycalccheckplus}";
                        endif;
                        ?>
                        <button class="button btn btn-primary" type="submit"><?php echo $button_text; ?></button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id_formulario" value="<?php echo $this->item->id ?>" />
            <input type="hidden" name="task" value="formulario.enviar" />
             
            <?php echo JHtml::_('form.token'); ?>
        </form>
        <div class="formwx-info_after_form">
             <?php echo $this->item->info_after_form; ?> 
        </div>
        

    <?php endif; ?>
        
       
   

</div>


<style>
    .direitos_autorais img{
        margin-left: 10px;
    }
    
    .row-fluid  .span0{
        display: none;
    }
</style>

<script>



    function getParamsUrl() {
        var queryString = window.location.search.slice(1).split("&");
        var hasQueryString = queryString[0] ? true : false;
        var result = {};
        queryString.forEach(function (keyValuePair) {
            if (keyValuePair[0]) {
                keyValuePair = keyValuePair.split('=');
                result[keyValuePair[0]] = decodeURI(keyValuePair[1]);
            }

        });

        return result;
    }

    function setValuesInForm() {
        let params = getParamsUrl();
        for (var key in params) {
            console.log(params[key]);
            if (params[key] != undefined) {
                var idSelect = '#jform_' + key;

                jQuery(idSelect).val(params[key]);
            }
        }
    }

    setValuesInForm();



</script>


