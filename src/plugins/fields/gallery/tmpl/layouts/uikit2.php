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
use Joomla\Filesystem\File;

extract($displayData);

$sublayout = 'default';
$imgWidth  = array();
$imgData   = array();

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
				$imgPath          = $image->picture;
				$fileName         = explode('/', str_replace(array('\\\\', '\\'), '/', $imgPath));
				$imgData['thumb'] = $thumbCachePath . '/' . array_pop($fileName);
				$imgData['alt']   = trim(strip_tags($image->picture_alt));
				$imgData['title'] = trim(strip_tags($image->picture_title));

				$linkAttr['data-title'] = $imgData['alt'];

				if (!empty($imgData['title']))
				{
					$linkAttr['data-title']    = $imgData['title'];
					$imgData['titleContainer'] = $image->title_container;

					if ($imageLayout != '0')
					{
						$sublayout = $imageLayout;
					}
				}
			}
			else
			{
				$imgPath                = $imagesPath . '/' . $image;
				$imgData['thumb']       = $thumbCachePath . '/' . $image;
				$imgData['alt']         = str_replace(array('-', '_'), " ", strip_tags(File::stripExt($image)));
				$linkAttr['data-title'] = $imgData['alt'];
			}

			if (!file_exists($imgData['thumb']))
			{
				// Todo: Prüfung auf Thumbnail, ggf. erstellen auf feste Größe von 480px (crop)
				$imgData['thumb'] = $imgPath;
			}

			$img = $this->sublayout($sublayout, $imgData);

			echo HTMLHelper::_('link', $imgPath, $img, $linkAttr); ?>
		</div>
	<?php endforeach; ?>
</div>
