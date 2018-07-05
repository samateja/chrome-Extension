<?php
date_default_timezone_set('Asia/Calcutta');

error_reporting(0);

if(isset($_GET['sEmail']) && isset($_GET['oEmail']))
{
  try
  {
  
    include_once('config.php');

   
    $semail=  $_GET['sEmail'];
    $oemail=  $_GET['oEmail'];
    $sql = "SELECT * FROM `info` WHERE `email` LIKE '$oemail'  ";
    $result= mysql_query($sql)or die(""); 
    $row_select= mysql_num_rows ($result);
    if($row_select==0)
    {
	 $result_json= array(
	     'Result' =>"not"
	      );
 	    echo json_encode($result_json);
    }
    else
    {
        $row= mysql_fetch_assoc($result);
	$url="https://api.leadsquared.com/v2/LeadManagement.svc/Leads.GetByEmailaddress?accessKey=".$row["access"]."&secretKey=".$row["secret"]."&emailaddress=".$semail;
	$response=file_get_contents($url);
	$obj = json_decode($response,true);
        if($response!=null)
	{
	    $jsonData = json_decode($response,true);
	    $elementCount  = count($jsonData);
	    if($elementCount!=0)
	    {
	    $result_json= array('Mobile' => $obj[0]['Mobile'],
	     'ProspectStage' => $obj[0]['ProspectStage'],
	     'Score' =>  $obj[0]['Score'],
	     'Source' => $obj[0]['Source'],
	     'Region' => $obj[0]['Region'],
	     'Result' =>"1"
	      );
 	    echo json_encode($result_json);
		
	    }
	    else
	    {
	         $result_json= array('Mobile' => $obj[0]['Mobile'],
	     'ProspectStage' => $obj[0]['ProspectStage'],
	     'Score' =>  $obj[0]['Score'],
	     'Source' => $obj[0]['Source'],
	     'Region' => $obj[0]['Region'],
	     'Result' =>"0"
	      );
 	    echo json_encode($result_json);
	    }
  	}
	else
	{
	    $result_json= array(
	     'Result' =>"3"
	      );
 	    echo json_encode($result_json);
	}
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