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

extract($displayData);

/**
 * Layout variables
 * ---------------------
 * @var   string  $frwk            Selected framework.
 * @var   array   $images          All selected images or all images inside of selected folder.
 * @var   string  $imagesPath      Absolute path of images if folder is selected.
 * @var   string  $imageLayout     Layout for image output.
 * @var   string  $thumbCachePath  Absolute path for thumbnails or responsive images.
 * @var   object  $itemsXline      Items x line selected for responive views.
 */

$linkAttr = array();

$sublayout       = 'default';
$imgWidth        = array();

$imgData = array();
$imgData['attribs'] = array();

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

$imgContainer = 'div';
$imgWidth = implode(' ', $imgWidth);

PlgFieldsJtgalleryHelper::initJs(); ?>

<div class="uk-grid uk-grid-medium jtgallery" data-uk-grid-margin>
	<?php include __DIR__ . '/_tmpl_base.php'; ?>
</div>
