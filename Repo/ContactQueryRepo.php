<?php 
class ContactQueryRepo{

	public function getContactQueries($request)
		{
			$requestData = $request;
			// Initial response is bad request
			$response = 400;

			// If there is some data in json form
			if(!empty($requestData))
			{				
				$exists = $GLOBALS['con']->from('contact_query')->where('id',$requestData['id']);
				$data = array();

				foreach($exists as $items)
		    	{
					$data[] = $items;

				}

				$response = 200;
			}
			
			else
			{
				$exists = $GLOBALS['con']->from('contact_query');
				$data = array();

				foreach($exists as $items)
		    	{
					$data[] = $items;

				}

				$response = 200;
					
			}
			
			return array('code' => $response,'data' => $data);
			
	}

	public function addContactQuery($request)
	{

		if(!empty($request))
		{
			$name 				= $request['name'];
			$email 				= $request['email'];
			$number				= $request['number'];
			$desc    			= $request['desc'];
			$country 			= $request['country'];


			$values = array('name' => $name,'email' => $email,'number' => $number ,	'desc' => $desc, 'country' => $country , 'date_created' => date("Y-m-d H:i:s"));
			$query = $GLOBALS['con']->insertInto('contact_query', $values)->execute();

			// Enter your email address below.
			// Example $to_address = "bruce.wayne@yourdomain.com";
			$to_address = "your_email_address@domain.com"; 

			// Also, you can change the value of the $subject variable to whatever you like
			$subject = "$name has contacted you via your Contact Form";


			// Message Content
			$body = "You have been contacted by $name." . "\r\n" . "\r\n";
			$content = $desc . "\r\n" . "\r\n";
			$reply = "You can contact $name at: $email.";


			$message = wordwrap($body . $content . $reply, 70);


			// Headers
			$headers  = "From: $name " . "\r\n";
			$headers .= "Reply-To: $email" . "\r\n";
			$headers .= "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-Type: text/plain; charset=UTF-8" . "\r\n";
			$headers .= "Content-Transfer-Encoding: quoted-printable" . "\r\n";


			// Please ensure that PHP mail() function is correctly configured on your server.
			if ( mail($to_address, $subject, $message, $headers) ) {
				$response ='200';
			} else {
				$response = '400';
			}
			$response = '200';

		}
		else
		{
			$response = '400';
		}


		return $response;

	}

}
