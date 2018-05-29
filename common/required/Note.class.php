<?php
	require_once('Core.class.php');

	class Note extends Core
	{
		public function __construct($id=0)
		{
			$this->table = "notes";
			$this->obj_type	= "Record Notes";
			$this->id_field	= NULL;
			$this->req_fields = array("type", "content", "ref_fk", "ref_table", "last_update_by");
			$this->opt_fields = array("deleted");
			$this->func_fields = NULL;
			$this->insert_field = array("created_by" => "POST");
			$this->list_fields = array("id", "type", "content", "DATE_FORMAT(last_udpate, '%m/%d/%Y %h:%i%a') AS lastUpdate");
			$this->load_fields = array("id", "type", "content", "ref_fk", "DATE_FORMAT(created, '%m/%d/%Y %h:%i%p') AS createdDisp");
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
		* Delete notes/tasks associated with practice [n]
		*
		*
		*
		*****************************************************************************************************************************/
		public function deleteByPractice($practice_fk, $del)
		{
			$this->sql = "UPDATE notes SET deleted={$del} WHERE practice_fk={$practice_fk}";
			$this->execSql("Setting note Deleted Flag", UPDATE);
		}

		/*****************************************************************************************************************************
		* Search for tasks already in the system
		*
		*
		*
		*****************************************************************************************************************************/
		public function search($term)
		{
			$db = DBManager::getConnection();
			$term = $db->real_escape_string(trim($term));

			$this->sql = "SELECT id, content FROM notes WHERE type='task' AND (content LIKE '{$term}%')";
			$this->execSql("Loading tasks already in the system", SELECT_MULTI);
		}

		/*****************************************************************************************************************************
		* Retrieve all notes for a specific practice/lead/distributor
		*
		*
		*
		*****************************************************************************************************************************/
		public function listNotes($id, $ref_table)
		{
			$this->sql = "SELECT id, type, content, DATE_FORMAT(last_update, '%m/%d/%Y %h:%i%p') AS last_update, last_update_by
							FROM notes WHERE ref_table='{$ref_table}' AND ref_fk='{$id}'";

			$this->execSql("Selecting notes by reference", SELECT_MULTI);
		}
	}
