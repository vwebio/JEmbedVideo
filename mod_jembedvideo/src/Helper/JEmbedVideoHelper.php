<?php
namespace JoomPro\Module\JEmbedVideo\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

class JEmbedVideoHelper
{
	/**
	 * Get the embed URL from a public video link.
	 *
	 * @param   string  $url  The video URL provided by the user.
	 *
	 * @return  string|null   The embed URL or null if not recognized.
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
	 * Parse Rutube URL.
	 *
	 * @param   string  $url
	 *
	 * @return  string|null
	 */
	private static function getRutubeEmbed(string $url): ?string
	{
		// Match standard video ID (32 chars usually) or numeric ID
		// Example: https://rutube.ru/video/12345.../
		// Example: https://rutube.ru/play/embed/12345...
		
		$pattern = '/rutube\.ru\/(?:video|play\/embed)\/([a-zA-Z0-9]+)/i';
		
		if (preg_match($pattern, $url, $matches))
		{
			return 'https://rutube.ru/play/embed/' . $matches[1];
		}

		return null;
	}

	/**
	 * Parse VK Video URL.
	 *
	 * @param   string  $url
	 *
	 * @return  string|null
	 */
	private static function getVkEmbed(string $url): ?string
	{
		// If it's already an embed link
		if (strpos($url, 'video_ext.php') !== false)
		{
			return $url;
		}

		// Public video link: https://vk.com/video-123456_789012
		// Or: https://vk.com/video123456_789012
		// Regex to capture oid (optional -) and id
		
		$pattern = '/vk\.(?:com|ru)\/video(-?\d+)_(\d+)/i';
		
		if (preg_match($pattern, $url, $matches))
		{
			$oid = $matches[1];
			$id  = $matches[2];
			
			// Note: For some private videos, a hash is required which cannot be derived from the public URL easily.
			// However, for public videos, oid and id are sufficient.
			return "https://vk.com/video_ext.php?oid={$oid}&id={$id}&hd=2";
		}

		return null;
	}
}
