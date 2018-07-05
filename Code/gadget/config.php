<?php
// Create connection

$connection=mysql_connect("localhost","gmailuxo_gUser","gadget2013");
if(!$connection)
  throw new Exception("Value must be 1 or below");
$selected = mysql_select_db("gmailuxo_gadget",$connection);

?>