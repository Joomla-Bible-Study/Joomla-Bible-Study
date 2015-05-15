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

require_once JPATH_ADMINISTRATOR . '/components/com_biblestudy/lib/defines.php';
/**
 * This is a dummy form element to load the components language file
 *
 * @package  BibleStudy.Admin
 * @since    9.0.0
 */
class JFormFieldLoadLanguageFile extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 */
	protected $type = 'LoadLanguageFile';

	/**
	 * The hidden state for the form field.
	 *
	 * @var    boolean
	 */
	protected $hidden = true;

	/**
	 * Get Lable
	 *
	 * @return null;
	 */
	public function getLabel()
	{
		// Return an empty string; nothing to display
		return '';
	}

	/**
	 * Method to load the laguage file; nothing to display.
	 *
	 * @return  string  The field input markup.
	 */
	protected function getInput()
	{
		// Get language file; english language as fallback
		$language = JFactory::getLanguage();
		$language->load('com_biblestudy', BIBLESTUDY_PATH_ADMIN, 'en-GB', true);
		$language->load('com_biblestudy', BIBLESTUDY_PATH_ADMIN, null, true);

		// Return an empty string; nothing to display
		return '';
	}
}