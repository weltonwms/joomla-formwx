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


$currentLanguage = JFactory::getLanguage();
$tag=$currentLanguage->getTag();
$format_date= $tag=="pt-BR"?'d/m/Y H:i:s':'Y-m-d H:i:s';
?>


<div class="formwx-container">
 
    <h2><?php echo JText::_('COM_FORMWX_RECIBO');?></h2>
   
    
   
    <button onClick="window.print()" class="noprint btn btn-default"> 
        <span class="icon-print" aria-hidden="true"></span> <?php echo JText::_('COM_FORMWX_PRINT');?>
    </button>
    <?php if($this->item):
        $dados= json_decode($this->item->dados);
     ?>
    
    <p><b><?php echo JText::_('COM_FORMWX_ENVIADO_EM');?> :</b> <?php echo JHtml::_('date', $this->item->data, $format_date, null);  ?> </p>
    
    <?php if($this->item->usuario):?>
    <p><b><?php echo JText::_('COM_FORMWX_USER');?> :</b> <?php echo $this->item->usuario;  ?> </p>
    <?php endif;?>
    
    <?php foreach($dados as $key=>$valor):?>
     <p><b><?php echo $key?> :</b> <?php echo $valor;  ?> </p>
    
    
    
    <?php endforeach;?>
    
   
    
    
    <?php endif;?>
</div>


<style type="text/css">
    @media print {
      .noprint { display: none; }
    }
  </style>
  
  <script>
      window.onload=function(){
          window.print();
      };
  </script>


