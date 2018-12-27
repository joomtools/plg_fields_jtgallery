<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Uikitgallery
 *
 * @copyright   Copyright (C) 2017 JUGN.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

extract($displayData);

/**
 * Layout variables
 * ---------------------
 * @var   array   $images          All selected images or all images inside of selected folder.
 * @var   string  $imagesPath      Absolute path of images if folder is selected.
 * @var   string  $imageLayout     Layout for image output.
 * @var   string  $thumbCachePath  Absolute path for thumbnails or responsive images.
 * @var   array   $itemsXline      Items x line selected for responive views.
 */

$linkAttr = array();
//$linkAttr['data-uk-lightbox'] = '{group:\'' . md5(json_encode($images)) . '\'}';

$sublayout       = 'default';
$imgWidth        = array();
$attribs         = array();

$imgData = array();
$imgData['attribs'] = $attribs;

$responsiveGrids = array(
	'xl' => '-xlarge',
	'l'  => '-large',
	'm'  => '-medium',
	's'  => '-small',
);

foreach ($responsiveGrids as $key => $grid)
{
	if ($itemsXline->$key != '0')
	{
		$imgWidth[] = 'uk-width' . $grid . '-1-' . $itemsXline->$key;
	}
}

$imgWidth = implode(' ', $imgWidth); ?>

<div class="uk-grid uk-grid-medium gallery" data-uk-grid-margin>
	<?php foreach ($images as $image) : ?>
		<div class="<?php echo $imgWidth; ?>">
			<?php
			$imgObject        = PlgFieldsJtgalleryHelper::getImgObject($imagesPath, $image);
			$imgAbsCachePath  = $thumbCachePath . '/' . $imgObject->fileName;
			$imgData['thumb'] = Uri::base(true) . str_replace(JPATH_SITE, '', $imgAbsCachePath);
			$imgData['alt']   = $imgObject->alt;

			if (!file_exists($imgAbsCachePath))
			{
				// Todo: Prüfung auf Thumbnail, ggf. erstellen auf feste Größe von 480px (crop)
				$imgData['thumb'] = $imgObject->url;
			}

			if (!empty($imgObject->title))
			{
				$linkAttr['data-caption']    = $imgObject->title;
				$imgData['title']          = $imgObject->title;
				$imgData['titleContainer'] = $image->title_container;

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
		</div>
	<?php endforeach; ?>
</div>
