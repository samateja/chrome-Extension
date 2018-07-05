<?php

date_default_timezone_set('Asia/Calcutta');

error_reporting(0 );
if(isset($_POST['senderEmail'])&&isset($_POST['toEmail'])&&isset($_POST['senderName']))
{
   try{
     /// parameters get 
	$semail=$_POST['senderEmail'];
	$tomail=$_POST['toEmail'];
	$subject=$_POST['subject'];
	$body=$_POST['body'];
	$sender=$_POST['senderName'];
	include_once('config.php');
	// DB operation
	$sql = "SELECT * FROM `info` WHERE `email` LIKE '$tomail'";
	$result= mysql_query($sql); 
	$row= mysql_fetch_assoc($result)or die('Error, Could not coonect to Database');
	$row_select= mysql_num_rows ($result);

	
	// Business logic
	if($row_select!=0)
	{
		$access=$row['access'];
		$secret=$row['secret'];
		$url = "https://api.leadsquared.com/v2/LeadManagement.svc/NotableActivity.Post?accessKey=".$access."&client=EmailClient&secretKey=".$secret;
		$cnt=12;
		$date_c= date("Y-m-d G:i:s", time());
		$content = array (
		                        "from"=>$semail,
		                        "fromName"=>$sender,
		                        "eventType"=>$cnt,
		                        "activityDateTime"=> $date_c,
		                        "emailSubject"=>$subject,
		                        "emailBody"=>$body
		            );
							
		 $curl = curl_init($url);
		 curl_setopt($curl, CURLOPT_HEADER, false);
		 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		 curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		 curl_setopt($curl, CURLOPT_POST, true);
		 curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode( $content));
		 $json_response = curl_exec($curl);
		 curl_error($curl);
		 $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		 if( $status == 200 )
		{
		echo "1";
		}
		else if($status == 500)
		{
		 echo "2";
		}
		else
		{
		 echo "0";	
		}
		
		curl_close($curl);
		$response = json_decode($json_response, true);
	}
	else
	{
	echo 3;
	}
	
   }
   catch(Exception $e)
   {
   	echo "Error";
        $error = $e;
	file_put_contents("error_log.txt", $error, FILE_APPEND);
   }

}



?>