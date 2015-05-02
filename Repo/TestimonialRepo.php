<?php 
class TestimonialRepo{

	public function getTestimonials($request)
	{
			$requestData = $request;
			// Initial response is bad request
			$response = 400;

			// If there is some data in json form
			if(!empty($requestData['id']))
			{				
				$count = $GLOBALS['con']->from('testimonial')->where('id',$request['id'])->count();
				if($count > 0)
				{
					$exists = $GLOBALS['con']->from('testimonial')->where('id',$requestData['id']);
					$data = array();

					foreach($exists as $testimonials)
			    	{
						$data[] = $testimonials;

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
				$exists = $GLOBALS['con']->from('testimonial');
				$data = array();

				foreach($exists as $testimonials)
		    	{
					$data[] = $testimonials;

				}

				$response = 200;
					
			}
			
			return array('code' => $response,'data' => $data);
			
	}

	public function deleteTestimonial($request)
	{
		$id = $request['id'];
		$response = 400;

		if(!empty($id))
		{
			$exists = $GLOBALS['con']->from('testimonial')->where('id',$id)->count();
			if($exists)
			{
				$query = $GLOBALS['con']->deleteFrom('testimonial')->where('id', $id)->execute();
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

	public function addTestimonial($request)
	{
		$response = 400;
		if(!empty($request))
		{
	
			$values = array('testimonial' => $request['testimonial'],'client_name' => $request['client_name'],'company_name' => $request['company_name'], '`status`' => $request['status']);
			$query = $GLOBALS['con']->insertInto('testimonial', $values)->execute();


			$response = '200';
		}
		else
		{
			$response = '400';
		}


		return $response;

	}

	public function editTestimonial($request)
	{
		$response = 400;

		if(!empty($request['id']))
		{
			$count = $GLOBALS['con']->from('testimonial')->where('id',$request['id'])->count();

			if($count > 0)
			{
				$values = array('testimonial' => $request['testimonial'],'client_name' => $request['client_name'],'company_name' => $request['company_name'], '`status`' => $request['status']);
				$query = $GLOBALS['con']->update('testimonial', $values, $request['id'])->execute();

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