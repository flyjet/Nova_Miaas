<?php
    
    // Include the SDK using the Composer autoloader
    require '../vendor/autoload.php';
    
    use Aws\SNS\SNSClient;
    use Aws\SQS\SQSClient;

    //creating Amazon SNS
    $sns = SNSClient::factory(array(
        'key'    => 'AKIAJYYAHUDDRUVSGCUQ',
        'secret' => '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',
        'region' => 'us-east-1',
    ));    
               
    //creating a new topic in the SNS
//    $response_topic = $sns->createTopic(array(
//        'Name' => 'test-topic',
//    ));
    
    //get topic arn
//    $topic_arn = $response_topic->get('TopicArn');
    
//    echo $topic_arn;
    
    
    //creating Amazon SQS    
    $sqs = SQSClient::factory(array(    
        'key'    => 'AKIAJYYAHUDDRUVSGCUQ',
        'secret' => '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',
        'region' => 'us-east-1',
    ));
    
    //creating a new queue in SQS
 //   $response_queue = $sqs->createQueue(array(
 //       'QueueName' => 'test-queue',
 //   ));
    
    //grabing the queue_url
//    $queue_url = $response_queue->get('QueueUrl');    
//    echo $queue_url;    
    
    //grabing the queue_arn
//    $queue_arn = $sqs->getQueueArn( $queue_url);
//    echo $queue_arn;
    
    
    //set Queue attribute
    
   
    //subscribing the topic to sqs .Now a new message to SNS, will push the message into the SQS

//    $result = $sns->subscribe(array(
//        'TopicArn' => $topic_arn,
//        'Protocol' => 'sqs',
//        'Endpoint' => $queue_arn,
//        ));
    
    
    //message publish to the topic arn

    /*
    $publish_result = $sns->publish(array(
        'TopicArn' => "arn:aws:sns:us-east-1:024141142612:test-topic",
        'Message' => 'This is test for send message from SNS to SQS.',
    ));
    
    if ($publish_result) {
        echo 'success sent notification of SNS to SQS.\n';
    }
    else {
        echo 'Error sent notificaiton of SNS to SQS.\n';
    }
     */
        

    // echo $receive_result;
    // print_r($receive_result);
    //echo $receive_resuilt->body; //->ReceiveMessageResult->Message->ReceiptHandle;
    // echo "\n". $receive_result->get('Messages')->get('Message');
    // foreach ($receive_result->getPath('Messages/*/Body') as $messageBody) {
    //     $msg = json_decode($messageBody, true);
    //     echo $msg['Message'];

    //} 
    //echo "\n";



    //Received message from Queue

    $receive_result = $sqs->receiveMessage(array(
        'QueueUrl' => "https://sqs.us-east-1.amazonaws.com/024141142612/test-queue",
    ));

    foreach ($receive_result->getPath('Messages') as $msg) {
         $msg_hdr = $msg["ReceiptHandle"];
         $msg_body = json_decode($msg['Body'], true);
         print_r($msg_hdr);
         echo $msg_body['Message'];
         $delete_result = $sqs->deleteMessage( array(
              'QueueUrl' => "https://sqs.us-east-1.amazonaws.com/024141142612/test-queue",
              'ReceiptHandle' => $msg_hdr, ));
    }
    echo "\n";



?>
