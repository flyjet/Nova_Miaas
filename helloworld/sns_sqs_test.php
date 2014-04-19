<?php
    
    // Include the SDK using the Composer autoloader
    require '../vendor/autoload.php';
    
    use Aws\SNS\SNSClient;
    use Aws\SQS\SQSClient;

    //creating Amazon SNS
    $sns = SNSClient::factory(array(
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ));    
               
    //creating a new topic in the SNS
    $response_topic = $sns->createTopic(array(
        'Name' => 'test-topic',
    ));
    
    //get topic arn
    $topic_arn = $response_topic->get('TopicArn');
    
    echo $topic_arn;
    
    
    //creating Amazon SQS    
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ));
    
    //creating a new queue in SQS
    $response_queue = $sqs->createQueue(array(
        'QueueName' => 'test-queue',
    ));
    
    //grabing the queue_url
    $queue_url = $response_queue->get('QueueUrl');    
    echo $queue_url;    
    
    //grabing the queue_arn
    $queue_arn = $sqs->getQueueArn( $queue_url);
    echo $queue_arn;
    
    
    //set Queue attribute
    
   
    //subscribing the topic to sqs .Now a new message to SNS, will push the message into the SQS

    $result = $sns->subscribe(array(
        'TopicArn' => $topic_arn,
        'Protocol' => 'sqs',
        'Endpoint' => $queue_arn,
        ));
    
    
    //message publish to the topic arn
    
    $publish_result = $sns->publish(array(
        'TopicArn' => $topic_arn,
        'Message' => 'This is test for send message from SNS to SQS.',
    ));
    
    if ($publish_result) {
        echo 'success sent notification of SNS to SQS.';
    }
    else {
        echo 'Error sent notificaiton of SNS to SQS.';
    }
        
    
    //Received message from Queue
    
    $receive_result = $sqs->receiveMessage(array(
        'QueueUrl' => $queue_url,
    ));
    
    foreach ($receive_result->getPath('Messages/*/Body') as $messageBody) {
      
        echo $messageBody;
    }

?>