<?php
	require_once('Core.class.php');

	class Driver extends Core
	{
		public function __construct($id=0){
			$this->table  = "drivers";
			$this->obj_type = "Driver";
			$this->id_field = NULL;
			$this->req_fields = array("username", "passwd", "company_fk", "last_update_by");
			$this->opt_fields = array();
			$this->func_fields = NULL;
			$this->insert_fields = array("created_by" => "POST");
			$this->list_fields = array("username", "passwd", "company_fk",);
			$this->load_fields = array("username", "passwd", "company_fk",);
			$this->noDuplicates = array("username");
			$this->max_per_page = 20;
			$this->joins = NULL;
			$this->id = $id;
			if($id > 0) $this->load();
		}

		public function findDriver($company, $username, $passwd) {
      $db = DBManager::getConnection();
      $company = $db->real_escape_string(trim($company));
      $code = $db->real_escape_string(trim($code));

			$where = "WHERE username = '{$username}' and passwd = '{$passwd}' and company_fk = {$company}";

			$this->sql = "SELECT D.username, D.company_fk FROM drivers D
										LEFT JOIN companies C ON C.id = D.company_fk
										{$where}";

      $this->execSql("List of Drivers", SELECT_MULTI);
    }

		public function clockIn($company, $username, $passwd) {
			return 1;
		}

	}
