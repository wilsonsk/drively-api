<?php
	require_once('Core.class.php');

	class Contact extends Core
	{
		public function __construct($id=0)
		{
			$this->table = "contacts";
			$this->obj_type	= "contact";
			$this->id_field	= NULL;
			$this->req_fields = array("ref_fk", "ref_table");
			$this->opt_fields = array("fname", "lname", "phone", "extension", "fax", "mobile", "email", "title", "description", "last_update_by");
			$this->func_fields = NULL;
			$this->insert_fields = array("created_by" => "POST");
			$this->list_fields = array("id", "DATE_FORMAT(last_udpate, '%m/%d/%Y %h:%i%a') AS lastUpdate", "CONCAT(fname, ' ', lname)", "email", "phone");
			$this->load_fields = array("id", "fname", "lname", "phone", "extension", "fax", "mobile", "email", "title", "description", "ref_fk", "ref_table");
			$this->noDuplicates	= NULL;
			$this->max_per_page	= 20;
			$this->joins = NULL;
			$this->id = $id;
			if($id > 0) $this->load();
		}

		/*****************************************************************************************************************************
		* User info for save
		*
		*
		*
		*****************************************************************************************************************************/
		public function save()
		{
			$db = DBManager::getConnection();
			$_POST['last_update_by'] = $db->real_escape_string($_SESSION[ADMIN_SITE]['uname']);

			if($this->id < 1)
				$_POST["created_by"] = $_POST['last_update_by'];

			parent::save();
		}

		/*****************************************************************************************************************************
		* Get all all contacts associated with a lead/practice/distributor/dist-rep
		*
		*
		*
		*****************************************************************************************************************************/
		public function listContacts($type, $fk)
		{
			$this->sql = "SELECT id, CONCAT(' ', fname, ' ', lname) as contact_name, DATE_FORMAT(last_update, '%m/%d/%y %h:%i%p') AS last_update, 
							last_update_by, phone, extension, email, title, ref_fk, ref_table
							FROM contacts 
							WHERE ref_table='{$type}' AND ref_fk={$fk}";
			$this->execSql("Retrieve Contacts", SELECT_MULTI);
		}
	}