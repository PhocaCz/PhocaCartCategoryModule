<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

defined('_JEXEC') or die;// no direct access

use Joomla\CMS\HTML\HTMLHelper;

if (!JComponentHelper::isEnabled('com_phocacart', true)) {
	$app = JFactory::getApplication();
	$app->enqueueMessage(JText::_('Phoca Cart Error'), JText::_('Phoca Cart is not installed on your system'), 'error');
	return;
}

JLoader::registerPrefix('Phocacart', JPATH_ADMINISTRATOR . '/components/com_phocacart/libraries/phocacart');

$lang = JFactory::getLanguage();
//$lang->load('com_phocacart.sys');
$lang->load('com_phocacart');

$media = PhocacartRenderMedia::getInstance('main');
$media->loadBase();
$media->loadBootstrap();
$media->loadSpec();
$media->loadJsTree();
$s = PhocacartRenderStyle::getStyles();
$document	= JFactory::getDocument();

$p['category_ordering']		= $params->get( 'category_ordering', 1 );
$moduleclass_sfx 			= htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

$display_categories = $params->get('display_categories', '');
$hide_categories 	= $params->get('hide_categories', '');

if (!empty($display_categories)) {
	$display_categories = implode(',', $display_categories);
}
if (!empty($hide_categories)) {
	$hide_categories = implode(',', $hide_categories);
}

$filter_language	= $params->get( 'filter_language', 0 );
$language = '';
if ($filter_language == 1) {
	//$lang 		= JFactory::getLanguage();
	$language	= $lang->getTag();
}


$tree 		= PhocacartCategory::getCategoryTreeFormat($p['category_ordering'], $display_categories, $hide_categories, array(0 ,1), $language);

$js	  = array();
$js[] = ' ';
$js[] = 'jQuery(function () {';
$js[] = '   jQuery("#phjstree").jstree({';
$js[] = '      "core": {';
$js[] = '         "themes": {';
$js[] = '            "name": "proton",';
$js[] = '            "responsive": true';
$js[] = '         }';
$js[] = '      }';
$js[] = '   }).on("select_node.jstree", function (e, data) {';
$js[] = '      document.location = data.instance.get_node(data.node, true).children("a").attr("href");';
$js[] = '   });';
$js[] = '   ';
$js[] = '   jQuery("#phjstree").on("changed.jstree", function (e, data) {';
//$js[] = '      con sole.log(data.selected);';
$js[] = '   });';
$js[] = '   ';
$js[] = '   jQuery("button").on("click", function () {';
$js[] = '      jQuery("#phjstree").jstree(true).select_node("child_node_1");';
$js[] = '      jQuery("#phjstree").jstree("select_node", "child_node_1");';
$js[] = '      jQuery.jstree.reference("#phjstree").select_node("child_node_1");';
$js[] = '   });';
$js[] = '});';
$js[] = ' ';

$document->addScriptDeclaration(implode("\n", $js));

require(JModuleHelper::getLayoutPath('mod_phocacart_category'));
?>
