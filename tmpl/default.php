<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die;

echo '<div class="ph-category-module-box'.$moduleclass_sfx .'">';
if (!empty($tree)) {
	echo '<div id="phjstree">';
	echo $tree;
	echo '</div>';
}
echo '</div>';
?>


