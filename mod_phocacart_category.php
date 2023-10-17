<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

defined('_JEXEC') or die;// no direct access
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Helper\ModuleHelper;

if (!ComponentHelper::isEnabled('com_phocacart', true)) {
	$app = Factory::getApplication();
	$app->enqueueMessage(Text::_('Phoca Cart Error'), Text::_('Phoca Cart is not installed on your system'), 'error');
	return;
}

JLoader::registerPrefix('Phocacart', JPATH_ADMINISTRATOR . '/components/com_phocacart/libraries/phocacart');

$lang = Factory::getLanguage();
//$lang->load('com_phocacart.sys');
$lang->load('com_phocacart');

$app = Factory::getApplication();
$wa  = $app->getDocument()->getWebAssetManager();

$p['category_ordering']		= $params->get( 'category_ordering', 1 );
$p['simple_layout']			= $params->get( 'simple_layout', 0 );
$moduleclass_sfx 			= htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_COMPAT, 'UTF-8');

$media = PhocacartRenderMedia::getInstance('main');
$media->loadBase();
$media->loadBootstrap();
$media->loadSpec();
if ($p['simple_layout']	== 0) {
	$media->loadJsTree();
	$format = 'js';
} else {
	$wa->registerAndUseStyle('com_phocacart.jstree', 'media/com_phocacart/js/jstree/themes/simple/style.min.css');
	$format = 'simple';
}

$s = PhocacartRenderStyle::getStyles();
$document	= Factory::getDocument();



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
	//$lang 		= Factory::getLanguage();
	$language	= $lang->getTag();
}

$treeId = uniqid( "phjstree" );

$cacheid = md5($module->id . '-' . PhocacartCategory::getActiveCategoryId());
$cacheparams               = new \stdClass();
$cacheparams->cachemode    = 'id';
$cacheparams->class        = '\PhocacartCategory';
$cacheparams->method       = 'getCategoryTreeFormat';
$cacheparams->methodparams = [
	$p['category_ordering'],
	$display_categories,
	$hide_categories,
	array(0 ,1),
	$language,
	$format
];
$cacheparams->modeparams   = $cacheid;

$tree     = ModuleHelper::moduleCache($module, $params, $cacheparams);
//$tree 		= PhocacartCategory::getCategoryTreeFormat($p['category_ordering'], $display_categories, $hide_categories, array(0 ,1), $language, $format);


//$tree2 		= PhocacartCategory::getCategoryTreeArray($p['category_ordering'], $display_categories, $hide_categories, array(0 ,1), $language);




$js	  = array();
$js[] = ' ';
$js[] = 'jQuery(function () {';
$js[] = '   jQuery("#'.$treeId.'").jstree({';
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
$js[] = '   jQuery("#'.$treeId.'").on("changed.jstree", function (e, data) {';
//$js[] = '      con sole.log(data.selected);';
$js[] = '   });';
$js[] = '   ';
//$js[] = '   jQuery("button").on("click", function () {';
$js[] = '   jQuery("#'.$treeId.' button").on("click", function () {';
$js[] = '      jQuery("#'.$treeId.'").jstree(true).select_node("child_node_1");';
$js[] = '      jQuery("#'.$treeId.'").jstree("select_node", "child_node_1");';
$js[] = '      jQuery.jstree.reference("#'.$treeId.'").select_node("child_node_1");';
$js[] = '   });';
$js[] = '});';
$js[] = ' ';

if ($p['simple_layout']	== 0) {

	$wa->addInlineScript(implode("\n", $js));
}
//$document->addScriptDeclaration(implode("\n", $js));

require(ModuleHelper::getLayoutPath('mod_phocacart_category', $params->get('layout', 'default')));
?>
