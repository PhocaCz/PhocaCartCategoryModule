<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

echo '<div class="ph-category-module-box'.$moduleclass_sfx .' scroll-box">';

$pathItem = PhocacartPath::getPath('categoryimage');

$idSlider = 'phCategoryScrollBox' . $treeId;

if (!empty($tree)) {
	echo '<div id="'.$treeId.'" class="pcModCategoryScrollBox">';
	echo '<div class="ph-category-scroll-box-wrapper">';

	echo '<button class="ph-category-nav-btn ph-category-prev-btn" onclick="document.getElementById(\''.$idSlider.'\').scrollTo({left: 0, behavior: \'smooth\'})">';
    echo '<svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>';
    echo '</button>';

	echo '<div class="ph-category-scroll-box-container" id="'.$idSlider.'">';
	foreach ($tree as $k => $v) {

		$class = '';
		if (in_array($v['id'], $activeCategories)) {
			$class = " ph-active";
		}
		$link = Route::_(PhocacartRoute::getCategoryRoute($v['id'], $v['alias']));

		$imageUrl = '';
		if (isset($v['special_image']) && $v['special_image'] != '') {
			$imgClean = HTMLHelper::cleanImageURL($v['special_image']);
			if ($imgClean->url != '') {
				$imageUrl = Uri::base(true) . '/'. $imgClean->url;
			}
		}

		if ($imageUrl == '') {
			$image       = PhocacartImage::getThumbnailName($pathItem, $v['image'], 'medium');
        	$imageUrl = Uri::base(true) . '/' . $image->rel;
		}



		$backgroundImageStyle = '';
		if ($imageUrl != '') {
			//$imageBox = '<div class="ph-category-box-image"><img src="'.$imageUrl.'" /></div>';
			$backgroundImageStyle = ' style="background-image: url('.$imageUrl.')"';
		}
		//echo '<li class="'.$class.'"><a class="ph-category-box-link" href="'.$link.'">'.$imageBox .'<div class="ph-category-box-title">'.$v['title'].'</div></a></li>';


		echo '<div class="ph-category-scroll-box-box'.$class.'"'.$backgroundImageStyle.'>';
        echo '<a href="'.$link.'" class="ph-category-scroll-box-label ph-btn">'.$v['title'].'</a>';
        echo '</div>';

	}
	echo '</div>';

	echo '<button class="ph-category-nav-btn ph-category-next-btn" onclick="document.getElementById(\''.$idSlider.'\').scrollTo({left: 10000, behavior: \'smooth\'})">';
    echo '<svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>';
    echo '</button>';


	echo '</div>';
	echo '</div>';
}
echo '</div>';
?>
