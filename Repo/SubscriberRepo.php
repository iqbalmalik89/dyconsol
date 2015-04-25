<?php

class SubscriberRepo
{
	public function addSubscriber($request)
	{
		$response = 400;
		if(empty($request['subscribed']))
		{
			$subscribed = 'yes';
			echo 'yes';
		}
		else
		{
			$subscribed = $request['subscribed'];
		}
		if(!empty($request['subscriber_email']))
		{
			$values = array('subscriber_email' => $request['subscriber_email'],'subscribed' => $subscribed,'date_created' => date("Y-m-d H:i:s"));
			$query = $GLOBALS['con']->insertInto('subscriber', $values)->execute();
			$response = 200;
		}
		else
		{
			$response = 400;
		}
		return $response;
	}
}