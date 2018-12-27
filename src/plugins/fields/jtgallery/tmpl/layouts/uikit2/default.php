<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Gallery
 *
 * @copyright   Copyright (C) Guido De Gobbis (JoomTools), Barbara Assmann.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

extract($displayData);

/**
* Layout variables
* ---------------------
* @var   string  $thumb    Url to the thumbnail of the image.
* @var   string  $alt      Alternate text of image.
* @var   array   $attribs  Attributes of image or empty.
*/
?>
<figure class="uk-thumbnail">
	<?php echo HTMLHelper::_('image', $thumb, $alt, $attribs, false, -1); ?>
</figure>
