<?php    
// Include the SDK using the Composer autoloader
	require '../vendor/autoload.php';
	use Aws\SNS\SNSClient;
	use Aws\SQS\SQSClient;

	class SQS_message{

		public static function init_SNS(){
		   
		    $sns = SNSClient::factory(array(
	        'key'    => 'AKIAIAAYH7HGLTEJQX5Q',
	        'secret' => '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',
	        'region' => 'us-east-1',
	    	));  
	    	return $sns;
		}

		public static function init_SQS(){
		   
		    $sqs  = SQSClient::factory(array(
	        'key'    => 'AKIAIAAYH7HGLTEJQX5Q',
	        'secret' => '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',
	        'region' => 'us-east-1',
	    	));  
	    	return $sqs;
		}

		public static function send_message_to_SQS($message){
			$sns = SQS_message::init_SNS();			
		    $topic_arn = "arn:aws:sns:us-east-1:024141142612:nova";
		    //message publish to the topic arn		   
		    $publish_result = $sns->publish(array(
		      	'TopicArn' => $topic_arn,
		        'Message'  => $message,
		    ));
		    if ($publish_result) {
        		return true;
    		}
			else {
			    return false;
			}
		}

		public static function receive_message_from_SQS(){
			$message ="";
			$sqs = SQS_message::init_SQS();
			$receive_result = $sqs->receiveMessage(array(
	      		  'QueueUrl' => "https://sqs.us-east-1.amazonaws.com/024141142612/receivedfrom_Host",
	   		));

	   		foreach ($receive_result->getPath('Messages/*/Body') as $messageBody) {
		         $msg = json_decode($messageBody, true);
		         $message = $msg['Message'];
		         //$message .=$msg['ReceiptHandle'];
        	}
         	return $message;  
         }

         public static function delete_message_from_SQS($Url, $Handle){

         	$sqs = SQS_message::init_SQS();
			$result = $sqs->deleteMessage(array(
   			   'QueueUrl' => $Url,
    		   'ReceiptHandle' => $Handle,
			));
         }



	}//end of class SQS_message
?>