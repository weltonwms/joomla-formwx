<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$data = $displayData;
//importante para as views que utilizem esse layout
if ($data['view'] instanceof FormwxViewCampos || $data['view'] instanceof FormwxViewLancamentos )
{
	// We will get the menutype filter & remove it from the form filters
	$menuTypeField = $data['view']->filterForm->getField('id_formulario');
?>
	<div class="js-stools-field-filter js-stools-menutype">
		<?php echo $menuTypeField->input; ?>
	</div>
<?php
}

// Display the main joomla layout
echo JLayoutHelper::render('joomla.searchtools.default.bar', $data, null, array('component' => 'none'));
