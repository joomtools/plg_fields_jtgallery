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
use Joomla\Image\Image;

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
	 * @param   object  $imgObject
	 *
	 * @return   void
	 *
	 * @since    1.0.0
	 */
	public static function createThumbnail(& $imgObject)
	{
		$image        = new Image($imgObject->imgAbsPath);
		$newImage     = $image->resize($imgObject->thumbnails['width'], $imgObject->thumbnails['height'], true, Image::SCALE_FIT);
		$thumbWidth   = $newImage->getWidth();
		$thumbHeight  = $newImage->getHeight();

		$newImage->destroy();

		$thumbAbsPath = $imgObject->thumbnails['cachePath']
			. '/' . $imgObject->fileName
			. '_' . $thumbWidth . 'x' . $thumbHeight
			. '.' . $imgObject->fileExt;

		if (!file_exists($thumbAbsPath))
		{
			$thumbAbsPath = $image->createThumbs($thumbWidth . 'x' . $thumbHeight, Image::CROP_RESIZE, $imgObject->thumbnails['cachePath'])[0]
				->getPath();
		}

		$image->destroy();
		$imgObject->thumbnails['thumbAbsPath'] = $thumbAbsPath;
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
		$imgObject = new stdClass;

		if ($imagesPath === false)
		{
			$imgObject->file            = pathinfo($image->picture, PATHINFO_BASENAME);
			$imgObject->fileName        = pathinfo($image->picture, PATHINFO_FILENAME);
			$imgObject->fileExt         = pathinfo($image->picture, PATHINFO_EXTENSION);
			$imgObject->url             = Uri::base(true) . '/' . $image->picture;
			$imgObject->imgAbsPath      = JPATH_SITE . '/' . $image->picture;
			$imgObject->alt             = str_replace(array('-', '_'), " ", $imgObject->fileName);
			$imgObject->caption_overlay = $imgObject->alt;

			if (!empty($image->picture_alt))
			{
				$imgObject->alt = trim(strip_tags($image->picture_alt));
			}

			if (!empty($image->picture_caption_overlay))
			{
				$imgObject->caption_overlay = $image->picture_caption_overlay;
			}

			return $imgObject;
		}

		$imgObject->file            = $image;
		$imgObject->fileName        = pathinfo($image, PATHINFO_FILENAME);
		$imgObject->fileExt         = pathinfo($image, PATHINFO_EXTENSION);
		$imgObject->url             = Uri::base(true) . '/' . $imagesPath . '/' . $image;
		$imgObject->imgAbsPath      = JPATH_SITE . '/' . $imagesPath . '/' . $image;
		$imgObject->alt             = str_replace(array('-', '_'), " ", $imgObject->fileName);
		$imgObject->alt             = str_replace(array('-', '_'), " ", $imgObject->fileName);
		$imgObject->caption_overlay = $imgObject->alt;

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
