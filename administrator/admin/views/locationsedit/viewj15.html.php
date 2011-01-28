<?php
/**
 * @version     $Id$
 * @package     com_biblestudy
 * @license     GNU/GPL
 */

//No Direct Access
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );


class biblestudyViewlocationsedit extends JView
{
	
	function display($tpl = null)
	{
		
		$locationsedit		=& $this->get('Data');
		$isNew		= ($locationsedit->id < 1);
		$lists = array();
		JHTML::_('stylesheet', 'icons.css', JURI::base().'components/com_biblestudy/css/');
		$text = $isNew ? JText::_( 'JBS_CMN_NEW' ) : JText::_( 'JBS_CMN_EDIT' );
		JToolBarHelper::title(   JText::_( 'JBS_LOC_LOCATION_EDIT' ).': <small><small>[ ' . $text.' ]</small></small>', 'locations.png' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			JToolBarHelper::apply();
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		jimport( 'joomla.i18n.help' );
		JToolBarHelper::help( 'biblestudy', true );
		$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $locationsedit->published);
		$this->assignRef('lists', $lists);
		$this->assignRef('locationsedit',		$locationsedit);

		parent::display($tpl);
	}
}
?>