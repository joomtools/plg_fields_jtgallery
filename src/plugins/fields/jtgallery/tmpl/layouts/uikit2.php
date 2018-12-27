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
use Joomla\Filesystem\File;

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

$sublayout = 'default';
$imgWidth  = array();
$imgData   = array();
$attribs   = array();

$linkAttr['data-uk-lightbox'] = '{group:\'' . md5(json_encode($images)) . '\'}';
//$linkAttr['class'] = 'uk-thumbnail';

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

			if ($imagesPath === false)
			{
				$fileName             = explode('/', str_replace(array('\\\\', '\\'), '/', $image->picture));
				$fileName             = array_pop($fileName);
				$imgAbsPath           = JPATH_SITE . '/' . $image->picture;
				$imgAbsCachePath      = $thumbCachePath . '/' . $fileName;
				$imgPath              = Uri::base(true) . '/' . $image->picture;
				$imgData['thumb']     = Uri::base(true) . str_replace(JPATH_SITE, '', $thumbCachePath);
				$image->picture_alt   = trim(strip_tags($image->picture_alt));
				$image->picture_title = trim(strip_tags($image->picture_title));
				$imgData['title']     = '';

				if (!empty($image->picture_alt))
				{
					$imgData['alt']   = $image->picture_alt;
				}
				else
				{
					$imgData['alt'] = str_replace(array('-', '_'), " ", File::stripExt($fileName));
				}

				if (!empty($image->picture_title))
				{
					$imgData['title']          = $image->picture_title;
					$linkAttr['data-title']    = $imgData['title'];
					$imgData['titleContainer'] = $image->title_container;

					if ($imageLayout != '0')
					{
						$sublayout = $imageLayout;
					}
				}
				else
				{
					$linkAttr['data-title'] = $imgData['alt'];
				}
			}
			else
			{
				$imgPath                = Uri::base(true) . '/' . $imagesPath . '/' . $image;
				$imgAbsPath             = JPATH_SITE . '/' . $imagesPath . '/' . $image;
				$imgAbsCachePath        = $thumbCachePath . '/' . $image;
				$imgData['thumb']       = Uri::base(true) . str_replace(JPATH_SITE, '', $thumbCachePath) . '/' . $image;
				$imgData['alt']         = str_replace(array('-', '_'), " ", strip_tags(File::stripExt($image)));
				$linkAttr['data-title'] = $imgData['alt'];
			}

			if (!file_exists($imgAbsCachePath))
			{
				// Todo: Prüfung auf Thumbnail, ggf. erstellen auf feste Größe von 480px (crop)
				$imgData['thumb'] = $imgPath;
			}

			$imgData['attribs'] = $attribs;

			$img = $this->sublayout($sublayout, $imgData);

			echo HTMLHelper::_('link', $imgPath, $img, $linkAttr); ?>
		</div>
	<?php endforeach; ?>
</div>
