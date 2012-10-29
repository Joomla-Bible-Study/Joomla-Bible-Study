<?php

/**
 * Bible Study Topics table class
 * @package BibleStudy.Admin
 * @Copyright (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.JoomlaBibleStudy.org
 * */
//No Direct Access
defined('_JEXEC') or die;

/**
 * Topic table class
 * @package BibleStudy.Admin
 * @since 7.0.0
 */
class TableTopic extends JTable {

    /**
     * Primary Key
     *
     * @var int
     */
    var $id = null;

    /**
     * Published
     * @var int
     */
    var $published = 1;

    /**
     * Topic text
     * @var string
     */
    var $topic_text = null;

    /**
     * Params
     * @var string
     */
    var $params = null;

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    public function Tabletopic(& $db) {
        parent::__construct('#__bsms_topics', 'id', $db);
    }

    /**
     * Method to bind an associative array or object to the JTable instance.This
     * method only binds properties that are publicly accessible and optionally
     * takes an array of properties to ignore when binding.
     *
     * @param   mixed  $array   An associative array or object to bind to the JTable instance.
     * @param   mixed  $ignore  An optional array or space separated list of properties to ignore while binding.
     *
     * @return  boolean  True on success.
     *
     * @link    http://docs.joomla.org/JTable/bind
     * @since   11.1
     */
    public function bind($array, $ignore = '') {
        if (isset($array['params']) && is_array($array['params'])) {
            $registry = new JRegistry();
            $registry->loadArray($array['params']);
            $array['params'] = (string) $registry;
        }

        // Bind the rules.
        if (isset($array['rules']) && is_array($array['rules'])) {
            $rules = new JRules($array['rules']);
            $this->setRules($rules);
        }

        return parent::bind($array, $ignore);
    }

    /**
     * Method to compute the default name of the asset.
     * The default name is in the form `table_name.id`
     * where id is the value of the primary key of the table.
     *
     * @return      string
     * @since       1.6
     */
    protected function _getAssetName() {
        $k = $this->_tbl_key;
        return 'com_biblestudy.topic.' . (int) $this->$k;
    }

    /**
     * Method to return the title to use for the asset table.
     *
     * @return      string
     * @since       1.6
     */
    protected function _getAssetTitle() {
        $title = 'JBS Topic: ' . $this->topic_text;
        return $title;
    }

    /**
     * Method to get the parent asset under which to register this one.
     * By default, all assets are registered to the ROOT node with ID 1.
     * The extended class can define a table and id to lookup.  If the
     * asset does not exist it will be created.
     *
     * @param   JTable   $table  A JTable object for the asset parent.
     * @param   integer  $id     Id to look up
     *
     * @return  integer
     *
     * @since   11.1
     */
    protected function _getAssetParentId($table = null, $id = null) {
        $asset = JTable::getInstance('Asset');
        $asset->loadByName('com_biblestudy');
        return $asset->id;
    }

    /**
     * Overloaded load function
     *
     * @param       int $pk primary key
     * @param       boolean $reset reset data
     * @return      boolean
     * @see JTable:load
     */
    public function load($pk = null, $reset = true) {
        if (parent::load($pk, $reset)) {
            // Convert the languages field to a registry.
            $params = new JRegistry;
            $params->loadString($this->params);
            $this->params = $params;
            return true;
        } else {
            return false;
        }
    }

    /**
     * check and (re-)construct the alias before storing the topic
     * @param array $data Data of record
     * @param int $recordId id
     *
     * @return      boolean true on success
     */
    public function checkAlias($data = array(), $recordId) {
        $topic = $data[topic_text];

        // topic_text not given? -> use the first language item with some text
        if ($topic == null || strlen($topic) == 0) {
            if (isset($data['params']) && is_array($data['params'])) {
                foreach ($data[params] AS $language) {
                    if (strlen($language) > 0) {
                        $topic = $language;
                        break;
                    }
                }
            }
        }

        // if still empty: use id
        // todo: For new items, this is always '0'. Next primary key would be nice...
        if ($topic == null || strlen($topic) == 0) {
            $topic = $recordId;
        }

        // add prefix if needed
        if (strncmp($topic, 'JBS_TOP_', 8) != 0) {
            $topic = 'JBS_TOP_' . $topic;
        }
        // and form well
        $topic = strtoupper(preg_replace('/[^a-z0-9]/i', '_', $topic));  // replace all non a-Z 0-9 by '_'
        $data[topic_text] = $topic;

        return $data;
    }

}