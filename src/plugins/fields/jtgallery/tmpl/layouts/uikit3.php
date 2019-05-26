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
 * @var   string  $captionOverlay  Output of Caption/Overlay if Framework support it.
 * @var   string  $imageLayout     Layout for image output.
 * @var   string  $thumbCachePath  Absolute path for thumbnails or responsive images.
 * @var   object  $itemsXline      Items x line selected for responive views.
 * @var   string  $gutter          Grid gutter between images.
 */

$sublayout = 'default';
$imgData   = array();
$imgWidth  = '';
$imgGrid  = array();
$linkAttr  = array();

$imgData['attribs'] = array();

$imgData['containerClass'] = '';

if ($imageLayout == 'card')
{
	// $linkAttr['class'] = 'uk-card uk-card-default uk-card-body uk-border-rounded';
	$imgData['containerClass'] .= 'uk-padding-small uk-card uk-card-default uk-card-body uk-border-rounded';
	$imgData['overlay'] = 'uk-border-rounded';
	$imgData['attribs']['class'] = 'uk-border-rounded';
}

if ($imageLayout == 'rounded')
{
	$imgData['overlay'] = 'uk-border-rounded';
	$imgData['attribs']['class'] = 'uk-border-rounded';
}

if ($imageLayout == 'circle')
{
	$imgData['overlay'] = 'uk-border-circle';
	$imgData['attribs']['class'] = 'uk-border-circle';
}

$responsiveGrids = array(
	'xl' => '@xl',
	'l'  => '@l',
	'm'  => '@m',
	's'  => '@s',
);

foreach ($responsiveGrids as $key => $grid)
{
	if ($itemsXline->$key != '0')
	{
		$imgGrid[] = 'uk-child-width-1-' . (int) $itemsXline->$key . $grid;
	}
}

$imgContainer = 'div';
$imgGrid = implode(' ', $imgGrid);
$gridMatch = $captionOverlay == 'caption' ? ' uk-height-match="target: figure"' : '';

// PlgFieldsJtgalleryHelper::initJs();
?>

<div class="<?php echo $imgGrid; ?> uk-text-center uk-grid-<?php echo $gutter; ?>" uk-lightbox uk-grid<?php echo $gridMatch; ?>>
	<?php include __DIR__ . '/_tmpl_base.php'; ?>
</div>
