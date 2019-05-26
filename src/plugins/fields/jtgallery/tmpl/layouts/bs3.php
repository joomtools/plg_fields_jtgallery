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
$imgWidth  = array();
$linkAttr  = array();

$imgData['attribs']        = array('class' => 'img-responsive');
$imgData['containerClass'] = '';

if ($captionOverlay == 'overlay')
{
	$captionOverlay = 'caption';
}

if ($imageLayout == 'thumbnail' && $captionOverlay)
{
	$imgData['containerClass'] .= 'thumbnail';
}

if ($imageLayout && in_array($imageLayout,array('rounded', 'thumbnail'), true) && !$captionOverlay)
{
	$imgData['attribs']['class'] .= ' thumbnail';
}

if ($imageLayout == 'rounded' && $captionOverlay)
{
	$imgData['attribs']['class'] .= ' img-thumbnail';
}

if ($imageLayout == 'circle' && !$captionOverlay)
{
	$imgData['attribs']['class'] .= ' img-thumbnail img-circle';
}

if ($imageLayout == 'circle' && $captionOverlay)
{
	$imgData['attribs']['class'] .= ' img-thumbnail img-circle';
}

$responsiveGrids = array(
	'xl' => '-lg',
	'l'  => '-md',
	'm'  => '-sm',
	's'  => '-xs',
);

foreach ($responsiveGrids as $key => $grid)
{
	if ($itemsXline->$key != '0')
	{
		$imgWidth[] = 'col' . $grid . '-' . (int) round(12 / $itemsXline->$key);
	}
}

$imgContainer = 'div';
$imgWidth     = implode(' ', $imgWidth);
$gutter = $gutter == 'collapse' ? ' no-gutters': ' show-grid';

HTMLHelper::_('stylesheet', 'plg_fields_jtgallery/bs.min.css', array('version' => 'auto', 'relative' => true));
PlgFieldsJtgalleryHelper::initJs(); ?>

<div class="jtgallery">
	<div class="row<?php echo $gutter; ?>">
		<?php include __DIR__ . '/_tmpl_base.php'; ?>
	</div>
</div>
