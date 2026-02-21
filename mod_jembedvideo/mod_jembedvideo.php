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

// Получаем WebAssetManager
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();

// Получаем параметры
$videoUrl = $params->get('video_url', '');
$description = $params->get('video_description', '');
$styleMode = $params->get('style_mode', 'basic');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_COMPAT, 'UTF-8');

// Обрабатываем URL видео
$embedUrl = JEmbedVideoHelper::getEmbedUrl($videoUrl);

// Загружаем CSS, если выбран базовый стиль
if ($styleMode === 'basic')
{
	// Проверяем наличие файла стилей в стандартной папке media (установленный режим)
	// или используем fallback в папку модуля (режим разработки)
	if (file_exists(JPATH_ROOT . '/media/mod_jembedvideo/css/style.css'))
	{
		$wa->registerAndUseStyle('mod_jembedvideo.style', 'media/mod_jembedvideo/css/style.css');
	}
	elseif (file_exists(__DIR__ . '/media/css/style.css'))
	{
		// Fallback для прямого копирования папки без установки
		$wa->registerAndUseStyle('mod_jembedvideo.style', 'modules/mod_jembedvideo/media/css/style.css');
	}
}

require ModuleHelper::getLayoutPath('mod_jembedvideo', $params->get('layout', 'default'));
