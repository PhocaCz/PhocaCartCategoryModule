<?php // no direct access
defined('_JEXEC') or die('Restricted access');

echo '<div class="ph-category-module-box">';
if (!empty($tree)) {
	echo '<div id="phjstree">';
	echo $tree;
	echo '</div>';
}
echo '</div>';
?>


