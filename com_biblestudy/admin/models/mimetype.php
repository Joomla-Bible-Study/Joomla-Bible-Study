<?php

/**
 * MimeType model
 * @package BibleStudy.Admin
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 */
//No Direct Access
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Mime Typew Admin model
 * @package BibleStudy.Admin
 * @since 7.0.0
 */
class BiblestudyModelMimetype extends JModelAdmin {

    /**
     * Method override to check if you can edit an existing record.
     *
     * @param       array   $data   An array of input data.
     * @param       string  $key    The name of the key for the primary key.
     *
     * @return      boolean
     * @since       1.6
     */
    protected function allowEdit($data = array(), $key = 'id') {
        // Check specific edit permission then general edit permission.
        return JFactory::getUser()->authorise('core.edit', 'com_biblestudy.mimetype.' . ((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
    }

    /**
     * Method to store a record
     *
     * @access	public
     * @return	boolean	True on success
     */
    public function store() {
        $row = & $this->getTable();

        $data = JRequest::get('post');

        // Bind the form fields to the hello table
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        // Make sure the record is valid
        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        // Store the table to the database
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            //			$this->setError( $row->getErrorMsg() );
            return false;
        }

        return true;
    }

    /**
     * Get the form data
     *
     * @param array $data
     * @param boolean $loadData
     * @return boolean|object
     * @since 7.0
     */
    public function getForm($data = array(), $loadData = true) {
        // Get the form.
        $form = $this->loadForm('com_biblestudy.mimetype', 'mimetype', array('control' => 'jform', 'load_data' => $loadData));

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * Load Form Data
     * @return abject
     * @since   7.0
     */
    protected function loadFormData() {
        $data = JFactory::getApplication()->getUserState('com_biblestudy.edit.mimetype.data', array());
        if (empty($data))
            $data = $this->getItem();

        return $data;
    }

    /**
     * Custom clean the cache of com_biblestudy and biblestudy modules
     * @param string $group
     * @param int $client_id
     * @since	1.6
     */
    protected function cleanCache($group = null, $client_id = 0) {
        parent::cleanCache('com_biblestudy');
        parent::cleanCache('mod_biblestudy');
    }

}