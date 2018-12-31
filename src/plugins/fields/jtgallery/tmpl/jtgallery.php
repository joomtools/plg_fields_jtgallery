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

use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Layout\FileLayout;

if (!$field->value
	|| $field->value == '-1'
	|| !in_array($context, array('com_content.article', 'com_content.category'))
	|| empty($item->asset_id))
{
	return;
}

// Get the params set in article/category for gallery
$params = json_decode($field->value);
$class  = $params->container_class;
$frwk   = 'default';

if (!empty($params->layout))
{
	$frwk = $params->layout;
}

$theme             = JFactory::getApplication()->getTemplate();
$themeOverridePath = JPATH_THEMES . '/' . $theme . '/html/plg_' . $this->_type . '_' . $this->_name;
$layoutBasePath    = JPATH_PLUGINS . '/' . $this->_type . '/' . $this->_name . '/tmpl/layouts';
$thumbCachePath    = JPATH_SITE . '/cache/plg_' . $this->_type . '_' . $this->_name . '/thumbnails';
$imagesPath    = false;

$renderer = new FileLayout($frwk, $layoutBasePath, array('component' => 'none'));
$renderer->addIncludePath($themeOverridePath);

if ($params->single_folder == 'folder')
{
	$imagesPath = $params->directory === '/'
		? 'images'
		: 'images/' . $params->directory;

	// read the .jpg from the selected directory
	$filter = '(\.png|\.jpg|\.jpeg)';
	$images = Folder::files(JPATH_SITE . '/' . $imagesPath, $filter);
}
else
{
	$images = (array) $params->single_pictures;
}

$displayData = array(
	'images'         => $images,
	'imagesPath'     => $imagesPath,
	'imageLayout'    => $params->caption_overlay,
	'thumbCachePath' => $thumbCachePath,
	'itemsXline'     => $params->items_x_line,
);

JHtml::_('stylesheet', 'plg_fields_jtgallery/baguetteBox.min.css', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'plg_fields_jtgallery/baguetteBox.min.js', array('version' => 'auto', 'relative' => true));

PlgFieldsJtgalleryHelper::initJs();

?>

<div class="jtgallery_container <?php echo $class; ?>">
	<?php echo $renderer->render($displayData); ?>
</div>
