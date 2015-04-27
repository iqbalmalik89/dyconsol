<?php 
class JobRepo{

	public function getJobs($request)
		{
			$requestData = $request;
			// Initial response is bad request
			$response = 400;

			// If there is some data in json form
			if(!empty($requestData['id']))
			{				
				$exists = $GLOBALS['con']->from('jobs')->where('id',$requestData['id']);
				$data = array();

				foreach($exists as $items)
		    	{
					$data[] = $items;

				}

				$response = 200;
			}
			
			else
			{
				$exists = $GLOBALS['con']->from('jobs');
				$data = array();

				foreach($exists as $items)
		    	{
					$data[] = $items;

				}

				$response = 200;
					
			}
			
			return array('code' => $response,'data' => $data);
			
	}

	public function deleteJob($request)
	{
		$id = $request['id'];
		$response = 400;

		if(!empty($id))
		{
			$exists = $GLOBALS['con']->from('jobs')->where('id',$id)->count();
			if($exists)
			{
				$query = $GLOBALS['con']->deleteFrom('jobs')->where('id', $id)->execute();
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

	public function addJob($request)
	{
		$response = 400;
		if(!empty($request))
		{
	
			$values = array('title' => $request['title'],'desc' => $request['desc'], 'date_added' => date("Y-m-d H:i:s"));
			$query = $GLOBALS['con']->insertInto('jobs', $values)->execute();
			$response = '200';
		}
		else
		{
			$response = '400';
		}


		return $response;

	}

	public function editJob($request)
	{
		$response = 400;

		if(!empty($request['title']))
		{
			$count = $GLOBALS['con']->from('jobs')->where('id',$request['id'])->count();
			echo $count;
			if($count > 0)
			{
				$date_created = date("Y-m-d H:i:s");
				$values = array('title' => $request['title'], "desc" => $request['desc'],'date_created' => $date_created);
				$query = $GLOBALS['con']->update('jobs', $values, $request['id'])->execute();
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
