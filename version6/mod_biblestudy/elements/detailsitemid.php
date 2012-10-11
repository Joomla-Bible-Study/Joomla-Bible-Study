<?php
/**
* @version		$Id: contact.php 8591 2007-08-27 21:09:32Z hackwar $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementdetailsitemid extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'detailsitemid';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db = &JFactory::getDBO();
//the menu items have link names like: index.php?option=com_biblestudy&view=studydetails&id=547 so how to query that?

		$query = "SELECT m.id, CONCAT(m.id,' - ',m.name) AS text, m.link"
		. "\n FROM #__menu AS m"
		. "\n WHERE m.link LIKE '%studydetails%'"
		. "\n ORDER BY m.name ASC"
		;
		$db->setQuery( $query );
		$options = $db->loadObjectList( );
		array_unshift($options, JHTML::_('select.option', '0', '- '.JText::_('Select a Menu Item').' -', 'id', 'text'));
		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'id', 'text', $value, $control_name.$name );
	}
}
//CONCAT(#__bsms_books.bookname,':',#__bsms_studies.chapter_begin,' - ',#__bsms_studies.studydate)