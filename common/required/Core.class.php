<?php
	require_once("DBManager.class.php");
	
	class Core{
				
		public $table;				// This table
		public $obj_type;			// Object type description, used for Error reporting
		protected $id_field;		// Field in the HTML DOM that contains the ID for the Object
		protected $req_fields; 		// DB fields that are required, i.e. NOT NULL
		protected $opt_fields; 		// Optional fields
		protected $func_fields; 	// Fields that should be populated with function return values, i.e now()
		protected $insert_fields;	// Fields that should only be populated at INSERT, field => post|func
		protected $list_fields; 	// Fields retrieved for the DB for list operations
		protected $load_fields; 	// Fields retrieved from the DB for single row/item display/edit
		protected $noDuplicates;	// Avoid duplicate entries based on values in these fields
		protected $max_per_page;	// Number of items/rows per page in list operations
		protected $joins;			// Table joins, hashed array: hash=[join_type~]table,
		 							// value=joining_table.field=this_table.field
	
		protected $replaceHTML = array('®', '', '', '', "’"); //Array of chars we want removed from textual input
		protected $replaceHTMLWith = array('&reg;', '&trade;', '"', "'", "'"); //Array of chars we want instead
		protected $sql;				// SQL Statement to be built and excuted
		public $errors;				// Store errors discovered before executing a save to the system
		public $pages;				// Total pages for listing operations
		public $record_count;		// Total records for a list retrieval
		public $id;					// The ID of this object
		public $data;				// Storage mechanism for SELECTS
			

		/*****************************************************************************************************************************
		* Cycles through the $req_fields and $opt_fields arrays to create either an update or insert SQL statement
		* based on the value of $type: INSERT|UPDATE. Calls to this function from objects should be made after
		* successful pass of data to validate function.
		*
		*****************************************************************************************************************************/
		protected function buildCommitSql($type)
		{
			$sql = "INSERT INTO $this->table(";
			$sqlVals = ") VALUES(";
			if($type == UPDATE)	$sql = "UPDATE $this->table SET ";
			
			$tmp = NULL;
			$comma = NULL;
			
			// Required Fields
			if($this->req_fields !== NULL)
			{
				foreach($this->req_fields as $rf)
				{				
					if(!is_null($this->func_fields) && array_key_exists($rf, $this->func_fields))
					{
						$sql .= $comma.$rf.(($type == INSERT)?NULL:"=".$this->func_fields[$rf]);
						$sqlVals .= $comma.$this->func_fields[$rf];
					}
					else
					{
						$tmp = $_POST[$rf];
						$sql .= $comma.$rf.(($type == INSERT)?NULL:"='$tmp'");
						$sqlVals .= $comma."'$tmp'";
					}
					$comma = ",";
				}
			}
			
			// Optional Fields
			if($this->opt_fields !== NULL)
			{
				foreach($this->opt_fields as $of)
				{
					if(!is_null($this->func_fields) && array_key_exists($of, $this->func_fields))
					{
						$sql .= $comma.$of.($type == INSERT ? NULL : "=".$this->func_fields[$of]);
						$sqlVals .= $comma.$this->func_fields[$of];
						$comma = ",";
					}
					else
					{
						if(isset($_POST[$of]) && ! empty($_POST[$of]))
						{
							$sql .= $comma.$of.($type == INSERT ? NULL : "='".$_POST[$of]."'");
							$sqlVals .= "{$comma}'".$_POST[$of]."'";
							$comma = ",";
						}
						elseif($type == UPDATE)
						{
							$sql .= $comma.$of."=DEFAULT($of)";
							$comma = ",";
						}
					}
				}
			}
			
			// At Insert Fields (Function or POST value)
			if($type == INSERT && $this->insert_fields !== NULL)
			{
				foreach($this->insert_fields as $if=>$ftype)
				{
					$sql .= $comma.$if;
					$sqlVals .= $comma;
					
					// Use $_POST Value
					if($ftype == "POST")
					{
						$tmp = $_POST[$if];
						$sqlVals .= "'".$tmp."'";
					}
					else // Use MySQL Aggregate Function
						$sqlVals .= $ftype;
					
					$comma = ",";
				}
			}
			
			$this->sql = $sql.(($type==INSERT)?$sqlVals.")":" WHERE id=$this->id");
		}
		
		
		/*****************************************************************************************************************************
		* Cycle through joins array and build JOIN SQL statements.
		* 
		* 
		* 
		*****************************************************************************************************************************/
		protected function buildJoins()
		{
			$sql = NULL;
			if(! is_null($this->joins))
				foreach($this->joins as $join) $sql .= " $join";

			return $sql;
		}



		/*****************************************************************************************************************************
		* Cycles through the $req_fields array to determine if required data for an insert or update SQL
		* statement has been provided. $errors array contains fields missing required data, $fields array
		* contains provided data to be passed back to the form if errors exists. If $noDuplicates is set,
		* a call to checkDuplicates is triggered to avoid redundant entries.
		*****************************************************************************************************************************/
		protected function validate($type, &$fields=NULL )
		{
			if($this->req_fields !== NULL)
			{
				foreach($this->req_fields as $rf)
				{
					if($this->func_fields !== NULL && array_key_exists($rf, $this->func_fields))
						continue;
					else
					{
						$tmp = $_POST[$rf];
						if(! is_null($fields))
							$fields[$rf] = stripslashes($_POST[$rf]);
					
						if((strlen($tmp) == 0) || (is_numeric($tmp) && $tmp == 0))
							$this->errors[] = $rf;
					}
				}
			}
			
			if(count($this->errors) == 0)
			{
				if($this->noDuplicates !== NULL && ! $this->id)
					$this->checkDuplicates($fields);
				else
				{
					$this->errors = NULL;
					$fields = NULL;
				}
			}
			else
			{				
				if(! is_null($fields) && ! is_null($this->opt_fields))
				{
					foreach($this->opt_fields as $of)
						$fields[$of] = stripslashes(trim($_POST[$of]));
				}
			}
		}
	

		/*****************************************************************************************************************************
		* Cycles through the $duplicates array to determine if an entry with the provided data already
		* exists in the database. If one is found, an error is set, the id of the existing item is
		* returned as the error code and the database commit is exited.
		* 
		*****************************************************************************************************************************/
		private function checkDuplicates(&$fields)
		{
            $tmp = $this->data;
            $and = NULL;
            $this->sql = "SELECT count(id) as dups FROM ".$this->table." WHERE ";
			
            foreach($this->noDuplicates as $nd)
			{
                $this->sql .= $and."$nd='".$_POST[$nd]."'";
                $and = " AND ";
            }
			
            if($this->id > 0)
                $this->sql .= $and."id<>".$this->id;

            $this->execSql("Checking $this->obj_type Duplicates", SELECT_SINGLE);
            
			if($this->data['dups'] > 0)
			{
                //foreach($this->noDuplicates as $nd)
                    $this->errors[] = 'Duplicate record';
				
                if(! is_null($fields) && ! is_null($this->opt_fields))
				{
                    foreach($this->opt_fields as $of)
                        $fields[$of] = stripslashes($_POST[$of]);
                }
            }
            else
			{
                $this->errors = NULL;
                $fields = NULL;
            }

            $this->data = $tmp;
		}
		
		
		/*****************************************************************************************************************************
		* Entry function to build the SQL statement and commit to DB
		* 
		* 
		* 
		*****************************************************************************************************************************/
		public function save()
		{
			$save_type = (($this->id > 0)?UPDATE:INSERT);
			$this->errors = array();
			$this->validate($save_type);
			
			if(is_null($this->errors))
			{
				$this->buildCommitSql($save_type);

				$this->execSql("Saving $this->obj_type", $save_type);
			}
		}
		
		
		/*****************************************************************************************************************************
		* Basic delete function to remove object record from DB
		* 
		* 
		* 
		*****************************************************************************************************************************/	
		public function delete()
		{
			if($this->id > 0)
			{
				$this->sql = "DELETE FROM $this->table WHERE id=$this->id";
				$this->execSql("Deleting $this->obj_type",DELETE);
			}
		}



		/*****************************************************************************************************************************
		* Load Object data from DB, using id
		* 
		* 
		* 
		*****************************************************************************************************************************/
		public function load()
		{
			$this->sql = "SELECT ";
			$comma = NULL;
			
			foreach($this->load_fields as $lf)
			{
				$this->sql .= $comma.$lf;
				$comma = ",";
			}
			
			$this->sql .= " FROM $this->table ".$this->buildJoins()." WHERE $this->table.id=$this->id";

			$this->execSql("Loading $this->obj_type", SELECT_SINGLE);
		}
		


		/*****************************************************************************************************************************
		* Retrieve list of records based on object's list array
		* 
		* 
		* 
		*****************************************************************************************************************************/
		public function getList($order, $where=NULL, $nextPage=NULL)
		{
			$sql = "SELECT ";
			foreach($this->list_fields as $lf) $sql .= $lf.",";
			
			$sql = rtrim($sql, ",");
			$this->sql = " FROM $this->table".$this->buildJoins();

			if(! is_null($where)) $this->sql .= " WHERE $where";
			
			if(is_null($nextPage) && ! is_null($this->max_per_page))
			{
				$sql .= $this->sql;
				$this->sql = "SELECT COUNT({$this->table}.id)".$this->sql;
				$this->execSql("Setting $this->obj_type Page Count", ROW_COUNT);
				$this->sql = $sql;
			}
			else
				$this->sql = $sql.$this->sql;
			
			$this->sql .= " ORDER BY ".$order;
			
			if(! is_null($this->max_per_page))
				$this->sql .= " LIMIT ".((is_null($nextPage))?'':($nextPage * $this->max_per_page).",").$this->max_per_page;
			
			$this->execSql("Creating $this->obj_type List", SELECT_MULTI);
			return $this->sql;
		}



		/*****************************************************************************************************************************
		* Executes the SQL statement.
		* 
		* 
		* 
		*****************************************************************************************************************************/
		protected function execSql($src, $type)
		{
			$db = DBManager::getConnection();
			if($result = $db->query($this->sql))
			{
				switch($type)
				{
					case SELECT_SINGLE:
					case SELECT_MULTI:
						$this->cleanOutput($result, $type);
						break;
					case SELECT_MULTI_SINGLE_COL:
						if($result->num_rows)
						{
							$this->data = array();
							while($row = $result->fetch_assoc())
								$this->data[] = stripslashes($row['col']);
						}
						else
							$this->data = NULL;
						break;
					case ROW_COUNT:
						$row = $result->fetch_row();
						$this->record_count = $row[0];
						if(is_null($this->max_per_page))
							$this->pages = 1;
						else
							$this->pages = ceil($row[0]/$this->max_per_page);
						break;
					case INSERT:
						$this->id = $db->insert_id;
						return $this->id;
						break;
					case UPDATE:
						return TRUE;
						break;
				}
				if($type == SELECT_SINGLE || $type == SELECT_MULTI || $type == SELECT_MULTI_SINGLE_COL || $type == ROW_COUNT)
					$result->free();
			}
			else
			{
				if(DEBUG_SQL)
				{
					echo "<br>Error $src:<br/>(".$db->errno.") ".$db->error."<br>$this->sql<br/><br/>";
					exit;
				}
				else
					echo "<br>An error has occurred while accessing the database, please contact technical support<br/>";
				$this->data = NULL;
				return FALSE;
			}
		}
		
	

		/*****************************************************************************************************************************
		* Cycles through the data retrieved from the database and preparing it for display to the user.
		* 
		* 
		* 
		*****************************************************************************************************************************/
		private function cleanOutput(&$result, $type)
		{
			$this->data = NULL;
			
			if($result->num_rows > 0)
			{
				if($type == SELECT_SINGLE)
				{
					$row = $result->fetch_assoc();
					foreach($row as &$item)	$item = stripslashes($item);
					
					$this->data = $row;
				}
				else
				{
					$this->data = array();
					while($row = $result->fetch_assoc())
					{
						foreach($row as &$item) $item = stripslashes($item);
						$this->data[] = $row;
					}
				}
			}
		}



		/*****************************************************************************************************************************
		* Cycles through xajax supplied form data and converts to POST for use by all DB functions.
		* 
		* 
		* 
		*****************************************************************************************************************************/
		public function xajax2Post($arg)
		{
			unset($_POST);
			$db = DBManager::getConnection();
			
			foreach($arg as $key=>$val)
			{
				if(! is_array($val)) $val = $db->real_escape_string(trim($val));
				$_POST[$key] = $val;
			}
		}



		/*****************************************************************************************************************************
		* Scrub/Secure POST for use by all DB functions.
		* 
		* 
		* 
		*****************************************************************************************************************************/
		public function scrubPost()
		{
			$db = DBManager::getConnection();
			foreach($_POST as &$val)
			{
				if(! is_array($val))
					$val = $db->real_escape_string(trim($val));
			}
		}



		/*****************************************************************************************************************************
		* Update the public website sitemap
		* 
		* 
		* 
		*****************************************************************************************************************************/
		public function updateSiteMap($_page = NULL)
		{
			if(file_exists(UPLOAD_PATH.$fname))
			{
				$page = ((is_null($_page))? $this->data['name']:$_page);
				$page = ($page == 'Home') ? '' : str_replace(' ','-', $this->data['name']);
				$d = new DOMDocument();
				$d->load(HOME_PATH."/sitemap.xml");
				
				foreach($d->getElementsByTagName('url') as $url)
				{
					$loc = $url->getElementsByTagName('loc');
					
					if($loc->item(0)->nodeValue == HOME_URL."/".$page)
					{
						$lastMod = $url->getElementsByTagName('lastmod');
						$lastMod->item(0)->nodeValue = date('c');
						$d->save(HOME_PATH."/sitemap.xml");
						return 1;
					}
					else
						continue;
				}
			}
		}


		/*****************************************************************************************************************************
		* Create URL Friendly Strings
		* 
		* 
		* 
		*****************************************************************************************************************************/
		protected function createURL($pre_title)
		{
			$symbol_swap = array('symbols' => array('%', '&', '&amp;'), 'words' => array(' percent ', 'and', 'and'));
		 	$post_title = str_replace($symbol_swap['symbols'], $symbol_swap['words'], stripslashes($pre_title));
		 	$post_title = preg_replace("/[^A-Za-z0-9 ]/", '', $post_title);
		 	$post_title = strtolower(preg_replace('/[\s-]+/','-', $post_title));
			return $post_title;
		}
		

		/*****************************************************************************************************************************
		* Update Display Order of record in table
		* 
		* 
		* 
		*****************************************************************************************************************************/
		public function updateDisplayOrder($id, $d_order)
		{
			$this->sql = "UPDATE $this->table SET display_order=$d_order WHERE id=$id";
			$this->execSql("Updating {$this->table} Display Order", UPDATE);
		}



		/*****************************************************************************************************************************
		* Obtain the next Display Order value based on current number of items in table
		* 
		* 
		* 
		*****************************************************************************************************************************/
		protected function getDisplayOrder()
		{
			$this->sql = "SELECT display_order AS high_val FROM $this->table ORDER BY display_order DESC LIMIT 1";
			$this->execSql("Setting new {$this->obj_type} display order", SELECT_SINGLE);
			$_POST['display_order'] = $this->data['high_val'] + 1;
		}



		/*****************************************************************************************************************************
		* Step one in obtaining a list of random items the fastest
		* 
		* 
		* 
		*****************************************************************************************************************************/
		public function getRandomSeed()
		{
			$this->sql = "SELECT FLOOR(RAND() * COUNT(*)) AS offset FROM {$this->table}";
			$this->execSql("Seeding Random Select", SELECT_SINGLE);
			return $this->data['offset'];
		}
		
		
		
		/*****************************************************************************************************************************
		* Geocode location
		*
		*
		*
		*****************************************************************************************************************************/
		public function geocode($address)
		{
			$rtn = NULL;
			$addr = urlencode($address);
			$geo = new SimpleXMLElement(file_get_contents("http://maps.googleapis.com/maps/api/geocode/xml?address=".$addr."&sensor=false"));
			$lat = $geo->result->geometry->location->lat;
			
			if(! empty($lat))
				$rtn = array('lat' => $lat, 'lng' => $geo->result->geometry->location->lng);
			
			return $rtn;
		}

		
		/*****************************************************************************************************************************
		* Generate random password
		*
		*
		*
		*****************************************************************************************************************************/
		public function randomPassword()
		{
			$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789+=[]@#$";
			$passwd = "";

			for ($i = 0; $i < 8; $i++)
				$passwd .= $alphabet[rand(0, 66)];

			return $passwd;
		}
		
		/*****************************************************************************************************************************
		* Convert Time Stamps to Project Time Zone
		* 
		* 
		* 
		*****************************************************************************************************************************/
		protected function convertToTimeZone(&$ts, $format)
		{
			$tz = new DateTimeZone(TIMEZONE);
			$nt = new DateTime($ts);
			$nt->setTimeZone($tz);
			$ts = $nt->format($format);
		}
		

		/*****************************************************************************************************************************
		* Session getters and setters
		* 
		* 
		* 
		*****************************************************************************************************************************/
		public function setSessionValue($pri, $value, $sec=null)
		{
			if($sec === NULL)
				$_SESSION[ADMIN_SITE][$pri] = $value;
			else
				$_SESSION[ADMIN_SITE][$pri][$sec] = $value;
		}
	
		public function getSessionValue($pri, $sec=null)
		{
			if($sec === NULL)
				return $_SESSION[ADMIN_SITE][$pri];
			else
				return $_SESSION[ADMIN_SITE][$pri][$sec];
		}
	
		public function unsetSessionValue($pri, $sec=null)
		{
			if($sec === NULL)
				unset($_SESSION[ADMIN_SITE][$pri]);
			else
				unset($_SESSION[ADMIN_SITE][$pri][$sec]);		
		}
	}
?>