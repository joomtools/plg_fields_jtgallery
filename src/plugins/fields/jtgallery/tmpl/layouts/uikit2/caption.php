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

?>
<figure class="uk-thumbnail">
	<?php echo HTMLHelper::_('image', $thumb, $alt, false); ?>
	<figcaption class="uk-thumbnail-caption">
		<<?php echo $titleContainer; ?>><?php echo $title; ?></<?php $titleContainer; ?>>
	</figcaption>
</figure>
