<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

echo '<div class="ph-category-module-box'.$moduleclass_sfx .'">';

$pathItem = PhocacartPath::getPath('categoryimage');

if (!empty($tree)) {
	echo '<div id="'.$treeId.'" class="pcModCategoryBox">';
	echo '<ul>';
	foreach ($tree as $k => $v) {

		$class = '';
		if (in_array($v['id'], $activeCategories)) {
			$class = "ph-active";
		}
		$link = Route::_(PhocacartRoute::getCategoryRoute($v['id'], $v['alias']));
		$image       = PhocacartImage::getThumbnailName($pathItem, $v['image'], 'small');
        $imageUrl = Uri::base(true) . '/' . $image->rel;
		$imageBox = '';
		if ($imageUrl != '') {
			$imageBox = '<div class="ph-category-box-image"><img src="'.$imageUrl.'" /></div>';
		}
		echo '<li class="'.$class.'"><a class="ph-category-box-link" href="'.$link.'">'.$imageBox .'<div class="ph-category-box-title">'.$v['title'].'</div></a></li>';
	}
	echo '</ul>';
	echo '</div>';
}
echo '</div>';
?>


