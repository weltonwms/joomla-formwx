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

// Receive overridable options
$data['options'] = !empty($data['options']) ? $data['options'] : array();

if ($data['view'] instanceof MenusViewItems)
{
	$doc = JFactory::getDocument();

	$doc->addStyleDeclaration("
		/* Fixed filter field in search bar */
		.js-stools .js-stools-menutype {
			float: left;
			margin-right: 10px;
			min-width: 220px;
		}
		html[dir=rtl] .js-stools .js-stools-menutype {
			float: right;
			margin-left: 10px
			margin-right: 0;
		}
		.js-stools .js-stools-container-bar .js-stools-field-filter .chzn-container {
			padding: 3px 0;
		}
	");

	// Menutype filter doesn't have to activate the filter bar
	unset($data['view']->activeFilters['menutype']);
}

// Display the main joomla layout
$version=new JVersion();
if(version_compare($version->getShortVersion(), "3.7.0",'<')):
    echo JLayoutHelper::render('joomla.searchtools.default', $data, null, array('component' => 'none'));
else:
    // Set some basic options
$customOptions = array(
	'filtersHidden'       => isset($data['options']['filtersHidden']) ? $data['options']['filtersHidden'] : empty($data['view']->activeFilters),
	'defaultLimit'        => isset($data['options']['defaultLimit']) ? $data['options']['defaultLimit'] : JFactory::getApplication()->get('list_limit', 20),
	'searchFieldSelector' => '#filter_search',
	'orderFieldSelector'  => '#list_fullordering',
	'totalResults'        => isset($data['options']['totalResults']) ? $data['options']['totalResults'] : -1,
	'noResultsText'       => isset($data['options']['noResultsText']) ? $data['options']['noResultsText'] : JText::_('JGLOBAL_NO_MATCHING_RESULTS'),
);

$data['options'] = array_merge($customOptions, $data['options']);
$filtersClass = isset($data['view']->activeFilters) && $data['view']->activeFilters ? ' js-stools-container-filters-visible' : '';
    JHtml::_('searchtools.form', '#adminForm', $data['options']);
?>
<div class="js-stools clearfix">
	<div class="clearfix">
		<div class="js-stools-container-bar">
			<?php echo JLayoutHelper::render('joomla.searchtools.default.bar', $data); ?>
		</div>
                <div class="js-stools-container-list hidden-phone hidden-tablet">
			<?php echo JLayoutHelper::render('joomla.searchtools.default.list', $data); ?>
		</div>
		
	</div>
    
    <!-- Filters div -->
	<div class="js-stools-container-filters hidden-phone clearfix<?php echo $filtersClass; ?>">
		<?php echo JLayoutHelper::render('joomla.searchtools.default.filters', $data); ?>
	</div>
	
</div>
<?php endif;?>
