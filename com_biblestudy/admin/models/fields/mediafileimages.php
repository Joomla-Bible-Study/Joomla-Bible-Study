<?php
/**
 * Part of Joomla BibleStudy Package
 *
 * @package    BibleStudy.Admin
 * @copyright  2007 - 2015 (C) Joomla Bible Study Team All rights reserved
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://www.JoomlaBibleStudy.org
 * */
// No Direct Access
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

JFormHelper::loadFieldClass('list');

/**
 * Location List Form Field class for the Joomla Bible Study component
 *
 * @package  BibleStudy.Admin
 * @since    7.0.0
 */
class JFormFieldMediafileImages extends JFormFieldList
{

	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'Mediafileimages';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return      array           An array of JHtml options.
	 */
	protected function getOptions()
	{

			$db    = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from('#__bsms_mediafiles');
			$db->setQuery((string) $query);
			$mediafiles = $db->loadObjectList();


		$options = array();

		if ($mediafiles)
		{
			foreach ($mediafiles as $media)
			{
				$reg = new Registry;
				$reg->loadString($media->params);
				$media->params = $reg;
				if ($media->params->get('media_use_button_icon') >= 1)
				{
					switch ($media->params->get('media_use_button_icon'))
					{
						case 1:
							$button = $this->getButton($media);
							$media->media_image = $button;
							break;
						case 2:
							$button = $this->getButton($media);
							$icon = $this->getIcon($media);
							$media->media_image = $button.' - '.$icon;
							break;
						case 3:
							$icon = $this->getIcon($media);
							$media->media_image = $icon;
							break;
					}
				}
				else{
					$image = $media->params->get('media_image');
					$totalcount = strlen($image);
					$slash = strrpos($image,'/');
					$imagecount = $totalcount - $slash;
					$media->media_image = substr($image,$slash + 1,$imagecount);
				}

				$options[]       = JHtml::_('select.option', $media->media_image, $media->media_image
				);
			}

		}

		$tmp = array();
		foreach($options as $k => $v)
			$tmp[$k] = $v->text;

// Find duplicates in temporary array
		$tmp = array_unique($tmp);

// Remove the duplicates from original array
		foreach($options as $k => $v)
		{
			if (!array_key_exists($k, $tmp))
				unset($options[$k]);
		}
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}

	public function getButton($media)
	{
		switch ($media->params->get('media_button_type'))
		{
			case 'btn-link':
				$button = JText::_('JBS_MED_NO_COLOR');
				break;
			case 'btn-primary':
				$button = JText::_('JBS_MED_PRIMARY');
				break;
			case 'btn-success':
				$button = JText::_('JBS_MED_SUCCESS');
				break;
			case 'btn-info':
				$button = JText::_('JBS_MED_INFO');
				break;
			case 'btn-warning':
				$button = JText::_('JBS_MED_WARNING');
				break;
			case 'btn-danger':
				$button = JText::_('JBS_MED_DANGER');
				break;
		}
		return $button;
	}

	public function getIcon($media)
	{
		switch ($media->params->get('media_icon_type'))
		{
			case 'icon-play':
				$icon = JText::_('JBS_MED_PLAY');
				break;
			case 'icon-youtube':
				$icon = JText::_('JBS_MED_YOUTUBE');
				break;
			case 'icon-video':
				$icon = JText::_('JBS_MED_VIDEO');
				break;
			case 'icon-broadcast':
				$icon = JText::_('JBS_MED_BROADCAST');
				break;
			case 'icon-file-2':
				$icon = JText::_('JBS_MED_FILE');
				break;
			case '1':
				$icon = JText::_('JBS_MED_CUSTOM');
				break;
		}
		return $icon;
	}
}
