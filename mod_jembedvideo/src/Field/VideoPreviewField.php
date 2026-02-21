<?php
namespace JoomPro\Module\JEmbedVideo\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Form\Field\FormField;
use JoomPro\Module\JEmbedVideo\Helper\JEmbedVideoHelper;
use Joomla\CMS\Language\Text;

/**
 * Field for previewing the video in the admin area.
 *
 * @since  1.0.0
 */
class VideoPreviewField extends FormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	protected $type = 'VideoPreview';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   1.0.0
	 */
	protected function getInput()
	{
		// Try to get from the form control.
		$videoUrl = $this->form->getValue('video_url', 'params');
		
		if (empty($videoUrl))
		{
			return '<div class="alert alert-info">' . Text::_('MOD_JEMBEDVIDEO_PREVIEW_NO_URL') . '</div>';
		}

		// Use the helper to get the embed URL
		$embedUrl = JEmbedVideoHelper::getEmbedUrl($videoUrl);

		if (!$embedUrl)
		{
			return '<div class="alert alert-warning">' . Text::_('MOD_JEMBEDVIDEO_PREVIEW_INVALID_URL') . '</div>';
		}

		// Render the iframe
		$html = [];
		$html[] = '<div style="max-width: 500px; margin-top: 10px;">';
		$html[] = '  <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;">';
		$html[] = '    <iframe src="' . htmlspecialchars($embedUrl, ENT_QUOTES, 'UTF-8') . '" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowfullscreen></iframe>';
		$html[] = '  </div>';
		$html[] = '</div>';

		return implode('', $html);
	}
	
	/**
	 * Method to get the field label markup.
	 *
	 * @return  string  The field label markup.
	 *
	 * @since   1.0.0
	 */
	protected function getLabel() {
		return parent::getLabel();
	}
}
