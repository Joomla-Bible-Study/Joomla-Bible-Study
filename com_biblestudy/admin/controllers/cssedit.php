<?php
/**
 * CSS Edit Controller for Bible Study Component
 * @version     $Id: cssedit.php 1466 2011-01-31 23:13:03Z bcordis $
 * @package BibleStudy
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 **/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

/**
 * Series Edit Controller
 *
 */
class biblestudyControllercssedit extends JController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
	}

function cancel()
	{
		$msg = JText::_( 'JBS_CMN_OPERATION_CANCELLED' );
		$this->setRedirect( 'index.php?option=com_biblestudy&view=cpanel', $msg );
	}
	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'cssedit' );
		JRequest::setVar( 'layout', 'default'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */

function resetcss() 
{
    $mainframe =& JFactory::getApplication();
    // Set FTP credentials, if given
	jimport('joomla.client.helper');
	JClientHelper::setCredentialsFromRequest('ftp');
	$ftp = JClientHelper::getCredentials('ftp');
    $filename		= 'biblestudy.css.dist';
	$src = JPATH_ROOT.DS.'components'.DS.'com_biblestudy'.DS.'assets'.DS.'css'.DS.$filename;
    $dest = JPATH_ROOT.DS.'components'.DS.'com_biblestudy'.DS.'assets'.DS.'css'.DS.'biblestudy.css';

	// Try to make the css file writeable

	jimport('joomla.filesystem.file');
    $return = JFile::copy($src, $dest);
	if ($return)
	{
	$mainframe->redirect('index.php?option=com_biblestudy&view=cpanel',  JText::_('JBS_CSS_RESET'));
	}
	else {
			$mainframe->redirect('index.php?option=com_biblestudy&view=cpanel', JText::_('JBS_CMN_OPERATION_FAILED').': '.JText::_('JBS_CMN_FAILED_OPEN_FOR_WRITE'));
	}
    

}

function save()
	{
		$mainframe =& JFactory::getApplication();


		// Initialize some variables
		$option			= JRequest::getCmd('option');
		$client			=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$filename		= 'biblestudy.css';
		$filecontent	= JRequest::getVar('filecontent', '', 'post', 'string', JREQUEST_ALLOWRAW);

		if (!$filecontent) {
			$mainframe->redirect('index.php?option=com_biblestudy&view=cpanel', JText::_('JBS_CMN_OPERATION_FAILED').': '.JText::_('JBS_CSS_CONTENT_EMPTY'));
		}

		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');
		$ftp = JClientHelper::getCredentials('ftp');

		$file = JPATH_ROOT.DS.'components'.DS.'com_biblestudy'.DS.'assets'.DS.'css'.DS.$filename;
		// Try to make the css file writeable

		jimport('joomla.filesystem.file');
		$return = JFile::write($file, $filecontent);


		if ($return)
		{

		$mainframe->redirect('index.php?option='.$option.'&view=cssedit',  JText::_('JBS_CSS_FILE_SAVED'));
		}
		else {
                        $mainframe->redirect('index.php?option=com_biblestudy&view=cpanel', JText::_('JBS_CMN_OPERATION_FAILED').': '.JText::_('JBS_CMN_FAILED_OPEN_FOR_WRITE').': '.$file);
		}
	}
	
function backup()
    {
        	$mainframe =& JFactory::getApplication();
            //Check for existence of com_biblestudy folder in media and create if it doesn't exist
            jimport('joomla.filesystem.folder');
            $mediafolderpath = JFolder::exists(JPATH_ROOT.DS.'media'.DS.'com_biblestudy'.DS.'backup');
            if (!$mediafolderpath)
            {
                $createmediafolder = JFolder::create(JPATH_ROOT.DS.'media'.DS.'com_biblestudy'.DS.'backup');
                if (!$createmediafolder)
                {
                    $mainframe->redirect('index.php?option=com_biblestudy&view=cpanel', JText::_('JBS_CMN_OPERATION_FAILED').': '.JText::_('JBS_CMN_FAILED_CREATE_FOLDER'));
                }
            }
            
            // Set FTP credentials, if given
    		jimport('joomla.client.helper');
    		JClientHelper::setCredentialsFromRequest('ftp');
    		$ftp = JClientHelper::getCredentials('ftp');
            $filename		= 'biblestudy.css';
    		$src = JPATH_ROOT.DS.'components'.DS.'com_biblestudy'.DS.'assets'.DS.'css'.DS.$filename;
            $dest = JPATH_ROOT.DS.'media'.DS.'com_biblestudy'.DS.'backup'.DS.'biblestudy.css';

    		// Try to make the css file writeable

    		jimport('joomla.filesystem.file');
            $return = JFile::copy($src, $dest);
    		if ($return)
    		{
    		$mainframe->redirect('index.php?option=com_biblestudy&view=cpanel',  JText::_('JBS_CSS_BACKUP_SAVED'));
    		}
    		else {
                    $mainframe->redirect('index.php?option=com_biblestudy&view=cpanel', JText::_('JBS_CMN_OPERATION_FAILED').': '.JText::_('JBS_CMN_FAILED_OPEN_FOR_WRITE').': '.$file);
    		}
    }

function copycss()
    {
        $mainframe =& JFactory::getApplication();
            // Set FTP credentials, if given
    		jimport('joomla.client.helper');
    		JClientHelper::setCredentialsFromRequest('ftp');
    		$ftp = JClientHelper::getCredentials('ftp');
            $filename		= 'biblestudy.css';
    		$dest = JPATH_ROOT.DS.'components'.DS.'com_biblestudy'.DS.'assets'.DS.'css'.DS.$filename;
            $src = JPATH_ROOT.DS.'media'.DS.'com_biblestudy'.DS.'backup'.DS.'biblestudy.css';

    		// Try to make the css file writeable

    		jimport('joomla.filesystem.file');
            $return = JFile::copy($src, $dest);
    		if ($return)
    		{
    		$mainframe->redirect('index.php?option=com_biblestudy&view=cpanel',  JText::_('JBS_CSS_BACKUP_RESTORED'));
    		}
    		else {
					$mainframe->redirect('index.php?option=com_biblestudy&view=cpanel', JText::_('JBS_CMN_OPERATION_FAILED').': '.JText::_('JBS_CMN_FAILED_OPEN_FOR_WRITE').': '.$file);
    		}
    }
function restorecss()
    {
        $mainframe =& JFactory::getApplication();
        jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');
		$ftp = JClientHelper::getCredentials('ftp');
        $filename		= 'biblestudy.css';
		$dest = JPATH_ROOT.DS.'components'.DS.'com_biblestudy'.DS.'assets'.DS.'css'.DS.$filename;
        $src = JPATH_ROOT.DS.'media'.DS.'com_biblestudy'.DS.'backup'.DS.'biblestudy.css';
        jimport('joomla.filesystem.file');
        $backupexists = JFile::exists($src);
        if (!$backupexists)
        {
            $mainframe->redirect('index.php?option=com_biblestudy&view=cpanel', JText::_('JBS_CMN_OPERATION_FAILED'));
        }
        $return = JFile::copy($src, $dest);
		if ($return)
		{
		$mainframe->redirect('index.php?option=com_biblestudy&view=cpanel',  JText::_('JBS_CSS_BACKUP_RESTORED'));
		}
		else {
				$mainframe->redirect('index.php?option=com_biblestudy&view=cpanel', JText::_('JBS_CMN_OPERATION_FAILED').': '.JText::_('JBS_CMN_FAILED_OPEN_FOR_WRITE').': '.$file);
		}
        
    }
}