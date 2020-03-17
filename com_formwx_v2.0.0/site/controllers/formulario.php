<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_formwx
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class FormwxControllerFormulario extends JControllerForm {

    public function __construct() {
        parent::__construct();
    }

    public function enviar() {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        
       
        $id_formulario = $this->input->getString('id_formulario');
        $data = $this->input->post->get('jform', array(), 'array'); //dados preenhidos
        $formulario = FormularioHelper::getFormulario($id_formulario);
        $campos = FormularioHelper::getCamposFormulario($id_formulario);
        $emitirRecibo= $formulario->recibo===NULL?1:$formulario->recibo; //padrão é 1, ou seja null e qualquer coisa != de 0
        //var_dump($emitirRecibo); exit();
        $this->saveRegistroDatabase($campos, $data);
        $idRegistroJson= $this->saveRegistroJsonDatabase($campos, $data);
        
        $email_to = $this->getEmailTo($formulario, $campos, $data);
        $email_from= $this->getEmailFrom($formulario);
               
        $sent = $this->disparar_email($campos, $data, $email_to, $email_from);
        
        
        if (!($sent instanceof Exception)) {
            $msg = $formulario->feedback_message?$formulario->feedback_message:JText::_('COM_FORMWX_EMAIL_THANKS');
            if($idRegistroJson &&  $emitirRecibo){
                $formRecibo= $this->getFormRecibo($idRegistroJson);
                $msg.=$formRecibo;
            }
            
        } else {
            $msg = '';
        }
        $type_component=$this->input->get('tmpl')?"&tmpl=".$this->input->get('tmpl'):"";
        $this->setRedirect(JRoute::_("index.php?option=com_formwx&view=formulario&id_formulario=$id_formulario{$type_component}", false), $msg);
    }

    private function disparar_email($campos, $data, $email_to,$email_from) {
        $app = JFactory::getApplication();
        $sitename = $app->get('sitename');

        // Prepare email body
        $body = " ";
        $fieldMailValue='';
        foreach ($campos as $campo):
             $rotulo=$campo->rotulo;
                $value=$data[$campo->nome];
            if(strtolower($campo->nome)=="email" || strtolower($campo->nome)=="e-mail"){
                $fieldMailValue=$value;
                $fieldMailLink="mailto:$value";
                $body.= "<p>$rotulo: <a href='$fieldMailLink'>$value</a></p>";
            }
            else{
                $body .= "<p>$rotulo: $value </p>";
            }
            
        endforeach;
        
       //configurando a saída do email
        $mail = JFactory::getMailer();
        $mail->isHtml();
        $mail->addRecipient($email_to);
        if($fieldMailValue):
            //Com esse recurso é possível, caso o aplicativo de email implemente, responder a esse email, ao invés de responder ao usuário autenticado smtp
            $mail->AddReplyTo($fieldMailValue);
        endif;
        
        $mail->setSender($email_from);
        $mail->setSubject($sitename . ': '. JText::_('COM_FORMWX_MESSAGE'));
        $mail->setBody($body);
      
        //echo "<pre>"; print_r($mail); exit();
        $sent = $mail->Send();
        return $sent;
    }
    
    /**
     * O método getEmailTo() retorna o email de destino.
     * Caso haja um campo type1 é verificado o email correspondente a opção selecionada pelo usuario no post
     * Caso não haja type1 o email padrão descrito no formulario é retornado
     * @param stdClass $formulario
     * @param stdClass $campos
     * @param array $post
     * @return string
     */
    private function getEmailTo($formulario, $campos, $post) {

        $type1 = $this->getFirstType1($campos); //type1 representa o campo com opções de emails
        
        if ($type1):
            $options = json_decode(str_replace("|qq|", "\"", $type1->options));
            $nome_type1=$type1->nome;
            foreach ($options as $option):
                if($option->nome==$post[$nome_type1]):
                   return  $option->email;
                endif;
            endforeach;
        endif;
       
        return $formulario->email_to;
    }
    
    
    private function getEmailFrom($formulario){
    // print_r($formulario->informacoes); exit();
        
        $app = JFactory::getApplication();
        $mailfrom = $app->get('mailfrom');
        $fromname = $app->get('fromname');
        $user = JFactory::getUser();
       
        if($formulario->mail_from_auth && $user->email ):
            $mailfrom= $user->email;
            $fromname= null;
        endif;
        
        return [$mailfrom,$fromname];
        
    }
    

    /**
     * Type 1 representa campo de opções com diferentes destinos de emails
     * O método getFirstType1 retorna o primeiro campo que contem o type=1.
     * Se não houver nenhum type1 retorna false;
     */
    private function getFirstType1($campos) {
        // echo "<pre> type1"; print_r($campos); exit();
        foreach ($campos as $campo):
            if ($campo->tipo == 1) {
                return $campo;
            }
        endforeach;

        return false;
    }

    private function saveRegistroDatabase($campos, $post) {
        //echo "<pre>"; print_r($campos); print_r($post); exit();
        $model = $this->getModel();
        $model->saveRegistroDatabase($campos, $post);
    }
    
    /**
     * 
     * @param array $campos array com os campos do formulário
     * @param array $post arrray com o dados do formulário preenchidos pelo usuário
     * @return int  retorna o id do registro inserido ou false caso haja falha
     */
    private function saveRegistroJsonDatabase($campos, $post) {
       
        $model = $this->getModel();
        return $model->saveRegistroJsonDatabase($campos, $post);
        
    }
    
    public function recibo(){
        
         // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        $id_registro = $this->input->getString('registro');
       
        $model = $this->getModel();
        $registro= $model->getRegistro($id_registro);
        
        $view= $this->getView('recibo','html');
        $view->item= $registro;
        $view->display();
    }
    
    
    private function getFormRecibo($idRegistro){
        $form="<form action='". JRoute::_("index.php?option=com_formwx&tmpl=component", false)."' method='POST' target='_blank'>";
        $form.="<input type='hidden' name='task' value='formulario.recibo' />";
        $form.="<input type='hidden' name='registro' value='$idRegistro' />";
        $form.="<button class='btn btn-primary' type='submit'>".JText::_('COM_FORMWX_VIEW_RECIBO')."</button> ";
        $form.= JHtml::_('form.token');
        $form.="</form>";
       //echo($form); exit();
        return $form;
    }

}

