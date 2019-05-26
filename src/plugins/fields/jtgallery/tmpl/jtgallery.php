<?php
/**
 * @package      Joomla.Plugin
 * @subpackage   Fields.Jtgallery
 *
 * @author       Barbara Assmann, Guido De Gobbis
 * @copyright    (c) JoomTools.de - All rights reserved.
 * @license      GNU General Public License version 3 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Layout\FileLayout;
use Joomla\Registry\Registry;

if (!$field->value
	|| $field->value == '-1'
	|| !in_array($context, array('com_content.article', 'com_content.category')))
{
	return;
}

// Get the params set in article/category for gallery
$params = new Registry(json_decode($field->value));
$class  = (string) $params->get('container_class', '');
$frwk   = (string) $params->get('layout', 'bs2');

if (!$params->get('activate', false))
{
	return;
}

$theme             = Factory::getApplication()->getTemplate();
$themeOverridePath = JPATH_THEMES . '/' . $theme . '/html/plg_' . $this->_type . '_' . $this->_name;
$layoutBasePath    = JPATH_PLUGINS . '/' . $this->_type . '/' . $this->_name . '/tmpl/layouts';
$thumbCachePath    = JPATH_SITE . '/cache/plg_' . $this->_type . '_' . $this->_name;
$imagesPath        = false;

$renderer = new FileLayout($frwk, $layoutBasePath, array('component' => 'none'));
$renderer->addIncludePath($themeOverridePath);

$debug = $this->params->get('debug') !== '0';
$renderer->setOptions(array('debug' => $debug));

if ($params->get('single_folder', 'folder') == 'folder')
{
	$imagesPath = $params->get('directory' ,'/') === '/'
		? 'images'
		: 'images/' . $params->get('directory');

	// read the .jpg from the selected directory
	$filter = '(\.gif|\.png|\.jpg|\.jpeg|\.GIF|\.PNG|\.JPG|\.JPEG)';
	$images = Folder::files(JPATH_SITE . '/' . $imagesPath, $filter);
}
else
{
	$images = (array) $params->get('single_pictures');
}

$itemsXline    = (object) $params->get('items_x_line');
$itemsXlineBs2 = (int) $params->get('items_x_line_m', 3);

if ($frwk == 'bs2')
{
	$itemsXline = (int) round(12 / $itemsXlineBs2);
}

$gutter = $params->get('gutter', 'medium');

if (in_array($frwk , array('bs2', 'bs3'), true))
{
	$gutter = $params->get('gutter_bs', 'medium');
}

if ($frwk == 'uikit3')
{
	$itemsXline = (object) $params->get('items_x_line_uikit3');
}

$captionOverlay = $params->get('caption_overlay', 'none');
$imageLayout    = $params->get('image_layout', 'none');

if ($frwk == 'uikit3')
{
	$imageLayout    = $params->get('image_layout_uikit3', 'none');
}

$thumbWidth     = $params->get('thumb_width', '320px');
$thumbHeight    = $params->get('thumb_height', '240px');

$displayData = array(
	'frwk'           => $frwk,
	'images'         => $images,
	'imagesPath'     => $imagesPath,
	'captionOverlay' => $captionOverlay == 'none' ? false : $captionOverlay,
	'imageLayout'    => $imageLayout == 'none' ? false : $imageLayout,
	'thumbnails'     => array(
		'active'    => $params->get('thumbnails', 0),
		'cachePath' => $thumbCachePath,
		'width'     => $thumbWidth,
		'height'    => $imageLayout == 'circle' ? $thumbWidth : $thumbHeight,
	),
	'itemsXline'     => $itemsXline,
	'itemsXlineBs2'  => $itemsXlineBs2,
	'gutter'         => $gutter,
); ?>

<div class="jtgallery_container<?php echo $class; ?>">
	<?php echo $renderer->render($displayData); ?>
</div>
