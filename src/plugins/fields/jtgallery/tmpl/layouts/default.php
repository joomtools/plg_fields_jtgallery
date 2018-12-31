<?php
/**
 * @package      Joomla.Plugin
 * @subpackage   Fields.Jtgallery
 *
 * @author       Barbara Assmann, Guido De Gobbis
 * @copyright    (c) JoomTools.de - All rights reserved.
 * @license      GNU General Public License version 3 or later
 */

defined('_JEXEC') or die; ?>

<div class="gallery <?php echo $class; ?>" data-uk-grid-margin>
    <?php foreach ($images as $image) : ?>
        <div>
	        <?php $img = JHtml::_('image', 'images/' . $path . '/' . $image, str_replace("-"," ",substr(strtoupper($image),0,-4)), array('title' => str_replace("-"," ",substr(strtoupper($image),0,-4))), false); ?>

	        <?php echo JHtml::_('link', 'images/' . $path . '/' . $image, $img, array('data-uk-lightbox' => '{group:\'my-group\'}', 'title' => str_replace("-"," ",substr(strtoupper($image),0,-4)))); ?>
        </div>
    <?php endforeach; ?>
</div>
