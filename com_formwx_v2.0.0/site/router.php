<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_formwx
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class FormwxRouter extends JComponentRouterBase{
    public function build(&$query) {
         $segments = array();
         //echo "<pre>"; print_r($query); exit();
       if (isset($query['view']))
       {
                $segments[] = $query['view'];
                unset($query['view']);
       }
       if (isset($query['id_formulario']))
       {
                $segments[] = $query['id_formulario'];
                unset($query['id_formulario']);
       }
      
       return $segments;
    }

    public function parse(&$segments) {
        $vars = array();
        
       switch($segments[0])
       {
              case 'formulario':
              $vars['view'] = 'formulario';
              if(isset($segments[1])):
                 $id = explode(':', $segments[1]);
                 $vars['id_formulario'] = (int) $id[0];
              endif;
               break;
               
       }
       return $vars;
    }

}

