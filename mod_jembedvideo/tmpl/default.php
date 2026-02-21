<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_jembedvideo
 *
 * @copyright   (C) 2026 Brintek.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/** @var string $embedUrl */
/** @var string $description */
/** @var string $styleMode */
/** @var string $moduleclass_sfx */

if (!$embedUrl && !$description)
{
    return;
}
?>
<div class="mod-jembedvideo<?php echo $moduleclass_sfx; ?>">
    <?php if ($embedUrl) : ?>
        <div class="mod-jembedvideo__video-wrapper">
            <iframe 
                src="<?php echo htmlspecialchars($embedUrl, ENT_QUOTES, 'UTF-8'); ?>" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                allowfullscreen>
            </iframe>
        </div>
    <?php endif; ?>

    <?php if ($description) : ?>
        <div class="mod-jembedvideo__description">
            <?php echo $description; ?>
        </div>
    <?php endif; ?>
</div>
