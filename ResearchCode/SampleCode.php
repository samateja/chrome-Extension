<?php
require ("aws.phar");
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Enum\ComparisonOperator;
use Aws\DynamoDb\Enum\Type;

try
{
	$aws = Aws\Common\Aws::factory("config.php");
	$client = $aws->get("dynamodb");
	$client->putItem (array (
		'TableName' => 'GmailAccessKeys',
		'Item' =>  $client->formatAttributes(array(
				'EmailAddress' => 'customer1@email.com',
				'AccessKey' => 'add the access key here',
				'SecretKey' => 'add the secret key here'
			))
		));
	echo 'Successfully stored <br/>';
	
	$response = $client->getItem(array(
		'TableName' => 'GmailAccessKeys',
		'Key' => array(
        'EmailAddress' => array(
            'S' => 'customer@email.com'
		)),
		'ConsistentRead' => true,
		'AttributesToGet' => array('AccessKey', 'SecretKey')
	));
	
	$accesskey =  $response['Item']['AccessKey']['S'];
	$secretkey = $response['Item']['SecretKey']['S'];
}
catch (Exception $ex)
{
   echo $ex->getMessage();
}
?>