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

class FormularioHelper {

    private static function getFormXml($campos_formulario) {
        
        $form = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><form/> ');
	$currentLanguage = JFactory::getLanguage();
        $fieldset = $form->addChild('fieldset');
        $fieldset->addAttribute("name", 'details');
        foreach ($campos_formulario as $item) {
            $requerido = $item->requerido ? "true" : "false";
            $descricao = $item->descricao ? $item->descricao : $item->rotulo;
            $campo = $fieldset->addChild('field');
            $campo->addAttribute('name', $item->nome);
            $campo->addAttribute('id', $item->nome);
            $campo->addAttribute('label', $item->rotulo);
            $campo->addAttribute('description', $descricao);
            $tipo=$item->tipo==1?'list':$item->tipo;
            $campo->addAttribute('type', $tipo);
            $campo->addAttribute('required', $requerido);
            if($item->tipo=='calendar' && $currentLanguage->getTag()=="pt-BR"):
                $campo->addAttribute('format','%d/%m/%Y');
                $campo->addAttribute('class','dateBR validate');
                
            endif;
            
            if($item->tipo=='list' || $item->tipo=='radio' || $item->tipo==1):
                self::addOptionXml($campo,$item);
            endif;
        }
//       header('Content-type: text/xml');
//        echo $form->asXML(); exit();
        return $form;
    }
    
    private static function addOptionXml($campo,$item){
        $optionsArray= json_decode(str_replace("|qq|", "\"", $item->options));
        if($item->tipo==1):
            $option=$campo->addChild('option',JText::_('COM_FORMWX_SELECT_OPTION'));
            $option->addAttribute('value',"");
        endif;
        
        foreach($optionsArray as $option):
            $nome=$option->nome;
            $option=$campo->addChild('option',$nome);
            $option->addAttribute('value',$nome);
        endforeach;
    }

    private static function storeXml($xml, $nome_formulario) {
        $path = JPATH_COMPONENT_SITE . "/models/forms/";
        return $xml->asXML($path . $nome_formulario . ".xml");
    }

    public static function SalvarXml($id_formulario, $nome_formulario) {
        $camposFormulario = self::getCamposFormulario($id_formulario);
        $form_xml = self::getFormXml($camposFormulario);
        return self::storeXml($form_xml, $nome_formulario);
    }

    public static function teste() {
        exit('teste helper');
    }

     /*
     * retorna todos os campos de um formulario. A leitura é feita a partir
     * do banco de dados.
     */
    public static function getCamposFormulario($id_formulario) {
	/*
        if ($id_formulario == 1):
            return self::getCamposFormularioPadrao();
        endif;
	*/
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')
                ->from('#__formwx_campo')
                ->where('id_formulario=' . (int) $id_formulario)
                ->order('id ASC');
        $db->setQuery((string) $query);
        return $db->loadObjectList();
    }
    
    public static function getFormulario($id_formulario) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')
                ->from('#__formwx_formulario')
                ->where('id=' . (int) $id_formulario);
                
        $db->setQuery((string) $query);
        return $db->loadObject();
    }

    /*
     * retorna todos os campos do formulario padrao. A leitura é feita a partir
     * de um XML.
     */
    private static function getCamposFormularioPadrao() {
        $lista = array();
        $xml = simplexml_load_file(JPATH_COMPONENT_SITE . "/models/forms/padraofab.xml");

        foreach ($xml->fieldset[0]->field as $field):
            $objeto = new stdClass();
            $objeto->id = null;
            $objeto->nome = (string) $field['name'];
            $objeto->rotulo = (string) $field['label'];
            $objeto->descricao = (string) $field['description'];
            $objeto->requerido = (string) $field['required'];
            $objeto->id_formulario = 1;
            $lista[] = $objeto;

        endforeach;
        return $lista;
    }

}


