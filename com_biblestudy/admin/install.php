<?php
/**
 * BibleStudy Component
 *
 * @package       BibleStudy.Installer
 *
 * @copyright (C) 2008 - 2015 BibleStudy Team. All rights reserved.
 * @license       http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link          http://www.joomlabiblestudy.org
 **/
defined('_JEXEC') or die ();

/**************************/
/* KUNENA FORUM INSTALLER */
/**************************/

$app  = JFactory::getApplication();
$view = $app->input->getCmd('view');
$task = $app->input->getCmd('task');

// Special case for developer versions.
if ($view != 'install' && class_exists('BibleStudyForum') && BibleStudyForum::isDev())
{
	// Developer version found: Check if latest version of Kunena has been installed. If not, prepare installation.
	require_once __DIR__ . '/install/version.php';

	$kversion = new BibleStudyVersion();

	if (!$kversion->checkVersion())
	{
		JFactory::getApplication()->redirect(JUri::base(true) . '/index.php?option=com_biblestudy&view=install');
	}

	return;
}

// Run the installer...
require_once __DIR__ . '/install/controller.php';

$controller = new BibleStudyControllerInstall();
$controller->execute($task);
$controller->redirect();
