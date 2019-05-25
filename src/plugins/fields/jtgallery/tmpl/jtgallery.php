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

if (!$field->value
	|| $field->value == '-1'
	|| !in_array($context, array('com_content.article', 'com_content.category')))
{
	return;
}

// Get the params set in article/category for gallery
$params = json_decode($field->value);
$class  = (string) $params->container_class;
$frwk   = $params->layout;

if (!$params->activate)
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

if ($params->single_folder == 'folder')
{
	$imagesPath = $params->directory === '/'
		? 'images'
		: 'images/' . $params->directory;

	// read the .jpg from the selected directory
	$filter = '(\.gif|\.png|\.jpg|\.jpeg|\.GIF|\.PNG|\.JPG|\.JPEG)';
	$images = Folder::files(JPATH_SITE . '/' . $imagesPath, $filter);
}
else
{
	$images = (array) $params->single_pictures;
}

$itemsXline    = (object) $params->items_x_line;
$itemsXlineBs2 = 3;

if ($frwk == 'bs2')
{
	$itemsXlineBs2 = (int) $params->items_x_line_m;
	$itemsXline = (int) round(12 / (int) $params->items_x_line_m);
}

$displayData = array(
	'frwk'          => $frwk,
	'images'        => $images,
	'imagesPath'    => $imagesPath,
	'imageLayout'   => $params->caption_overlay,
	'thumbnails'    => array(
		'active'    => $params->thumbnails,
		'cachePath' => $thumbCachePath,
		'width'     => $params->thumb_width,
		'height'    => $params->thumb_height,
	),
	'itemsXline'    => $itemsXline,
	'itemsXlineBs2' => $itemsXlineBs2,
); ?>

<div class="jtgallery_container<?php echo $class; ?>">
	<?php echo $renderer->render($displayData); ?>
</div>
