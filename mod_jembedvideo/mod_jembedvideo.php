<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_jembedvideo
 *
 * @copyright   (C) 2026 Brintek.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use JoomPro\Module\JEmbedVideo\Helper\JEmbedVideoHelper;
use Joomla\CMS\Factory;

// Get the WebAssetManager
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();

// Get parameters
$videoUrl = $params->get('video_url', '');
$description = $params->get('video_description', '');
$styleMode = $params->get('style_mode', 'basic');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_COMPAT, 'UTF-8');

// Process video URL
$embedUrl = JEmbedVideoHelper::getEmbedUrl($videoUrl);

// Load CSS if basic style is selected
if ($styleMode === 'basic')
{
	// Check if the media file exists in the standard media folder (installed mode)
	// or fallback to the module folder (dev mode)
	if (file_exists(JPATH_ROOT . '/media/mod_jembedvideo/css/style.css'))
	{
		$wa->registerAndUseStyle('mod_jembedvideo.style', 'media/mod_jembedvideo/css/style.css');
	}
	elseif (file_exists(__DIR__ . '/media/css/style.css'))
	{
		// Fallback for direct folder copy without installation
		$wa->registerAndUseStyle('mod_jembedvideo.style', 'modules/mod_jembedvideo/media/css/style.css');
	}
}

require ModuleHelper::getLayoutPath('mod_jembedvideo', $params->get('layout', 'default'));
