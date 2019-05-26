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
 * @var   string  $thumb            Url to the thumbnail of the image.
 * @var   string  $alt              Alternate text of image.
 * @var   array   $attribs          Attributes of image or empty.
 * @var   string  $caption_overlay  Tag for title container.
 * @var   string  $containerClass   Classes for container.
 */

$attribs['uk-img'] = 'data-src:' . $thumb;
$containerClass    = !empty($containerClass) ? ' class="' . trim($containerClass) . '"' : '';
?>
<figure<?php echo $containerClass; ?>>
	<div class="uk-inline uk-transition-toggle <?php echo $overlay; ?>" tabindex="0">
		<?php echo HTMLHelper::_('image', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+P+/HgAFhAJ/wlseKgAAAABJRU5ErkJggg==', $alt, $attribs, false, -1); ?>
		<figcaption class="uk-transition-fade uk-position-cover uk-overlay uk-overlay-primary uk-flex uk-flex-center uk-flex-middle <?php echo $overlay; ?>">
			<div class="uk-position-center uk-text-center"><?php echo $caption_overlay; ?></div>
		</figcaption>
	</div>
</figure>
