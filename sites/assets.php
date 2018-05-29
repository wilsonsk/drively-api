<?php
	require_once(dirname(__DIR__).'/modules/tasks/Task.class.php');
	require_once(dirname(__DIR__).'/modules/distributors/Distributor.class.php');
	require_once('Note.class.php');
	require_once('Contact.class.php');

	$myxa = new xajax();
	$myxa->configure('javascript URI', ADMIN_URL."/");
	$myxa->registerfunction('saveContact');
	$myxa->registerfunction('loadAsset');
	$myxa->registerfunction('loadContact');
	$myxa->registerfunction('remove');
	$myxa->registerfunction('saveNote');
	$myxa->registerfunction('quickView');
	$myxa->registerfunction('closeTask');
	$myxa->registerfunction('saveTask');
	$myxa->registerfunction('save');
	$myxa->registerfunction('addAsset');
	$myxa->registerfunction('saveContact');
	$myxa->registerfunction('paginate');
	$myxa->registerfunction('migrateLeadToPractice');
	$myxa->registerfunction('qvPO');
	$myxa->registerfunction('download');
	$myxa->configure('debug', XAJAX_DEBUG);
	// $myxa->configure('debug', TRUE);
 	$myxa->processRequest();

	function getNewType($id, $type, &$smarty=NULL)
	{
		switch($type){
			case "practice":
					if($smarty){
					$smarty->assign('asset_title', "Practices");
					$smarty->assign('asset_type', "Practice");
					$smarty->assign('asset', "practices");
				}
				return new Practice($id);
				break;
			case "lead":
				if($smarty){
					$smarty->assign('asset_title', "Leads");
					$smarty->assign('asset_type', "Lead");
					$smarty->assign('asset', "lead");
				}
				return new Lead($id);
				break;
			case "distributor":
				if($smarty){
					$smarty->assign('asset_title', "Distributors");
					$smarty->assign('asset_type', "Distributor");
					$smarty->assign('asset', "distributor");
				}
				return new Distributor($id);
				break;
			case "distributor-rep":
				if($smarty){
					$smarty->assign('asset_title', "Distributor-Reps");
					$smarty->assign('asset_type', "Distributor-Rep");
					$smarty->assign('asset', "distributor-Reps");
				}
				return new DistributorRep($id);
				break;
			default:
				break;
		}
	}	

	/*****************************************************************************************************************************
	* Paginate through accounts
	*
	*
	*
	*****************************************************************************************************************************/
    function paginate($page, $filter, $search=NULL)
    {
      	$objResp = new xajaxResponse();

      	if(checkAdminSession($objResp))
		{
        	refreshList($objResp, $page, $filter, $search);
			$objResp->call("setALT");
		}

      return $objResp;
    }

	/*****************************************************************************************************************************
	* Add new item to practices/leads/distributors/distributor-reps
	*
	*
	*
	*****************************************************************************************************************************/
	function addAsset($type)
	{
		$objResp = new xajaxResponse();

		if(checkAdminSession($objResp))
		{
			$smarty = new MySmarty();
			if($type != "distributor")
			{
				require_once(ADMIN_PATH.'/distributors/Distributor.class.php');
				$distributor = new Distributor();
				$distributor->listDistributors();
				$smarty->assign('distributors', $distributor->data);
			}
			
			$objResp->assign("add-asset", "innerHTML", $smarty->fetch("{$type}-details.tpl"));
			$objResp->call("saveDetails");
			$objResp->call("slide", 4);
		}
		return $objResp;
	}

	/*****************************************************************************************************************************
	* Load asset details
	*
	*
	*
	*****************************************************************************************************************************/
	function loadAsset($id, $type)
	{
		$objResp = new xajaxResponse();

		if(checkAdminSession($objResp))
		{
			$smarty = new MySmarty();
			$asset = getNewType($id, $type, $smarty);

			if($asset->data !== NULL)
			{
				if($type != "distributor-rep")
				{
					$contacts = new Contact();
					$contacts->listContacts($type, $id);
				}

				$task = new Task();
				$task->listTasks($type, $id);

				$note = new Note();
				$note->listNotes($id, $type);

				if($type == "distributor" || $type == "practice")
				{
					require_once(ADMIN_PATH.'/purchase-orders/PurchaseOrder.class.php');
					$purchaseOrder = new PurchaseOrder();
					$purchaseOrder->paginate(1, NULL, NULL, " AND ref_fk={$id} AND ref_table='{$type}' AND status='i'");

					$smarty->assign("set", $purchaseOrder->data);
					$objResp->assign("purchase_orders", "innerHTML", $smarty->fetch(ADMIN_PATH.'/templates/purchaseOrders.tpl'));
				}

				if($type != "distributor")
				{
					require_once(ADMIN_PATH.'/distributors/Distributor.class.php');
					$distributor = new Distributor();
					$distributor->listDistributors();
					$smarty->assign('distributors', $distributor->data);
				}

				$smarty->assign("asset", $asset->data);
				$smarty->assign("contacts", $contacts->data);
				$smarty->assign('notes', $note->data);
				$smarty->assign('tasks', $task->data);
				$smarty->assign('sel_state', $asset->data['state']);

				$objResp->assign("{$type}s-tab", 'innerHTML', $smarty->fetch("{$type}-details.tpl"));
				$objResp->assign('contact-list', 'innerHTML', $smarty->fetch(ADMIN_PATH.'/templates/contacts.tpl'));
				$objResp->call("fillNotesTasks", ".asset-task-list", $smarty->fetch(ADMIN_PATH.'/templates/qvTasks.tpl'));
				$objResp->call("fillNotesTasks", ".asset-note-list", $smarty->fetch(ADMIN_PATH.'/templates/qvNotes.tpl'));

				$objResp->call("saveDetails");
				$objResp->call("slide", 1);
			}
			else
				$objResp->call("showFormMsg", "alert-danger", "Unable to load {$type} details.\n".print_r($asset->errors, TRUE));
		}
		return $objResp;
	}

	/*****************************************************************************************************************************
	* Load contact info for edit
	*
	*
	*
	*****************************************************************************************************************************/
	function loadContact($id, $type)
	{
		$objResp = new xajaxResponse();

		if(checkAdminSession($objResp))
		{
			$contact = new Contact($id);

			if($contact->data !== NULL)
			{
				$smarty = new MySmarty();
				$smarty->assign("contact", $contact->data);

				$objResp->assign("contact-edit", "innerHTML", $smarty->fetch(ADMIN_PATH.'/templates/contact-details.tpl'));
				$objResp->call("loadContact", json_encode($contact->data));
			}
			else
				$objResp->call("showFormMsg", "alert-danger", "Unable to load contact details.<br/>".print_r($contact->errors, TRUE));

			$objResp->call("setALT");
		}
		return $objResp;
	}


	/*****************************************************************************************************************************
	* Delete practice from system
	*
	*
	*
	*****************************************************************************************************************************/
	function remove($id, $page, $fk, $filter, $search=NULL)
	{
		$objResp = new xajaxResponse();

		if(checkAdminSession($objResp))
		{
			$obj = NULL;
			$type = explode("-", $id);

			switch($type[0])
			{
				case 'practice':
					$obj = new Practice($type[1]);
					break;
				case 'location':
					$obj = new PracticeLocation($type[1]);
					break;
				case 'contact':
					$obj = new PracticeContact($type[1]);
					break;
			}

			$obj->delete();

			if($obj->errors === NULL)
			{
				switch($type[0])
				{
					case 'practice':
						refreshList($objResp, $page, $filter, $search);
						$objResp->call("showFormMsg", "alert-success", "Practice Record deleted from system.");
						break;
					case 'location':
						refreshLocationList($objResp, $page, $fk);
						$objResp->call("showFormMsg", "alert-success", "Location deleted from system.");
						break;
					case 'contact':
						refreshContactList($objResp, $page, $fk);
						$objResp->call("showFormMsg", "alert-success", "Contact deleted from system.");
						break;
				}
			}
			else
				$objResp->call("showFormMsg", "alert-danger", "Errors removing ".$type[0]." from the system.<br/>".print_r($obj->errors, TRUE));

			$objResp->call("setALT");
			$objResp->call("$.unblockUI");
		}

		return $objResp;
	}

	/*****************************************************************************************************************************
	* Save details of lead/practice/distributor/dist_rep
	*
	*
	*
	*****************************************************************************************************************************/
	function save($args)
	{
		$objResp = new xajaxResponse();

		if(checkAdminSession($objResp))
		{
			$asset = getNewType($args['id'], $args['type']);
			$asset->xajax2Post($args);
			$asset->save();

			if($asset->errors === NULL)
				$objResp->call("showFormMsg", "alert-success", "Details saved successfully.");
			else
				$objResp->call("showFormMsg", "alert-danger", "Error saving {$type} details:<br/>".print_r($asset->errors, TRUE));
		}

		$objResp->call("setALT");
		$objResp->call("$.unblockUI");
		return $objResp;
	}

	/*****************************************************************************************************************************
	* Save note
	*
	*
	*
	*****************************************************************************************************************************/
	function saveNote($args)
	{
		$objResp = new xajaxResponse();

		if(checkAdminSession($objResp))
		{
			$note = new Note();
			$note->xajax2Post($args);
			$note->save();

			if($note->errors === NULL){
				$note->listNotes($args['ref_fk'], $args['ref_table']);
				
				$smarty = new MySmarty();
				$smarty->assign('notes', $note->data);
				
				$objResp->call("fillNotesTasks", ".asset-note-list", $smarty->fetch(ADMIN_PATH.'/templates/qvNotes.tpl'));
				$objResp->call("showFormMsg", "alert-success", "Note succesfully saved.");
			}
			else
				$objResp->call("Error saving note:<br/>".print_r($note->errors, TRUE));
		}

		$objResp->call("setALT");
		$objResp->call("$.unblockUI");
		return $objResp;
	}

	/*****************************************************************************************************************************
	* Quick View of Practice Details
	*
	*
	*
	*****************************************************************************************************************************/
	function quickview($id, $type)
	{
		$objResp = new xajaxResponse();

		if(checkAdminSession($objResp))
		{
			$smarty = new MySmarty();

			$asset = getNewType($id, $type, $smarty);

			$task = new Task();
			$task->listTasks($type, $id);

			$note = new Note();
			$note->listNotes($id, $type);

			$contact = new Contact();
			$contact->listContacts($type, $id);

			$smarty->assign('notes', $note->data);
			$smarty->assign('tasks', $task->data);
			$smarty->assign('type', $asset->data);
			$smarty->assign('contacts', $contact->data);

			$objResp->assign('quickView', 'innerHTML', $smarty->fetch(ADMIN_PATH.'/templates/quickView.tpl'));
			$objResp->call("fillNotesTasks", ".asset-task-list", $smarty->fetch(ADMIN_PATH.'/templates/qvTasks.tpl'));
			$objResp->call("fillNotesTasks", ".asset-note-list", $smarty->fetch(ADMIN_PATH.'/templates/qvNotes.tpl'));
			$objResp->call('slide', 2);
		}
		return $objResp;
	}

	/*****************************************************************************************************************************
	* Close an open task
	*
	*
	*
	*****************************************************************************************************************************/
	function closeTask($task_id)
	{
		$objResp = new xajaxResponse();

		if(checkAdminSession($objResp))
		{
			$task = new Task($task_id);
			$task->closeTask($task_id);
			if($task->errors === NULL)
			{
				$objResp->script("$('#task-list-item-{$task_id}').addClass('closed-task');");
				$objResp->script("$('#task-{$task_id}-close-btn').hide();");
				$objResp->call("showFormMsg", "alert-success", "Task succesfully closed.");
			}
			else
				$objResp->call("showFormMsg", "alert-danger", "Error closing task:<br/>".print_r($task->errors, TRUE));
		}

		return $objResp;
	}

	/*****************************************************************************************************************************
	* Save new/update contact
	*
	*
	*
	*****************************************************************************************************************************/
	function saveContact($args)
	{
		$objResp = new xajaxResponse();

		if(checkAdminSession($objResp))
		{
			$contact = new Contact($args['id']);
			$contact->xajax2Post($args);
			$contact->save();

			if($contact->errors === NULL){
				$contact->listContacts("practice", $args['ref_fk']);

				$smarty = new MySmarty();
				$smarty->assign("contacts", $contact->data);

				$objResp->assign("contact-list", "innerHTML", $smarty->fetch(ADMIN_PATH.'/templates/contacts.tpl'));
				$objResp->call("showFormMsg", "alert-success", "Contact successfully saved.");
			}
			else
				$objResp->call("showFormMsg", "alert-danger", "Unable to save contact:<br/>".print_r($contact->errors, TRUE));
		}

		$objResp->call("$.unblockUI");
		return $objResp;
	}

	/*****************************************************************************************************************************
	* Save new task
	*
	*
	*
	*****************************************************************************************************************************/
	function saveTask($args)
	{
		$objResp = new xajaxResponse();

		if(checkAdminSession($objResp))
		{
			$task = new Task();
			$task->xajax2Post($args);
			$task->save();

			if($task->errors === NULL){
				$task = new Task();
				$task->listTasks($args['ref_table'], $args['ref_fk']);

				$smarty = new MySmarty();
				$smarty->assign('tasks', $task->data);

				$objResp->call("fillNotesTasks", ".asset-task-list", $smarty->fetch(ADMIN_PATH.'/templates/qvTasks.tpl'));
				$objResp->call("showFormMsg", "alert-success", "Task successfully saved.");
			}
			else
				$objResp->call("showFormMsg", "alert-danger", "Unable to save task:<br/>".print_r($task->errors, TRUE));
		}

		$objResp->call("$.unblockUI");
		return $objResp;
	}

	/*****************************************************************************************************************************
	* QV Purchase Order 
	*
	*
	*
	*****************************************************************************************************************************/
	function qvPO($id)
	{
		$objResp = new xajaxResponse();
		if(checkAdminSession($objResp))
		{
			$smarty = new MySmarty();
			require_once(ADMIN_PATH.'/purchase-orders/PurchaseOrder.class.php');
			$po_products = new PurchaseOrder($id);
			if($po_products->data['ref_table'] == 'practice')
			{
				require_once('practices/Practice.class.php');
				$practice = new Practice($po_products->data['ref_fk']);
				$po_products->data['name'] = $practice->data['name'];
				$smarty->assign("ref_table", "Purchase Receipt");
			}
			else
			{
				require_once(dirname(__DIR__).'/sites/_admin/distributors/Distributor.class.php');
				$distributor = new Distributor($po_products->data['ref_fk']);
				$po_products->data['name'] = $distributor->data['company_name'];
				$smarty->assign("ref_table", "Purchase Invoice");
			}

			$smarty->assign("po", $po_products->data);

			$po_products->getItems();
			$smarty->assign("lineItems", $po_products->data);

			$objResp->assign("purchase_order-details", "innerHTML", $smarty->fetch(ADMIN_PATH.'/templates/po-detail.tpl'));
			$objResp->call("slide", 6);
		}
		return $objResp;
	}

	/*****************************************************************************************************************************
	* Download purchase-order PDF to user
	*
	*
	*
	*****************************************************************************************************************************/
	function download($id)
	{
		$objResp = new xajaxResponse();
		if(checkAdminSession($objResp))
		{
			$fileName = generateInvoice($id, $objResp);
			$objResp->call("downloadFile", $fileName, __DIR__);
		}
		return $objResp;
	}

	/*****************************************************************************************************************************
	* Generate PDF for download
	*
	*
	*
	*****************************************************************************************************************************/
	function generateInvoice($id, &$objResp)
	{
		$objResp = new xajaxResponse();
		if(checkAdminSession($objResp))
		{
			require_once(ADMIN_PATH.'/purchase-orders/PurchaseOrder.class.php');
			$purchase = new PurchaseOrder($id);
			$purchaseOrder = $purchase->data;

			$smarty = new MySmarty();
			if($purchaseOrder['ref_table'] == 'practice')
			{
				require_once(ADMIN_PATH.'/practices/Practice.class.php');
				$practice = new Practice($purchaseOrder['ref_fk']);
				$purchaseOrder['name'] = $practice->data['name'];
				$smarty->assign("ref_table", "Purchase Receipt");
			}
			else
			{
				require_once(dirname(__DIR__).'/sites/_admin/distributors/Distributor.class.php');
				$distributor = new Distributor($purchaseOrder['ref_fk']);
				$purchaseOrder['name'] = $distributor->data['company_name'];
				$smarty->assign("ref_table", "Purchase Invoice");
			}
			$purchase->getItems();
			
			if($purchase->errors === NULL){
				$smarty->assign("po", $purchaseOrder);
				$smarty->assign("lineItems", $purchase->data);
				$smarty->assign("url", str_replace('https:', 'http:', ADMIN_URL));

				if(! file_exists(ADMIN_PATH."/purchase-orders/temp"))
					mkdir(ADMIN_PATH."/purchase-orders/temp", 0775, true);

				session_regenerate_id();

				$files = scandir(ADMIN_PATH."/purchase-orders/temp/");
				foreach($files as $file){
					if(time() - filemtime($file) > 1500)
						unlink(ADMIN_PATH."/purchase-orders/temp/".$file);
				}
				$fh = fopen(ADMIN_PATH."/purchase-orders/temp/".session_id().".html", "w");
				fwrite($fh, $smarty->fetch(ADMIN_PATH."/purchase-orders/templates/generatedInvoice.html"));
				fclose($fh);

				exec("/usr/local/bin/wkhtmltopdf -B 3 -L 3 -R 3 -T 3 --no-pdf-compression ".ADMIN_PATH."/purchase-orders/temp/".session_id().".html ".ADMIN_PATH."/purchase-orders/temp/".session_id());
				
				$file = "PurchaseOrder-".$purchaseOrder['purchase_order_number'].".pdf";

				return $file;
				//send email
				//require_once(dirname(dirname(__DIR__)).'/common/required/KanaiTekMailer.class.php');
				//$mail = new KanaiTekMailer($purchaseOrder['name'], 'susan@kanaitek.com');
				//$mail->sendDocumentViaEmail($file, __DIR__.'/temp/'.$file);
			}
			else
				$objResp->call("showFormMsg", "alert-danger", "Error generating purchase-order:\n".print_r($purchase->errors));
			$objResp->call('setALT');
			$objResp->call('$.unblockUI');
		}

		return $objResp;
	}