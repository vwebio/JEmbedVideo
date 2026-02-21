<?php
namespace Joomla\Module\JEmbedVideo\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

class JEmbedVideoHelper
{
	/**
	 * Получает embed-ссылку из публичной ссылки на видео.
	 *
	 * @param   string  $url  Ссылка на видео, предоставленная пользователем.
	 *
	 * @return  string|null   Embed-ссылка или null, если не распознана.
	 */
	public static function getEmbedUrl(string $url): ?string
	{
		$url = trim($url);

		if (empty($url))
		{
			return null;
		}

		// YouTube
		if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false)
		{
			return self::getYouTubeEmbed($url);
		}

		// Rutube
		if (strpos($url, 'rutube.ru') !== false)
		{
			return self::getRutubeEmbed($url);
		}

		// VK Video
		if (strpos($url, 'vk.com') !== false || strpos($url, 'vk.ru') !== false)
		{
			return self::getVkEmbed($url);
		}

		return null;
	}

	/**
	 * Parse YouTube URL.
	 *
	 * @param   string  $url
	 *
	 * @return  string|null
	 */
	private static function getYouTubeEmbed(string $url): ?string
	{
		$pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
		
		if (preg_match($pattern, $url, $matches))
		{
			return 'https://www.youtube.com/embed/' . $matches[1];
		}

		return null;
	}

	/**
	 * Парсинг Rutube URL.
	 *
	 * @param   string  $url
	 *
	 * @return  string|null
	 */
	private static function getRutubeEmbed(string $url): ?string
	{
		// Соответствует стандартному ID видео (обычно 32 символа) или числовому ID
		// Пример: https://rutube.ru/video/12345.../
		// Пример: https://rutube.ru/play/embed/12345...
		
		$pattern = '/rutube\.ru\/(?:video|play\/embed)\/([a-zA-Z0-9]+)/i';
		
		if (preg_match($pattern, $url, $matches))
		{
			return 'https://rutube.ru/play/embed/' . $matches[1];
		}

		return null;
	}

	/**
	 * Парсинг VK Video URL.
	 *
	 * @param   string  $url
	 *
	 * @return  string|null
	 */
	private static function getVkEmbed(string $url): ?string
	{
		// Если это уже embed ссылка
		if (strpos($url, 'video_ext.php') !== false)
		{
			return $url;
		}

		// Публичная ссылка на видео: https://vk.com/video-123456_789012
		// Или: https://vk.com/video123456_789012
		// Regex для захвата oid (опционально -) и id
		
		$pattern = '/vk\.(?:com|ru)\/video(-?\d+)_(\d+)/i';
		
		if (preg_match($pattern, $url, $matches))
		{
			$oid = $matches[1];
			$id  = $matches[2];
			
			// Примечание: Для некоторых приватных видео требуется хеш, который сложно получить из публичной ссылки.
			// Однако, для публичных видео достаточно oid и id.
			return "https://vk.com/video_ext.php?oid={$oid}&id={$id}&hd=2";
		}

		return null;
	}
}
