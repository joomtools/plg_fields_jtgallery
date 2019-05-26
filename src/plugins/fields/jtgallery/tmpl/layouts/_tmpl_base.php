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
 * @var   string  $frwk            Selected framework.
 * @var   array   $images          All selected images or all images inside of selected folder.
 * @var   string  $imagesPath      Absolute path of images if folder is selected.
 * @var   string  $captionOverlay  Output of Caption/Overlay if Framework support it.
 * @var   string  $imageLayout     Layout for image output.
 * @var   array   $thumbnails      Array with cache path, thumbwidth, thumbheight and if activate genereting
 *                                 array_keys = active, cachePath, width and height
 * @var   int     $itemsXline      Items x line selected for responive views.
 * @var   int     $itemsXlineBs2   Items x line selected for view.
 */

$imgCounter = 1;
?>
<?php foreach ($images as $image) : ?>
	<?php if ($frwk == 'bs2' && ($imgCounter > $itemsXlineBs2)) : ?>
		</div><div class="row show-grid thumbnails<?php echo $gutter; ?>">
		<?php $imgCounter = 1;
	endif; ?>

	<<?php echo $imgContainer; ?> class="<?php echo $imgWidth; ?>">
	<?php
	$imgObject                = PlgFieldsJtgalleryHelper::getImgObject($imagesPath, $image);
	$imgObject->thumbnails    = $thumbnails;
	$linkAttr['data-caption'] = htmlentities($imgObject->caption_overlay);

	$imgData['alt']   = $imgObject->alt;
	$imgData['thumb'] = Uri::base(true) . str_replace(JPATH_SITE, '', $imgObject->imgAbsPath);

	if ($thumbnails['active'])
	{
		PlgFieldsJtgalleryHelper::createThumbnail($imgObject);
		$imgData['thumb'] = Uri::base(true) . str_replace(JPATH_SITE, '', $imgObject->thumbnails['thumbAbsPath']);

		$imgData['attribs']['width'] = (int) $thumbnails['width'];
		$imgData['attribs']['height'] = (int) $thumbnails['height'];
	}

	if (!empty($captionOverlay))
	{
		$imgData['caption_overlay'] = $imgObject->caption_overlay;

		if (!in_array($frwk , array('bs2', 'bs3'), true))
		{
			$sublayout = $captionOverlay;
		}
	}

	$img = $this->sublayout($sublayout, $imgData);

	echo HTMLHelper::_('link', $imgObject->url, $img, $linkAttr); ?>
	</<?php echo $imgContainer; ?>>
	<?php $imgCounter++;
endforeach;
