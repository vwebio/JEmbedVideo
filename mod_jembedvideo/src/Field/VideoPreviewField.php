<?php
namespace Brintek\Module\JEmbedVideo\Site\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;

/**
 * Поле для предпросмотра видео в административной панели.
 *
 * @since  1.0.0
 */
class VideopreviewField extends FormField
{
	/**
	 * Тип поля формы.
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	protected $type = 'Videopreview';

	/**
	 * Метод для получения HTML разметки поля.
	 *
	 * @return  string  HTML разметка поля.
	 *
	 * @since   1.0.0
	 */
	protected function getInput()
	{
		$noUrlText = Text::_('MOD_JEMBEDVIDEO_PREVIEW_NO_URL');
		$invalidUrlText = Text::_('MOD_JEMBEDVIDEO_PREVIEW_INVALID_URL');

		$html = [];
		$html[] = '<div id="video_preview_container" style="max-width: 500px; margin-top: 10px;"></div>';
		
		$html[] = '<script>';
		$html[] = 'document.addEventListener("DOMContentLoaded", function() {';
		$html[] = '    var input = document.getElementById("jform_params_video_url");';
		$html[] = '    var container = document.getElementById("video_preview_container");';
		$html[] = '    if (!input || !container) return;';
		$html[] = '    function updatePreview() {';
		$html[] = '        var url = input.value.trim();';
		$html[] = '        if (!url) { container.innerHTML = "<div class=\"alert alert-info\">' . addslashes($noUrlText) . '</div>"; return; }';
		$html[] = '        var embedUrl = null;';
		$html[] = '        var ytMatch = url.match(/(?:youtube\\.com\\/(?:[^\\/]+\\/.+\\/|(?:v|e(?:mbed)?)\\/|.*[?&]v=)|youtu\\.be\\/)([^"&?\\/\\s]{11})/i);';
		$html[] = '        if (ytMatch) embedUrl = "https://www.youtube.com/embed/" + ytMatch[1];';
		$html[] = '        else {';
		$html[] = '            var rtMatch = url.match(/rutube\\.ru\\/(?:video|play\\/embed)\\/([a-zA-Z0-9]+)/i);';
		$html[] = '            if (rtMatch) embedUrl = "https://rutube.ru/play/embed/" + rtMatch[1];';
		$html[] = '            else {';
		$html[] = '                if (url.indexOf("video_ext.php") !== -1) embedUrl = url;';
		$html[] = '                else {';
		$html[] = '                    var vkMatch = url.match(/vk\\.(?:com|ru)\\/(?:video)?(-?\\d+)_(\\d+)/i);';
		$html[] = '                    if (vkMatch) embedUrl = "https://vk.com/video_ext.php?oid=" + vkMatch[1] + "&id=" + vkMatch[2] + "&hd=2";';
		$html[] = '                }';
		$html[] = '            }';
		$html[] = '        }';
		$html[] = '        if (!embedUrl) { container.innerHTML = "<div class=\"alert alert-warning\">' . addslashes($invalidUrlText) . '</div>"; return; }';
		$html[] = '        container.innerHTML = "<div style=\"position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;\">" + ';
		$html[] = '            "<iframe src=\"" + embedUrl + "\" style=\"position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;\" allowfullscreen></iframe></div>";';
		$html[] = '    }';
		$html[] = '    input.addEventListener("input", updatePreview);';
		$html[] = '    input.addEventListener("change", updatePreview);';
		$html[] = '    updatePreview();';
		$html[] = '});';
		$html[] = '</script>';

		return implode("\n", $html);
	}
	
	/**
	 * Метод для получения разметки метки поля.
	 *
	 * @return  string  Разметка метки поля.
	 *
	 * @since   1.0.0
	 */
	protected function getLabel() {
		return parent::getLabel();
	}
}
