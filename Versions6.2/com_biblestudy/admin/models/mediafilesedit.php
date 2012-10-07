<?php
/**
 * @version     $Id: mediafilesedit.php 1330 2011-01-06 08:01:38Z genu $
 * @package     com_biblestudy
 * @license     GNU/GPL
 */
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class biblestudyModelmediafilesedit extends JModel {
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	var $_admin;
	function __construct()
	{
		parent::__construct();
		$admin = $this->getAdmin();
		$this->_admin_params = new JParameter($admin[0]->params);
		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}


	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}


	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__bsms_mediafiles '.
					'  WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			//TF added these
			$today = date("Y-m-d H:i:s");
			$this->_data->published = 1;
			$this->_data->media_image = null;
			$this->_data->server = ($this->_admin_params->get('server') > 0 ? $this->_admin_params->get('server') : null);
			$this->_data->path = ($this->_admin_params->get('path') > 0 ? $this->_admin_params->get('path') : null);
			$this->_data->special =($this->_admin_params->get('target') != 'No default' ? $this->_admin_params->get('target') : null);;
			$this->_data->filename = null;
			$this->_data->size = null;
			$this->_data->podcast_id = ($this->_admin_params->get('podcast') > 0 ? $this->_admin_params->get('podcast') : null);
			$this->_data->internal_viewer = null;
			$this->_data->mediacode = null;
			$this->_data->ordering = null;
			$this->_data->study_id = null;
			$this->_data->createdate = $today;
			$this->_data->link_type = ($this->_admin_params->get('download') > 0 ? $this->_admin_params->get('download') : null);
			$this->_date->hits = null;
			$this->_data->mime_type = ($this->_admin_params->get('mime') > 0 ? $this->_admin_params->get('mime') : null);
			$this->_data->docMan_id = null;
			$this->_data->article_id = null;
			$this->_data->comment = null;
			$this->_data->virtueMart_id = null;
			$this->_data->params = null;

		}
		return $this->_data;
	}

	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store()
	{
		$row =& $this->getTable();

		$data = JRequest::get( 'post' ); //dump ($data, 'data: ');
		//This checks to see if the user has uploaded a file instead of just entered one in the box. It replaces the filename with the name of the uploaded file

		$file = JRequest::getVar('file', null, 'files', 'array' );
		$filename_upload = $file['name'];
		if (isset($filename_upload)){
			$name_bak = $data['filename'];
			$data['filename'] = $filename_upload;
		}
		if ($filename_upload == ''){
			$data['filename'] = $name_bak;
		}

		if ($this->_admin_params->get('character_filter') > 0)
		{
			$badchars = array(' ', '`', '@', '^', '!', '#', '$', '%', '*', '(', ')', '[', ']', '{', '}', '~', '?', '>', '<', ',', '|', '\\', ';');
			$data['filename'] = str_replace($badchars, '_', $data['filename']);
		}
		$data['filename'] = str_replace('&', '_and_', $data['filename']);
		$data['mediacode'] = str_replace('"',"'",$data['mediacode']);
		// Bind the form fields to the  table
		if($data['docManItem'] == null) {
			$data['docMan_id'] = 0;
		}else{
			$data['docMan_id'] = $data['docManItem'];
		}
		if($data['virtueMartItem'] == null){
			$data['virtueMart_id'] = 0;
		}else{
			$data['virtueMart_id'] = $data['virtueMartItem'];
		}
		if($data['categoryItem'] == null){
			$data['article_id'] = 0;
		}else{
			$data['article_id'] = $data['categoryItem'];
		}

		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the  record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}

	/**
	 * Method to delete record(s)
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$row =& $this->getTable();

		if (count( $cids ))
		{
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
		return true;
	}
	function publish($cid = array(), $publish = 1)
	{

		if (count( $cid ))
		{
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__bsms_mediafiles'
			. ' SET published = ' . intval( $publish )
			. ' WHERE id IN ( '.$cids.' )'
				
			;
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
	}
	/**
	 * Method to move a mediafile listing
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function move($direction)
	{
		$row =& $this->getTable();
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->move( $direction, ' study_id = '.(int) $row->study_id.' AND published >= 0 ' )) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}

	/**
	 * Method to move a mediafile listing
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function saveorder($cid = array(), $order)
	{
		$row =& $this->getTable();
		$groupings = array();

		// update ordering values
		for( $i=0; $i < count($cid); $i++ )
		{
			$row->load( (int) $cid[$i] );
			// track categories
			$groupings[] = $row->study_id;

			if ($row->ordering != $order[$i])
			{
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}
		}

		// execute updateOrder for each parent group
		$groupings = array_unique( $groupings );
		foreach ($groupings as $group){
			$row->reorder('study_id = '.(int) $group);
		}

		return true;
	}

	function getAdmin()
	{
		if (empty($this->_admin)) {
			$query = 'SELECT params'
			. ' FROM #__bsms_admin'
			. ' WHERE id = 1';
			$this->_admin = $this->_getList($query);
		}
		return $this->_admin;
	}


	/**
	 * @desc Functions to satisfy the ajax requests
	 */
	function getdocManCategories() {
		$query = "SELECT id, title FROM #__categories
				  WHERE `section` = 'com_docman' AND `published`=1";
		return $this->_getList($query);
	}

	function getvirtueMartCategories(){
		$query = "SELECT category_id AS id, category_name AS title FROM `#__vm_category` WHERE `category_publish` = 'Y'";
		return $this->_getList($query);
	}
	function getdocManCategoryItems($catId) {
		$query = "SELECT id, dmname as name FROM #__docman
				  WHERE `catid`='$catId' AND `published`=1";
		return json_encode($this->_getList($query));
	}

	function getArticlesSections(){
		$query = "SELECT id, title FROM #__sections WHERE `published` = 1";
		return $this->_getList($query);
	}

	function getArticlesSectionCategories($secId) {
		$query = "SELECT id, title FROM #__categories WHERE `section` = '$secId' AND `published` = 1";
		return json_encode($this->_getList($query));
	}

	function getCategoryItems($catId) {
		$query = "SELECT id, title FROM #__content WHERE `state` = 1 AND `catid` = '$catId'";
		return json_encode($this->_getList($query));
	}

	function getVirtueMartItems($catId){
		$query = "SELECT #__vm_product_category_xref.product_id AS id, #__vm_product.product_name as title
				  FROM #__vm_product_category_xref 
				  LEFT JOIN jos_vm_product 
				  ON #__vm_product_category_xref.product_id=#__vm_product.product_id 
				  WHERE #__vm_product_category_xref.category_id = $catId 
				  ORDER BY #__vm_product.product_name ASC LIMIT 0, 30 ";
		return json_encode($this->_getList($query));
	}

	function getDocManItem($id) {
		$query = "SELECT dmname FROM #__docman WHERE `id` = '$id'";
		$this->_db->setQuery($query);
		$data = $this->_db->loadRow();
		return $data[0];
	}

	function getArticleItem($id) {
		$query = "SELECT title FROM #__content WHERE `id` = '$id'";
		$this->_db->setQuery($query);
		$data = $this->_db->loadRow();
		return $data[0];
	}
	function getVirtueMartItem($id){
		$query = "SELECT product_name AS name FROM #__vm_product WHERE `product_id` = $id";
		$this->_db->setQuery($query);
		$data = $this->_db->loadRow();
		return $data[0];
	}

	function getStudy() {
		$query = 'SELECT id, studytitle, studydate FROM #__bsms_studies ORDER BY id DESC LIMIT 1';
		$this->_db->setQuery($query);
		return $this->_db->loadObject();
	}

	function getStudies() {
		$query = "SELECT id AS value, CONCAT(studytitle,' - ', date_format(studydate, '%a %b %e %Y'), ' - ', studynumber) AS text FROM #__bsms_studies ORDER BY studydate DESC";
		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}

	function getServers() {
		$query = 'SELECT id AS value, server_path AS text, published'
		. ' FROM #__bsms_servers'
		. ' WHERE published = 1'
		. ' ORDER BY server_path';
		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}

	function getFolders() {
		$query = 'SELECT id AS value, folderpath AS text, published'
		. ' FROM #__bsms_folders'
		. ' WHERE published = 1'
		. ' ORDER BY folderpath';
		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}

	function getPodcasts() {
		$query = 'SELECT id AS value, title AS text FROM #__bsms_podcast WHERE published = 1 ORDER BY title ASC';
		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}

	function getMediaImages() {
		$query = 'SELECT id AS value, media_image_name AS text, published'
		. ' FROM #__bsms_media'
		. ' WHERE published = 1'
		. ' ORDER BY media_image_name';
		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}

	function getMimeTypes() {
		$query = 'SELECT id AS value, mimetext AS text, published FROM #__bsms_mimetype WHERE published = 1 ORDER BY id ASC';
		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}

	function getOrdering() {
		$query = 'SELECT ordering AS value, ordering AS text'
		. ' FROM #__bsms_mediafiles'
		. ' WHERE study_id = '.$this->_id
		. ' ORDER BY ordering'
		;
		return $query;
	}

}