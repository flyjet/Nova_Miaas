<?php    
// Include the SDK using the Composer autoloader
	require '../vendor/autoload.php';
	use Aws\SNS\SNSClient;
	use Aws\SQS\SQSClient;

	class SQS_message{

		public static $receive_Message = "";
		public static $receiveMessage_handle = "";
		public static $receiveMessage_queueUrl ="https://sqs.us-east-1.amazonaws.com/024141142612/receivedfrom_Host";

		public static function init_SNS(){
		   
		    $sns = SNSClient::factory(array(
	        'key'    => 'AKIAJYYAHUDDRUVSGCUQ',
	        'secret' => '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',
	        'region' => 'us-east-1',
	    	));  
	    	return $sns;
		}

		public static function init_SQS(){
		   
		    $sqs  = SQSClient::factory(array(
	        'key'    => 'AKIAJYYAHUDDRUVSGCUQ',
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
			$Messages ="";
			$sqs = SQS_message::init_SQS();
			$receive_result = $sqs->receiveMessage(array(
	      		  'QueueUrl' => SQS_message::$receiveMessage_queueUrl ,
	   		));

			$Messages = $receive_result->getPath('Messages');
			if(isset($Messages)){
				foreach ($Messages as $msg) {

		   			$receiveMessage_handle = $msg["ReceiptHandle"];
		   			$receive_Message =$msg["Body"];
		   			//$msg_body = json_decode($msg['Body'], true);
		   			//$receive_Message = $msg_body['Message'];

	        		//echo $message= $msg['Body'];     //if message send driectly from Java
	        	
		        	$message .= $receive_Message ;
		        	$message .= "*";
		        	$message .= $receiveMessage_handle;
		        	$message .="*";
		        	$message .=SQS_message::$receiveMessage_queueUrl;
					}
				}
         		return $message;
         } 

         //delete message from Queue
  
         public static function delete_message_from_SQS($Url, $Handle){

         	$sqs = SQS_message::init_SQS();
			$result = $sqs->deleteMessage(array(
   			   'QueueUrl' => $Url,
    		   'ReceiptHandle' => $Handle,
			));
         }



	}//end of class SQS_message
?>