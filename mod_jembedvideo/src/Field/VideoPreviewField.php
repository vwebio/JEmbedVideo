<?php
namespace Joomla\Module\JEmbedVideo\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Form\Field\FormField;
use Joomla\Module\JEmbedVideo\Helper\JEmbedVideoHelper;
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
		// Пытаемся получить значение из формы.
		$videoUrl = $this->form->getValue('video_url', 'params');
		
		if (empty($videoUrl))
		{
			return '<div class="alert alert-info">' . Text::_('MOD_JEMBEDVIDEO_PREVIEW_NO_URL') . '</div>';
		}

		// Используем хелпер для получения embed ссылки
		$embedUrl = JEmbedVideoHelper::getEmbedUrl($videoUrl);

		if (!$embedUrl)
		{
			return '<div class="alert alert-warning">' . Text::_('MOD_JEMBEDVIDEO_PREVIEW_INVALID_URL') . '</div>';
		}

		// Рендерим iframe
		$html = [];
		$html[] = '<div style="max-width: 500px; margin-top: 10px;">';
		$html[] = '  <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;">';
		$html[] = '    <iframe src="' . htmlspecialchars($embedUrl, ENT_QUOTES, 'UTF-8') . '" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowfullscreen></iframe>';
		$html[] = '  </div>';
		$html[] = '</div>';

		return implode('', $html);
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
