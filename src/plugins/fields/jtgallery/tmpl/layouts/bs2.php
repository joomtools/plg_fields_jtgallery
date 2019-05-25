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

extract($displayData);

/**
 * Layout variables
 * ---------------------
 * @var   string  $frwk            Selected framework.
 * @var   array   $images          All selected images or all images inside of selected folder.
 * @var   string  $imagesPath      Absolute path of images if folder is selected.
 * @var   string  $imageLayout     Layout for image output.
 * @var   string  $thumbCachePath  Absolute path for thumbnails or responsive images.
 * @var   int     $itemsXline      Items x line selected for responive views.
 * @var   int     $itemsXlineBs2   Items x line selected for view.
 */

$linkAttr = array();
$linkAttr['class'] = 'thumbnail';

$sublayout       = 'default';
$imgWidth        = array();

$imgData = array();
$imgData['attribs'] = array();

$imgWidth = 'span' . $itemsXline;

$imgContainer = 'li';

PlgFieldsJtgalleryHelper::initJs(); ?>

<div class="jtgallery">
	<ul class="thumbnails">
		<?php include __DIR__ . '/_tmpl_base.php'; ?>
	</ul>
</div>
