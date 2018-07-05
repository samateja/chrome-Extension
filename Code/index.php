<?php
echo 'Hello World!';
$test=2;

if ($test>1)
{
error_log("A custom error has been triggered",
1,"someone@example.com","From:anil@umstechlab.com");
}

?>