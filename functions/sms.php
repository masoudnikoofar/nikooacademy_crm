<?php
function sms_send($message_destination,$message_body)
{
	global $db;
	global $today_datetime;
			
	
	if (substr($message_destination,0,2)=="09")
	{
		$message_destination = "98".substr($message_destination, 1);
	}
	else if (substr($message_destination,0,3)=="+98")
	{
		$message_destination = substr($message_destination, 1);
	}
	else if (substr($message_destination,0,4)=="0098")
	{
		$message_destination = substr($message_destination, 2);
	}

	
	
	$data = (
	[
		 "organization" => SMS_SERVICE_ORGANIZATION,
		 "username" => SMS_SERVICE_USERNAME,
		 "password" => SMS_SERVICE_PASSWORD,
		 "method" => "send",
		 "messages" => [
			 [
				 "sender" => SMS_SERVICE_SOURCE_NO,
				 "recipient" => $message_destination,
				 "body" => $message_body,
				 "customerId" => 1
			 ]
		 ]
	]);

	$data = json_encode($data);
	$client = curl_init(SMS_SERVICE_URL);
	curl_setopt($client,CURLOPT_POST,1);
	curl_setopt($client,CURLOPT_POSTFIELDS,$data);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
	$response=curl_exec($client);
	$result=json_decode($response,true);
	

	$message_server_id=$result['data'][0]['serverId'];
	$db->query("
		insert into messages set
		message_server_id='".$message_id."',
		message_source='".SMS_SERVICE_SOURCE_NO."',
		message_destination='".$message_destination."',
		message_date_time='".$today_datetime."',
		message_body='".$message_body."',
		message_status_code='".$message_status_code."',
		message_status_description='".$message_status_description."'
	");
}

function sms_updatestatus($message_server_id)
{
	global $db;
	$data = (
	[
		 "organization" => SMS_SERVICE_ORGANIZATION,
		 "username" => SMS_SERVICE_USERNAME,
		 "password" => SMS_SERVICE_PASSWORD,
		 "method" => "getstatus_serverId",
		 "serverIds" => [
			 $message_server_id
		 ]
	]);
	$data = json_encode($data);
	$client = curl_init(SMS_SERVICE_URL);
	curl_setopt($client,CURLOPT_POST,1);
	curl_setopt($client,CURLOPT_POSTFIELDS,$data);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
	$response=curl_exec($client);
	$result=json_decode($response,true);
	
	$message_status_description=$result['data'][0]['Status'];

	$db->query("
		update messages set
		message_status_description='".$message_status_description."'
		where message_server_id='".$message_server_id."'
	");	
}