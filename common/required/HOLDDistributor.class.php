<?php
	require_once('Core.class.php');

	class Distributor extends Core
	{
		public function __construct($id=0){
			$this->table  = "distributors";
			$this->obj_type = "Distributor";
			$this->id_field = NULL;
			$this->req_fields = array("location_fk", "practice_fk", "fname",  "last_update_by");
			$this->opt_fields = array("lname", "email", "phone", "mobile", "title", "description");
			$this->func_fields = NULL;
			$this->insert_fields = array("created_by" => "POST");
			$this->list_fields = array("id",
										"fname",
										"lname",
										"location_fk",
										"practice_fk",
										"phone",
										"email",
										"title",
										"last_update");
			$this->load_fields = array("practice_contacts.id",
										"practice_contacts.description",
										"location_fk",
										"practice_contacts.practice_fk",
										"fname", "lname",
										"practice_contacts.email",
										"practice_contacts.phone", "mobile",
										"title",
										"DATE_FORMAT(practice_contacts.last_update, '%m/%d/%Y %h:%i%p') AS lastUpdate",
										"CONCAT(address,', ',city,', ',state,' ',zip) AS address",
										"practice_contacts.last_update_by");
			$this->noDuplicates = array("fname", "lname", "practice_fk", "location_fk", "deleted");
			$this->max_per_page = 15;
			$this->joins = array("LEFT JOIN practice_locations ON practice_contacts.location_fk=practice_locations.id");
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
		* Admin paginate through tasks
		*
		*
		*
		*****************************************************************************************************************************/
		public function paginate($page, $filter=NULL, $search=NULL)
		{
			$db = DBManager::getConnection();
			$search = $db->real_escape_string(trim($search));
			$where = " WHERE ";

			if($filter)
				$where .= $filter;
			if($search)
				$where .= ($where == " WHERE " ? "" : " AND") . " owned_by_name LIKE '{$search}%'";

			$this->sql = "SELECT COUNT(id) FROM distributors" . ($where == " WHERE " ? "" : $where);
			$this->execSql("Calculating task pages", ROW_COUNT);
			
			$this->sql = 	"SELECT id, compnay_name
							FROM distributors" . ($where == " WHERE " ? "" : $where);
							//ORDER BY p.name ASC";

			if ($this->max_per_page !== NULL)
				$this->sql .= " LIMIT " . (($page === NULL || $page < 1) ? '' : (($page - 1) * $this->max_per_page) . ",") . $this->max_per_page;

			$this->execSql("List Page of distributors", SELECT_MULTI);
		}


		/*****************************************************************************************************************************
		* Delete Contact by Practice
		*
		*
		*
		*****************************************************************************************************************************/
		public function deleteByPractice($cust, $del)
		{
			$this->sql = "UPDATE practice_contacts SET deleted={$del} WHERE practice_fk={$cust}";
			$this->execSql("Setting Practice Contact Deleted Flag", UPDATE);
		}

		/*****************************************************************************************************************************
		* Load locations based on practice
		*
		*
		*
		*****************************************************************************************************************************/
		public function loadByCompany($page, $fk)
		{
			$this->sql = "SELECT COUNT(practice_contacts.id)
							FROM practice_contacts
							WHERE practice_contacts.practice_fk={$fk}";
			$this->execSql("Calculating practice Location Pages", ROW_COUNT);

			$this->sql = "SELECT
							practices.id AS practice_id,
					 		practice_contacts.id,
							CONCAT(fname,' ',lname) AS name,
							practice_contacts.phone,
							title,
							practice_contacts.email,
							practice_contacts.last_update,
							practice_locations.id AS location_id,
							CONCAT(practice_locations.address, ' ',
									IF(practice_locations.address_two IS NOT NULL, practice_locations.address_two, ' '),
									practice_locations.city, ', ',
									practice_locations.state, ' ',
									practice_locations.zip) AS location
						FROM practice_contacts
						JOIN practices ON practice_contacts.practice_fk=practices.id
						JOIN practice_locations ON practice_contacts.location_fk=practice_locations.id
						WHERE practice_contacts.practice_fk={$fk}
						ORDER BY lname ASC";

			if ($this->max_per_page !== NULL)
	            $this->sql .= " LIMIT " . (($page === NULL || $page < 1) ? '' : (($page - 1) * $this->max_per_page) . ",") . $this->max_per_page;

			$this->execSql("List Page of Practice Locations", SELECT_MULTI);
		}

		public function listDistributors()
		{
			$this->sql = "SELECT id, company_name FROM distributors";
			$this->execSql("Loading list of distributors", SELECT_MULTI);
		}

		public function loadByDistributor($company_fk)
		{
			$this->sql = "SELECT id,
											name,
											billing_street,
											shipping_street,
											billing_city,
											shipping_city,
											billing_state,
											shipping_state,
											billing_code,
											shipping_code,
											billing_country,
											shipping_country,
											owner_fk
										FROM distributors
										WHERE company_fk={$company_fk}";
			$this->execSql("Loading distributors by company", SELECT_MULTI);
		}
	}
