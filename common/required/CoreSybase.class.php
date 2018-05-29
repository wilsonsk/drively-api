<?php
	//require_once("DBManager.class.php");
	
	class CoreSybase{
				
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
		Public $sql;				// SQL Statement to be built and excuted
		public $errors;				// Store errors discovered before executing a save to the system
		public $pages;				// Total pages for listing operations
		public $record_count;		// Total records for a list retrieval
		public $id;					// The ID of this object
		public $data;				// Storage mechanism for SELECTS
			
		/*
		 *	Cycles through the $req_fields and $opt_fields arrays to create either an update or insert SQL statement
		 *	based on the value of $type: INSERT|UPDATE. Calls to this function from objects should be made after
		 *	successful pass of data to validate function.
		 */
		protected function buildCommitSql($type){
			$sql = "INSERT INTO $this->table(";
			$sqlVals = ") VALUES(";
			if($type == UPDATE)
				$sql = "UPDATE $this->table SET ";
			$tmp = NULL;
			$comma = NULL;
			// Required Fields
			foreach($this->req_fields as $rf){				
				if(!is_null($this->func_fields) && array_key_exists($rf, $this->func_fields)){
					$sql .= $comma.$rf.(($type == INSERT)?NULL:"=".$this->func_fields[$rf]);
					$sqlVals .= $comma.$this->func_fields[$rf];
				}
				else{
					//$tmp = str_replace($this->replaceHTML, $this->replaceHTMLWith, $_POST[$rf]);
					$tmp = $_POST[$rf];
					$sql .= $comma.$rf.(($type == INSERT)?NULL:"='$tmp'");
					$sqlVals .= $comma."'$tmp'";
				}
				$comma = ",";
			}
			// Optional Fields
			if(! is_null($this->opt_fields)){
				foreach($this->opt_fields as $of){
					if(!is_null($this->func_fields) && array_key_exists($of, $this->func_fields)){
						$sql .= ",".$of.(($type == INSERT)?NULL:"=".$this->func_fields[$of]);
						$sqlVals .= ",".$this->func_fields[$of];
					}
					else{
						$tmp = $_POST[$of];
						if(! empty($tmp)){
							$sql .= ",".$of.(($type==1)?NULL:"='$tmp'");
							$sqlVals .= ",'$tmp'";
						}
						elseif($type == UPDATE)
							$sql .= ",".$of."=DEFAULT($of)";
					}
				}
			}
			// At Insert Fields (Function or POST value)
			if($type == INSERT){
				if(! is_null($this->insert_fields)){
					foreach($this->insert_fields as $if=>$ftype){
						$sql .= $comma.$if;
						$sqlVals .= $comma;
						if($ftype == "POST"){ //Post Value
							//$tmp = str_replace($this->replaceHTML, $this->replaceHTMLWith, $_POST[$if]);
							$tmp = $_POST[$if];
							$sqlVals .= "'".$tmp."'";
						}
						else // Function
							$sqlVals .= $ftype;
					}
				}
			}
			$this->sql = $sql.(($type==INSERT)?$sqlVals.")":" WHERE id=$this->id");
		}
	
		/*
		 *	Cycles through the $req_fields array to determine if required data for an insert or update SQL
		 *	statement has been provided. $errors array contains fields missing required data, $fields array
		 *	contains provided data to be passed back to the form if errors exists. If $noDuplicates is set,
		 *	a call to checkDuplicates is triggered to avoid redundant entries.
		 */
		protected function validate($type, &$fields=NULL ){
			foreach($this->req_fields as $rf){
				if(!is_null($this->func_fields) && array_key_exists($rf, $this->func_fields))
					continue;
				else{
					$tmp = $_POST[$rf];
					if(! is_null($fields))
						$fields[$rf] = stripslashes($_POST[$rf]);
					
					if((strlen($tmp) == 0) || (is_numeric($tmp) && $tmp == 0))
						$this->errors[$rf] = 1;
				}
			}
			if(count($this->errors) == 0){
				if(! is_null($this->noDuplicates))
					$this->checkDuplicates($fields);
				else{
					$this->errors = NULL;
					$fields = NULL;
				}
			}
			else{				
				if(! is_null($fields) && ! is_null($this->opt_fields)){
					foreach($this->opt_fields as $of)
						$fields[$of] = stripslashes(trim($_POST[$of]));
				}
			}
		}
	
		/*
		 *	Cycles through the $duplicates array to determine if an entry with the provided data already
		 *	exists in the database. If one is found, an error is set, the id of the existing item is
		 *	returned as the error code and the database commit is exited.
		 */
		private function checkDuplicates(&$fields){
            $tmp = $this->data;
            $and = NULL;
            $this->sql = "SELECT count(id) as dups FROM ".$this->table." WHERE ";
            foreach($this->noDuplicates as $nd){
                $this->sql .= $and."$nd='".$_POST[$nd]."'";
                $and = " AND ";
            }
            if($this->id > 0){
                $this->sql .= $and."id<>".$this->id;
            }
            $this->execSql("Checking $this->obj_type Duplicates", SELECT_SINGLE);
            if($this->data['dups'] > 0){
                foreach($this->noDuplicates as $nd)
                    $this->errors[$nd] = 'duplicate';
                if(! is_null($fields) && ! is_null($this->opt_fields)){
                    foreach($this->opt_fields as $of)
                        $fields[$of] = stripslashes($_POST[$of]);
                }
            }
            else{
                $this->errors = NULL;
                $fields = NULL;
            }
            $this->data = $tmp;
		}
		
		public function save(){
			$save_type = (($_POST['id'] > 0)?UPDATE:INSERT);
			$this->errors = array();
			$this->validate($save_type);
			if(is_null($this->errors)){
				$this->buildCommitSql($save_type);
				$this->execSql("Saving $this->obj_type", $save_type);
			}
		}
		
		public function actionResponse(&$objResp, $func, $resetText=null){
			$class = "indicator_success";
			$resetText = "Saving...";
			$errors = count($this->errors) > 0;
			$msg = $this->obj_type;
			switch($func){
				case INSERT:
					if($errors)
						$msg = "Error(s) Saving to";
					else{
						$msg .=" Saved to";
						//$objResp->assign('pageTitle', 'innerHTML', "Manage {$this->obj_type}");
						if(isset($this->id_field))
							$objResp->call("$('#".$this->id_field."').val", $this->id);
					}
					break;
				case UPDATE:
					if($errors)
						$msg = "Error(s) Updating to";
					else
						$msg .= " Updated in";
					break;
				case DELETE:
					$reset_text = "Processing...";
					if($errors)
						$msg = "Error(s) Deleting from";
					else{
						$msg .= " Deleted from";
						//$objResp->assign('pageTitle', 'innerHTML', "Add {$this->obj_type}");
					}
					
			}
			$msg .= " the System";
			if(count($this->errors) > 0){
				$class = "indicator_error";
				$objResp->call("$('#indicator_close').css", "display", "inline");			
				if(in_array('duplicate', $this->errors))
					$msg .= ': Duplicate Entry';
				else{
					if($func == INSERT || $func == UPDATE){
						$msg .= ":<br/>Missing Required Data:<ul style='position:relative;left:15px;'>";
						foreach($this->errors as $key=>$val){
							if($val != 'duplicate')
								$msg .= "<li>".$key."</li>";
						}
						$msg .= "</ul>";
					}
				}
				if(XAJAX_DEBUG)
					print_r($this->errors, true);
			}
			/*
                $objResp->call("$('#indicator_msg').removeClass().addClass", $class);
                $objResp->call("$('#indicator_text').html", $msg);
                if($class == "indicator_error")
                    $objResp->call("$('#indicator_close').css", "display", "inline");
                else
                    $objResp->call("closeIndicator", 1500);
			*/
		}
	
		public function delete(){
			if($this->id > 0){
				$this->sql = "DELETE FROM $this->table WHERE id=$this->id";
				$this->execSql("Deleting $this->obj_type",DELETE);
			}
		}
	
		/*
		 *	Cycle through joins array and build JOIN SQL statements.
		 */
		protected function buildJoins(){
			$sql = NULL;
			if(! is_null($this->joins)){
				foreach($this->joins as $join){
					$sql .= " $join";
				}
			}
			return $sql;
		}
	
		/*
		 *	An item from the list view has been selected, load data for management control.
		 */
		public function load($where=null){
			$this->sql = "SELECT ";
			$comma = NULL;
			foreach($this->load_fields as $lf){
				$this->sql .= $comma.$lf;
				$comma = ",";
			}
			$this->sql .= " FROM $this->table ".$this->buildJoins()." WHERE $this->table.id=$this->id";
			if(! is_null($where)){
				$this->sql .= " AND {$where}";
			}
			$this->execSql("Loading $this->obj_type", SELECT_SINGLE);
		}
	
		/*
		 *	Retrieves a data set.
		 *	Order of list, load conditions, get an indexed page
		 */
		public function getList($order, $where=NULL, $nextPage=NULL){
			$sql = "SELECT ";
			foreach($this->list_fields as $lf){
				$sql .= $lf.",";
			}
			$sql = rtrim($sql, ",");
			$this->sql = " FROM $this->table".$this->buildJoins();
			//echo $this->sql;
			if(! is_null($where)){
				$this->sql .= " WHERE $where";
			}
			if(is_null($nextPage) && ! is_null($this->max_per_page)){
				$sql .= $this->sql;
				$this->sql = "SELECT COUNT({$this->table}.id)".$this->sql;
				//echo $this->sql;
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
		
		public function msg_handler($msgnumber, $severity, $state, $line, $text)
        {
            $this->errors = var_dump($msgnumber, $severity, $state, $line, $text);
        }
	
		/*
		*	Executes the SQL statement.
		*/
		protected function execSql($src, $type)
		{
			$this->errors = NULL;
			$db = sybase_connect(SYBASE_SERVER, SYBASE_USER, SYBASE_PASSWORD);
			sybase_select_db(SYBASE_DB, $db);
			sybase_set_message_handler(array($this, 'msg_handler'));
			if($result = sybase_query($this->sql, $db))
			{
				switch($type)
				{
					case SELECT_SINGLE:
					case SELECT_MULTI:
						$this->cleanOutput($result, $type);
						break;
					case SELECT_MULTI_SINGLE_COL:
						$this->data = array();
						while($row = sybase_fetch_assoc($result))
							$this->data[] = stripslashes($row['col']);
						break;
					case ROW_COUNT:
						$row = sybase_fetch_row($result);
						$this->record_count = $row[0];
						if(is_null($this->max_per_page))
							$this->pages = 1;
						else
							$this->pages = ceil($row[0]/$this->max_per_page);
						break;
					case INSERT:
						//$this->id = $db->insert_id;
						//return $this->id;
						//break;
					case UPDATE:
						return TRUE;
						break;
				}
				if($type == SELECT_SINGLE || $type == SELECT_MULTI || $type == SELECT_MULTI_SINGLE_COL || $type == ROW_COUNT)
					sybase_free_result($result);
			}
			else
			{
				if(DEBUG_SQL)
				{
					echo "<br>Error $src:<br/>$this->sql<br/><br/>";
					exit;
				}
				else
					echo "<br>An error has occurred while accessing the database, please contact technical support<br/>";
				$this->data = NULL;
				return FALSE;
			}
		}
	
		/*
		 *	Cycles through the data retrieved from the database and prepares it for display to the user.
		 */
		private function cleanOutput(&$result, $type){
			$this->data = NULL;
			if(sybase_num_rows($result) > 0){
				if($type == SELECT_SINGLE){
					$row = sybase_fetch_assoc($result);
					foreach($row as &$item)
						$item = stripslashes($item);
					$this->data = $row;
				}
				else{
					$this->data = array();
					while($row = sybase_fetch_assoc($result)){
						foreach($row as &$item)
							$item = stripslashes($item);
						$this->data[] = $row;
					}
				}
			}
		}
		
		public function escapeString($str)
		{
			if ( !isset($str) or empty($str) ) return '';
			if ( is_numeric($str) ) return $str;

			$non_displayables = array(
			    '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
			    '/%1[0-9a-f]/',             // url encoded 16-31
			    '/[\x00-\x08]/',            // 00-08
			    '/\x0b/',                   // 11
			    '/\x0c/',                   // 12
			    '/[\x0e-\x1f]/'             // 14-31
			);
			foreach ( $non_displayables as $regex )
			    $str = preg_replace( $regex, '', $str );
			$str = str_replace("'", "''", $str );
			return $str;
		}
	
		/*
		 *	Cycles through xajax supplied forms and converts to POST for use by all DB functions.
		 */
		public function xajax2Post($arg){
			unset($_POST);
			foreach($arg as $key=>$val){
				if(! is_array($val))
					$val = $this->escapeString(trim($val));
				$_POST[$key] = $val;
			}
		}
		
		/*
		 *	Scrub/Secure POST for use by all DB functions.
		 */
		public function scrubPost(){
			foreach($_POST as &$val){
				if(! is_array($val))
					$val = $this->escapeString(trim($val));
			}
		}

		/*
		 *  Create URL Friendly Titles
		 */
		protected function createURLTitle($pre_title){
			$symbol_swap = array('symbols' => array('%', '&', '&amp;'), 'words' => array(' percent ', 'and', 'and'));
		 	$post_title = str_replace($symbol_swap['symbols'], $symbol_swap['words'], stripslashes($pre_title));
		 	$post_title = preg_replace("/[^A-Za-z0-9 ]/", '', $post_title);
		 	$post_title = strtolower(preg_replace('/[\s-]+/','-', $post_title));
			return $post_title;
		}
		
		/*
		 *  Update Display Order for items in table
		 */
		public function updateDisplayOrder($id, $d_order){
			$this->sql = "UPDATE $this->table SET display_order=$d_order WHERE id=$id";
			$this->execSql("Updating {$this->table} Display Order", UPDATE);
		}
		


		/*
		 *  Session getters and setters
		 */
		public function setSessionValue($pri, $value, $sec=null){
			if(is_null($sec))
				$_SESSION[ADMIN_SITE][$pri] = $value;
			else
				$_SESSION[ADMIN_SITE][$pri][$sec] = $value;
		}
	
		public function getSessionValue($pri, $sec=null){
			if(is_null($sec))
				return $_SESSION[ADMIN_SITE][$pri];
			else
				return $_SESSION[ADMIN_SITE][$pri][$sec];
		}
	
		public function unsetSessionValue($pri, $sec=null){
			if(is_null($sec))
				unset($_SESSION[ADMIN_SITE][$pri]);
			else
				unset($_SESSION[ADMIN_SITE][$pri][$sec]);		
		}
		
		/*
		 *  Step one in obtaining a list of random items the fastest
		 */
		public function getRandomSeed(){
			$this->sql = "SELECT FLOOR(RAND() * COUNT(*)) AS offset FROM {$this->table}";
			$this->execSql("Seeding Random Select", SELECT_SINGLE);
			return $this->data['offset'];
		}
	}
?>