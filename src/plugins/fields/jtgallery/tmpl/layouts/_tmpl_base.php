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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

/**
 * To be included from framework layout
 */

/**
 * Layout variables
 * ---------------------
 * @var   string  $frwk         Selected framework.
 * @var   array   $images       All selected images or all images inside of selected folder.
 * @var   string  $imagesPath   Absolute path of images if folder is selected.
 * @var   string  $imageLayout  Layout for image output.
 * @var   array   $thumbnails   Array with cache path, thumbwidth, thumbheight and if activate genereting
 *                              array_keys = active, cachePath, width and height
 * @var   int     $itemsXline   Items x line selected for responive views.
 */

$imgCounter = 1;
?>
<?php foreach ($images as $image) : ?>
	<?php if ($frwk == 'bs2' && ($imgCounter % $itemsXline == 0)) : ?>
		</ul><ul class="thumbnails">
	<?php $imgCounter = 1; ?>
	<?php endif; ?>
	<<?php echo $imgContainer; ?> class="<?php echo $imgWidth; ?>">
		<?php
		$imgObject             = PlgFieldsJtgalleryHelper::getImgObject($imagesPath, $image);
		$imgObject->thumbnails = $thumbnails;

		$imgData['alt']   = $imgObject->alt;
		$imgData['thumb'] = Uri::base(true) . str_replace(JPATH_SITE, '', $imgObject->imgAbsPath);

		if ($thumbnails['active'])
		{
			PlgFieldsJtgalleryHelper::createThumbnail($imgObject);
			$imgData['thumb'] = Uri::base(true) . str_replace(JPATH_SITE, '', $imgObject->thumbnails['thumbAbsPath']);
		}

		if (!empty($imgObject->caption_overlay))
		{
			$linkAttr['data-caption']   = htmlentities($imgObject->caption_overlay);
			$imgData['caption_overlay'] = $imgObject->caption_overlay;

			if ($imageLayout != '0')
			{
				$sublayout = $imageLayout;
			}
		}
		else
		{
			$linkAttr['data-caption'] = $imgData['alt'];
		}

		$img = $this->sublayout($sublayout, $imgData);

		echo HTMLHelper::_('link', $imgObject->url, $img, $linkAttr); ?>
	</<?php echo $imgContainer; ?>>
	<?php $imgCounter++ ?>
<?php endforeach; ?>
