<?php

/**
 * Joomla Bible Study Export/Import default controller
 * 
 * @license		GNU/GPL
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
include_once(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jbsexportimport' . DS . 'restore.php');
include_once(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jbsexportimport' . DS . 'backup.php');

/**
 * JBS Export Import Component Controller
 *
 * 
 */
class jbsexportimportController extends JController {

    /**
     * Method to display the view
     *
     * @access	public
     */
    function display() {

        $task = JRequest::getWord('task', '', 'get');
        $run = 0;

        $run = JRequest::getInt('run', '', 'get');

        $import = JRequest::getVar('file', '', 'post');
        //   print_r($task);
        if ($task == 'export' && $run == 1) {
            $export = new JBSExport();
            $result = $export->exportdb();
            if ($result) {
                $application->enqueueMessage('' . JText::_('JBS_EI_SUCCESS') . '');
            } else {
                $application->enqueueMessage('' . JText::_('JBS_EI_EXPORT_FAILURE') . '');
            }
        }

        parent::display();
    }

    function doimport() {
        $application = JFactory::getApplication();
        $import = new JBSImport();
        $result = $import->importdb();
        if ($result) {
            $application->enqueueMessage('' . JText::_('JBS_EI_SUCCESS') . '');
        } else {
            $application->enqueueMessage('' . JText::_('JBS_EI_IMPORT_FAILURE') . '');
        }

        parent::display();
    }

}

?>