<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
 
defined('_JEXEC') or die('Restricted access');// no direct access

if (!JComponentHelper::isEnabled('com_phocacart', true)) {
	return JError::raiseError(JText::_('Phoca Cart Error'), JText::_('Phoca Cart is not installed on your system'));
}
if (! class_exists('PhocaCartLoader')) {
    require_once( JPATH_ADMINISTRATOR.'/components/com_phocacart/libraries/loader.php');
}

phocacartimport('phocacart.utils.settings');
phocacartimport('phocacart.category.category');
phocacartimport('phocacart.path.route');

$p['category_ordering']	= $params->get( 'category_ordering', 1 );

$tree 		= PhocaCartCategory::getCategoryTreeFormat($p['category_ordering']);
$document	= JFactory::getDocument();
JHTML::stylesheet('media/com_phocacart/js/jstree/themes/proton/style.min.css' );
$document->addScript(JURI::root(true).'/media/com_phocacart/js/jstree/jstree.min.js');


$js	  = array();	
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
//$js[] = '      console.log(data.selected);';
$js[] = '   });';
$js[] = '   ';
$js[] = '   jQuery("button").on("click", function () {';
$js[] = '      jQuery("#phjstree").jstree(true).select_node("child_node_1");';
$js[] = '      jQuery("#phjstree").jstree("select_node", "child_node_1");';
$js[] = '      jQuery.jstree.reference("#phjstree").select_node("child_node_1");';
$js[] = '   });';
$js[] = '});';

$document->addScriptDeclaration(implode("\n", $js));

require(JModuleHelper::getLayoutPath('mod_phocacart_category'));
?>