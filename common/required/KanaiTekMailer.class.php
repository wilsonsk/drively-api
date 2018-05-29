<?php
	require_once('sendgrid/sendgrid-php.php');
	
	class KanaiTekMailer{
		private $mail;
		private $subject;
		private $content;
		private $emailFrom;
		private $emailTo;
		private $sg;
		public $resp;
		
		public function __construct($to, $toName)
		{
			$this->sg = new \SendGrid(SENDGRID_API_KEY);
			$this->emailFrom = new SendGrid\Email(CONTACT_NOTIFY_NAME, CONTACT_NOTIFY_EMAIL);
			
			if(TESTING)
			{
				if(TEST_EMAIL === NULL)
					$this->emailTo = new SendGrid\Email($_SESSION[ADMIN_SITE]['uname'], $_SESSION[ADMIN_SITE]['email']);
				else
					$this->emailTo = new SendGrid\Email(TEST_EMAIL_NAME, TEST_EMAIL);
			}
			else
				$this->emailTo = new SendGrid\Email($toName, $to);
		}

		/*****************************************************************************************************************************
		* New Provider or User account has been created, send them their password.
		*
		*
		*
		*****************************************************************************************************************************/
		public function newAccount($name, $password)
		{
			$this->subject ="Sinsational Smile Portal Account";
			$body = "Hello {$name},\n\nAn account has been created for you on the Sinsational Smile Portal\n\n";
			$body .= "You can login at " . ADMIN_URL . " using your e-mail address as your login name and the password: " . $password;
			$body .= "\n\nThe temporary password is case sensitive.\nYou can change your password by logging into the Portal and clicking the 'My Account' link on the left.";

			$this->content = new SendGrid\Content("text/plain", $body);
			$this->mail = new SendGrid\Mail($this->emailFrom, $this->subject, $this->emailTo, $this->content);			
			$this->resp = $this->sg->client->mail()->send()->post($this->mail);
		}


		/*****************************************************************************************************************************
		* Send user their randomly generated password
		*
		*
		*
		*****************************************************************************************************************************/
		public function resetPassword($name, $password)
		{
			$this->subject ="Sinsational Smile Portal Password Reset";
			$body = "Hello {$name},\n\nThe password for your Sinsational Smile Portal account has been reset.\n\n";
			$body .= "You can login at " . ADMIN_URL . " using your e-mail address as your login name and the new password: " . $password;
			$body .= "\n\nThe temp-orary password is case sensitive.\nYou can change your password by logging into the Portal and clicking the 'My Account' link on the left.";

			$this->content = new SendGrid\Content("text/plain", $body);
			$this->mail = new SendGrid\Mail($this->emailFrom, $this->subject, $this->emailTo, $this->content);			
			$this->resp = $this->sg->client->mail()->send()->post($this->mail);
		}

		/*****************************************************************************************************************************
		* Console user forgot password notification
		*
		*
		*
		*****************************************************************************************************************************/
		public function forgotPassword($fname, $hash)
		{
			$this->subject = "Reset Your Sinsational Smile Website Portal Account Password";
			$body = "Hello ".$fname.",\n\n";
			$body .= "A temporary link has been created for you to reset your Sinsational Smile Website Portal password.\n\n".ADMIN_URL."?fp=".$hash;
			$body .= "\n\nThis link will expire within 30 minutes.\n\nIf you did not make this request, simply delete this e-mail and ";
			$body .= " your account will be unaffected.\n\nSincerely,\nSinsational Smile Care Team";
			
			$this->content = new SendGrid\Content("text/plain", $body);
			$this->mail = new SendGrid\Mail($this->emailFrom, $this->subject, $this->emailTo, $this->content);			
			$this->resp = $this->sg->client->mail()->send()->post($this->mail);
		}

		/*****************************************************************************************************************************
		* Lead received notification
		*
		*
		*
		*****************************************************************************************************************************/
		public function leadReceived($args)
		{
			$this->subject = "[Lead Received] Sinsational Smile Website Submission";
			$body = "SINSATIONAL SMILE LEAD RECEIVED\n";
			$body .= "===============================\n\n";
			$body .= $args['fName']." ".$args['lName']." submitted the following on ".date("F j, Y, g:i a")."\n\n";
			$body .= "Name: ".$args['fName']." ".$args['lName']."\n";
			$body .= "Email: ".$args['email']."\n";
			$body .= "Phone: ". $args['phone']."\n\n";
			$body .= "Comments: ". $args['comments']."\n\n";
			$body .= "Source: ". $args['source']."\n\n";
			$body .= "Sincerely, Sinsational Smile Care Team\n\n";

			$this->content = new SendGrid\Content("text/plain", $body);
			$this->mail = new SendGrid\Mail($this->emailFrom, $this->subject, $this->emailTo, $this->content);			
			$this->resp = $this->sg->client->mail()->send()->post($this->mail);

			$this->sendReceiptEmail($email, $name);
		}

		/*****************************************************************************************************************************
		* Email Sinsational Smile product registered email
		*
		*
		*
		*****************************************************************************************************************************/
		public function sendProductRegEmail($args)
		{
			$name = $args['fname']." ".$args['lname'];
			$this->subject = "A Sinsational Smile product has been registered";
			$body = "<table width='100%'>";
			$body .= "<tr>";
			$body .= "<th bgColor='#8f7a63' colspan='3'>";
			$body .= "<center><img src='http://www.sinsationalsmile.com/img/inquiry-header.png' width='100%'></center>";
			$body .= "</th>";
			$body .= "</tr>";
			$body .= "<tr>";
			$body .= "<td colspan='1' width='10%'>&nbsp;</td>";
			$body .= "<td colspan='1' padding-left='10%' padding-right='10%'>";
			$body .= "<center><h1>The following Sinsational Smile<sup><font size='2pt'>&copy;</font></sup> product has been registered:</h1></center>";
			$body .= "<hr>";
			$body .= "<h2>Contact Information</h2>";
			$body .= "<p>Name: ".$name."</p>";
			$body .= "<p>Office Email: ".$args['email']."</p>";
			$body .= "<p>Office Phone: ".$args['phone']."</p>";
			$body .= "<h2>Company Information</h2>";
			$body .= "<p>Dr. Name: ".$args['doctor_name']."</p>";
			$body .= "<p>Practice Name: ".$args['practice']."</p>";
			$body .= "<p>Address: ".$args['address-one'];
			if($args['address-two'])
				$body .= "<p>Address: ".$args['address-two'];
			$body .= "</p>";
			$body .= "<p>City, State Zip: ".$args['city'].", ".$args['state']." ".$args['zip']."</p>";
			$body .= "<p>Website: ".$args['website']."</p>";
			$body .= "<p>Dealer/Distribution Co.: ".$args['distribution_co']."</p>";
			$body .= "<p>Serial Number: ".$args['serial_number']."</p>";
			$body .= "</td><td colspan='1' width='10%'>&nbsp;</td></tr>";
			$body .= "<tr><td colspan='3' width='100%'><center><img src='http://www.sinsationalsmile.com/img/inquiry-footer.png' width='100%'></center>";
			$body .= "<center>Copyright &copy; Sinsational Smile ".date('Y').". All Rights Reserved.</center></td></tr></table>";

			$this->content = new SendGrid\Content("text/html", $body);
			$this->mail = new SendGrid\Mail($this->emailFrom, $this->subject, $this->emailTo, $this->content);			
			$this->resp = $this->sg->client->mail()->send()->post($this->mail);
			
			$this->sendRegConfirmationEmail($name, $args['email']);
		}

		/*****************************************************************************************************************************
		* Email to be sent to contact submitter
		*
		*
		*
		*****************************************************************************************************************************/
		public function sendReceiptEmail($args)
		{
			$name = $args["fName"]. " ".$args["lName"];
			$emailTo = new SendGrid\Email($name, $args['email']);
			$this->subject = "Your inquiry for Sinsational Smile has been received ";
			$body = "<table width='100%'>";
			$body .= "<tr>";
			$body .= "<th bgColor='#8f7a63' colspan='3'>";
			$body .= "<center><img src='http://www.sinsationalsmile.com/img/inquiry-header.png' width='100%'></center>";
			$body .= "</th>";
			$body .= "</tr>";
			$body .= "<tr>";
			$body .= "<td colspan='1' width='10%'>&nbsp;</td>";
			$body .= "<td colspan='1' padding-left='10%' padding-right='10%'>";
			$body .= "<center><h1>Your inquiry to Sinsational Smile<sup><font size='2pt'>&copy;</font></sup> has been received!</h1></center>";
			$body .= "<hr>";
			$body .= "<p>We would like to thank you for taking the time to reach out to us and to let you know we will be in touch shortly.</p>";
			$body .= "<p>For the time being, please don't hesitate to continue browsing our website at <a href='http://www.sinsationalsmile.com'>www.sinsationalsmile.com</a></p>";
			$body .= "<p>Thanks again!</p>";
			$body .= "<p>Sincerely,</p>";
			$body .= "<p>Sinsational Smile&copy;</p>";
			$body .= "</td><td colspan='1' width='10%'>&nbsp;</td></tr>";
			$body .= "<tr><td colspan='3' width='100%'><center><img src='http://www.sinsationalsmile.com/img/inquiry-footer.png' width='100%'></center>";
			$body .= "<center>Copyright &copy; Sinsational Smile ".date('Y').". All Rights Reserved.</center></td></tr></table>";

			$this->content = new SendGrid\Content("text/html", $body);
			$this->mail = new SendGrid\Mail($this->emailFrom, $this->subject, $emailTo, $this->content);			
			$this->resp = $this->sg->client->mail()->send()->post($this->mail);
		}

		/*****************************************************************************************************************************
		* Email confirmation of product registration
		*
		*
		*
		*****************************************************************************************************************************/
		public function sendRegConfirmationEmail($to, $email)
		{
			$this->mail->AddAddress($email);
			$this->subject = "Your Sinsational Smile product has been registered";
			$body = "<table width='100%'>";
			$body .= "<tr>";
			$body .= "<th bgColor='#8f7a63' colspan='3'>";
			$body .= "<center><img src='http://www.sinsationalsmile.com/img/inquiry-header.png' width='100%'></center>";
			$body .= "</th>";
			$body .= "</tr>";
			$body .= "<tr>";
			$body .= "<td colspan='1' width='10%'>&nbsp;</td>";
			$body .= "<td colspan='1' padding-left='10%' padding-right='10%'>";
			$body .= "<center><h1>Your Sinsational Smile<sup><font size='2pt'>&copy;</font></sup> product has been registered.</h1></center>";
			$body .= "<hr>";
			$body .= "<p>{$to}, thank you for registering your product!</p>";
			$body .= "<p>We're storing this information in our system so that we can provide you the stellar service you've come to expect from ";
			$body .= "Sinsational Smile<sup><font size='1pt'>&copy;</font></sup>. Should you have any questions or concerns, reach out to us via email ";
			$body .= "at <a href='mailto://info@sinsationalsmile.com'>info@sinsationalsmile.com</a>, social media, or by phone at <a href='tel://800-407-6820'>1-800-407-6820</a>.</p>";
			$body .= "<p>Thank you again for choosing Sinsational Smile<sup><font size='1pt'>&copy;</font></sup> as your whitening product of choice!</p>";
			$body .= "<p>Sincerely,</p>";
			$body .= "<p>Sinsational Smile&copy;</p>";
			$body .= "</td><td colspan='1' width='10%'>&nbsp;</td></tr>";
			$body .= "<tr><td colspan='3' width='100%'><center><img src='http://www.sinsationalsmile.com/img/inquiry-footer.png' width='100%'></center>";
			$body .= "<center>Copyright &copy; Sinsational Smile ".date('Y').". All Rights Reserved.</center></td></tr></table>";

			$this->content = new SendGrid\Content("text/html", $body);
			$this->mail = new SendGrid\Mail($this->emailFrom, $this->subject, $this->emailTo, $this->content);			
			$this->resp = $this->sg->client->mail()->send()->post($this->mail);
		}

		/*****************************************************************************************************************************
		* Send Purchase Order on submission of product order
		*
		*
		*
		*****************************************************************************************************************************/
		public function sendPurchaseOrderEmail()
		{
			$this->subject = "An order is being processed on the website";
			$body = "<table width='100%'>";
			$body .= "<tr>";
			$body .= "<th bgColor='#8f7a63' colspan='3'>";
			$body .= "<center><img src='http://www.sinsationalsmile.com/img/inquiry-header.png' width='100%'></center>";
			$body .= "</th>";
			$body .= "</tr>";

			$body .= "<tr>";
			$body .= "<td colspan='3'>Below are the details associated with an order being processed through the Sinsational Smile Website. You will receive ";
			$body .= "notification from Paypal pertaining to this order as well.\n\n</td>";
			$body .= "</tr>";
			$body .= "<tr>";
			$body .= "<table border='1' bordercolor='#000000' width='100%'>";
			$body .= "<tr>";
			$body .= "<th colspan='1'><strong>Qty.</strong></th><th colspan='1'><strong>Product Name</strong></th><th colspan='1'><strong>Price</strong></th>";
			$body .= "</th>";
			$body .= "</tr>";
			foreach($_SESSION[PUBLIC_SITE]['cart'] as $key => $value)
				$body .= "<tr><td colspan='1'>{$value['qty']}</td><td colspan='1'>{$value['name']}</td><td colspan='1'>{$value['price']}</td>";
			$body .= "</table>";
			$body .= "<tr><td colspan='3' width='100%'><center><img src='http://www.sinsationalsmile.com/img/inquiry-footer.png' width='100%'></center>";
			$body .= "<center>Copyright &copy; Sinsational Smile ".date('Y').". All Rights Reserved.</center></td></tr></table>";
			// var_dump($body);

			$this->content = new SendGrid\Content("text/html", $body);
			$this->mail = new SendGrid\Mail($this->emailFrom, $this->subject, $this->emailTo, $this->content);			
			$this->resp = $this->sg->client->mail()->send()->post($this->mail);
		}

		/*****************************************************************************************************************************
		* Send Sinsational the contact information received via landing page
		*
		*
		*
		*****************************************************************************************************************************/
		public function sendBestFormMsg($args)
		{
			$this->subject = "BEST for Dentistry Form Submission";
			$body = "<table width='100%'>";
			$body .= "<tr>";
			$body .= "<th bgColor='#8f7a63' colspan='3'>";
			$body .= "<center><img src='http://www.sinsationalsmile.com/img/inquiry-header.png' width='100%'></center>";
			$body .= "</th>";
			$body .= "</tr>";

			$body .= "<tr>";
			$body .= "<td colspan='3'>A submission has been processed on the BEST for Dentistry landing page. Below are the details\n\n</td>";
			$body .= "</tr>";
			$body .= "<tr>";
			$body .= "<td colspan='3'>Name: ".$args['best-name']."</td>";
			$body .= "</tr>";
			$body .= "<tr>";
			$body .= "<td colspan='3'>Title: ".$args['best-title']."</td>";
			$body .= "</tr>";
			$body .= "<tr>";
			$body .= "<td colspan='3'>Phone: ".$args['best-phone']."</td>";
			$body .= "</tr>";
			$body .= "<tr>";
			$body .= "<td colspan='3'>Email: ".$args['best-email']."</td>";
			$body .= "</tr>";
			$body .= "<tr><td colspan='3' width='100%'><center><img src='http://www.sinsationalsmile.com/img/inquiry-footer.png' width='100%'></center>";
			$body .= "<center>Copyright &copy; Sinsational Smile ".date('Y').". All Rights Reserved.</center></td></tr></table>";
			// var_dump($body);

			$this->content = new SendGrid\Content("text/html", $body);
			$this->mail = new SendGrid\Mail($this->emailFrom, $this->subject, $this->emailTo, $this->content);			
			$this->resp = $this->sg->client->mail()->send()->post($this->mail);
		}

		/*****************************************************************************************************************************
		* Send email campaign
		*
		*
		*
		*****************************************************************************************************************************/
		public function sendCampaign(&$args)
		{
			$error = NULL;
			require_once("email-templates/EmailTemplate.class.php");
			$et = new EmailTemplate();
			$et->loadContentByCampaign($args['campaign_id']);

			if($et->data !== NULL)
			{
				$this->mail->IsHTML(true);
				$this->subject = $args['name'];
				$body = "";

				$smrty = new MySmarty();
				$smrty->assign('url', WEBSITE_URL);
				$smrty->assign('content', $args['content']);
				$fh = fopen(ADMIN_PATH."/email-templates/temp/".session_id().".html", "w");
				fwrite($fh, $smrty->fetch($args['template']));
				fclose($fh);

				if(TEST)
					$this->mail->AddAddress($_SESSION[ADMIN_SITE]['email'], $_SESSION[ADMIN_SITE]['uname']);
				else
				{
					foreach($args['list'] AS $l)
						$this->mail->AddAddress($l['email'], $l['applicant']);
				}
			}
			else
				$error = array('severity' => 1, 'msg' => "Empty Template Body");
			return $error;
		}

		/*****************************************************************************************************************************
		* Send Document via email
		*
		*
		*
		*****************************************************************************************************************************/
		public function sendDocumentViaEmail($fileName, $file)
		{
			$this->subject = "Sinsational Smile sent you ".$fileName;
			$body = "<table width='100%'>";
			$body .= "<tr>";
			$body .= "<th bgColor='#8f7a63' colspan='3'>";
			$body .= "<center><img src='http://www.sinsationalsmile.com/img/inquiry-header.png' width='100%'></center>";
			$body .= "</th>";
			$body .= "</tr>";
			$body .= "<tr>";
			$body .= "<td colspan='3'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			$body .= "</tr>";
			$body .= "<tr>";
			$body .= "<td colspan='3'>".$_SESSION[ADMIN_SITE]['uname']." at Sinsational Smile has sent you ".$fileName.".</td>";
			$body .= "</tr>";
			$body .= "<tr>";
			$body .= "<td colspan='3'>If you were not anticipating receiving a document from ".$_SESSION[ADMIN_SITE]['uname'].", please disregard this message.</td>";
			$body .= "</tr>";
			$body .= "<tr><td colspan='3' width='100%'><center><img src='http://www.sinsationalsmile.com/img/inquiry-footer.png' width='100%'></center>";
			$body .= "<center>Copyright &copy; Sinsational Smile ".date('Y').". All Rights Reserved.</center></td></tr></table>";
			// $this->mail->addAttachment($args['path']);
			// var_dump($body);
			$attachment = new SendGrid\Attachment();
			$encode_file = base64_encode($file);
			$attachment->setContent($encode_file);
			$attachment->setType("application/pdf");
			$attachment->setDisposition("attachment");
			$attachment->setFilename($fileName);

			$this->content = new SendGrid\Content("text/html", $body);
			$this->mail = new SendGrid\Mail($this->emailFrom, $this->subject, $this->emailTo, $this->content);	
			$this->mail->addAttachment($attachment);		
			$this->resp = $this->sg->client->mail()->send()->post($this->mail);
		}
	}
