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

use Joomla\CMS\Uri\Uri;
use Joomla\Filesystem\File;

/**
 * Helper for plg_fields_jtgallery
 *
 * @since   1.0.0
 */
class PlgFieldsJtgalleryHelper
{
	/**
	 * @var   bool
	 *
	 * @since   1.0.0
	 */
	public static $runJs = false;

	/**
	 * @param   string         $thmpPath
	 * @param   string|object  $image
	 * @param   string         $imagesPath
	 *
	 * @return   object
	 *
	 * @since    1.0.0
	 */
	public static function createThumbnail($thumbPath, $image, $imagesPath)
	{
		return false;
	}
	/**
	 * @param   string         $imagesPath
	 * @param   string|object  $image
	 *
	 * @return   object
	 *
	 * @since    1.0.0
	 */
	public static function getImgObject($imagesPath, $image)
	{
		$imgObject        = new stdClass;
		$imgObject->caption_overlay = '';

		if ($imagesPath === false)
		{
			$fileName = explode('/', str_replace(array('\\\\', '\\'), '/', $image->picture));

			$image->picture_alt = trim(strip_tags($image->picture_alt));

			$imgObject->fileName   = array_pop($fileName);
			$imgObject->url        = Uri::base(true) . '/' . $image->picture;
			$imgObject->imgAbsPath = JPATH_SITE . '/' . $image->picture;

			if (!empty($image->picture_alt))
			{
				$imgObject->alt = $image->picture_alt;
			}
			else
			{
				$imgObject->alt = str_replace(array('-', '_'), " ", File::stripExt($imgObject->fileName));
			}

			if (!empty($image->picture_caption_overlay))
			{
				$imgObject->caption_overlay = $image->picture_caption_overlay;
			}
		}
		else
		{
			$imgObject->fileName   = $image;
			$imgObject->url        = Uri::base(true) . '/' . $imagesPath . '/' . $image;
			$imgObject->imgAbsPath = JPATH_SITE . '/' . $imagesPath . '/' . $image;
			$imgObject->alt        = str_replace(array('-', '_'), " ", strip_tags(File::stripExt($image)));
		}

		return $imgObject;
	}

	public static function initJs()
	{
		if (self::$runJs === false)
		{
			$js ="\nwindow.onload = function() {\n";
			$js .="\tbaguetteBox.run('.jtgallery_container', {\n";
			$js .="\t\tloop: true,\n";
			$js .="\t\tanimation: 'fadeIn',\n";
			$js .="\t\tnoScrollbars: true\n";
			$js .="\t});\n";
			$js .="};\n";

			JFactory::getDocument()->addScriptDeclaration($js);

			JHtml::_('stylesheet', 'plg_fields_jtgallery/baguetteBox.min.css', array('version' => 'auto', 'relative' => true));
			JHtml::_('script', 'plg_fields_jtgallery/baguetteBox.min.js', array('version' => 'auto', 'relative' => true));

			self::$runJs = true;
		}
	}
}
