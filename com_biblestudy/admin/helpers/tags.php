<?php
/**
 * Part of Joomla BibleStudy Package
 *
 * @package    BibleStudy.Admin
 * @copyright  2007 - 2016 (C) Joomla Bible Study Team All rights reserved
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       https://www.joomlabiblestudy.org
 * */
// No Direct Access
defined('_JEXEC') or die;

/**
 * Tags Helper
 *
 * @package  BibleStudy.Admin
 * @since    7.0.0
 **/
class JBSMTags
{
	/**
	 * Extension Name
	 *
	 * @var string
	 *
	 * @since 1.5
	 */
	public static $extension = 'com_biblestudy';

	/**
	 * Check to see if Duplicate
	 *
	 * @param   int  $study_id  ?
	 * @param   int  $topic_id  ?
	 *
	 * @return boolean
	 *
	 * @since 7.0
	 */
	public static function isDuplicate($study_id, $topic_id)
	{
		JFactory::getApplication()->enqueueMessage('Need to update this function', 'error');

		return true;
	}
}
