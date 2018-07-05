<?php
error_reporting(0 );
if(isset($_POST['Email'])&&isset($_POST['AccessKey'])&&isset($_POST['SecretKey']))
 {
	
     try
       {	
          include_once('config.php');
	  $Email=$_POST['Email'];
	  $AccessKey=$_POST['AccessKey'];
	  $SecretKey=$_POST['SecretKey'];
	  $Action=$_POST['Action'];
		   echo "Error";
	  if($Action=="add")
	  {
	     echo mysql_query("INSERT INTO `info` (`email`, `secret`, `access`) VALUES ('$Email', '$AccessKey', '$SecretKey')")or die(""); 
	  }
	  if($Action=="update")
	  {
	     echo mysql_query("UPDATE  `info` SET  `secret` =  '$SecretKey',`access` = '$AccessKey' WHERE  `info`.`email` = '$Email'; ")or die(""); 
	  }
     }  
     catch(Exception $e)
     {
        echo "Error";
        $error = $e;
	file_put_contents("error_log.txt", $error, FILE_APPEND);
     }
					
 }
else
 {
  echo "0";
 }

?>