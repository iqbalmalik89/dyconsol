<?php 
class ClientsRepo{

	public function getClients($request)
	{
			$requestData = $request;
			// Initial response is bad request
			$response = 400;

			// If there is some data in json form
			if(!empty($requestData['id']))
			{				
				$count = $GLOBALS['con']->from('clients')->where('id',$request['id'])->count();
				if($count > 0)
				{
					$exists = $GLOBALS['con']->from('clients')->where('id',$requestData['id']);
					$data = array();

					foreach($exists as $clients)
			    	{
						$data[] = $clients;

					}

					$response = 200;
				}
				else
				{
					$data = array();
					$response = 400;
				}
			}
			
			else
			{
				$exists = $GLOBALS['con']->from('clients');
				$data = array();

				foreach($exists as $clients)
		    	{
					$data[] = $clients;

				}

				$response = 200;
					
			}
			
			return array('code' => $response,'data' => $data);
			
	}

	public function deleteClient($request)
	{
		$id = $request['id'];
		$response = 400;

		if(!empty($id))
		{
			$exists = $GLOBALS['con']->from('clients')->where('id',$id)->count();
			if($exists)
			{
				$query = $GLOBALS['con']->deleteFrom('clients')->where('id', $id)->execute();
				$response = 200;
			}
			else
			{
				$response = 400;
			}
		}
		else
		{
			$response = 400;
		}
		return $response;

	}

	public function addClient($request)
	{
		$response = 400;
		if(!empty($request))
		{
	
			$values = array('client_name' => $request['client_name'],'person_name' => $request['person_name'] ,'testimonial' => $request['testimonial'],'picture' => $request['picture'], '`status`' => $request['status']);
			$query = $GLOBALS['con']->insertInto('clients', $values)->execute();


			$response = '200';
		}
		else
		{
			$response = '400';
		}


		return $response;

	}

	public function editClient($request)
	{
		$response = 400;

		if(!empty($request['id']))
		{
			$count = $GLOBALS['con']->from('clients')->where('id',$request['id'])->count();

			if($count > 0)
			{
				$values = array('client_name' => $request['client_name'],'person_name' => $request['person_name'] ,'testimonial' => $request['testimonial'], 'picture' => $request['picture'], '`status`' => $request['status']);
			$query = $GLOBALS['con']->update('clients', $values, $request['id'])->execute();

				$response = 200;
			}
			else
			{
				$response = 400;
			}
		}
		return $response;
	}
}
