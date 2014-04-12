<?php
    
    // Include the SDK using the Composer autoloader
    require '../vendor/autoload.php';
    
    use Aws\SNS\SNSClient;
    use Aws\SQS\SQSClient;

    
    //creating Amazon SQS    
    $sqs = SQSClient::factory(array(
        'key'    => 'Your Key',
        'secret' => 'Your Secret',
        'region' => 'us-east-1',
    ));
    
    
    //grabing the queue_url
    $queue_url = 'https://sqs.us-east-1.amazonaws.com/024141142612/test-queue';
    //echo $queue_url;
    
    //grabing the queue_arn
    $queue_arn = $sqs->getQueueArn( $queue_url);
    //echo $queue_arn;
        
    
    //Received message from Queue
    
    $receive_result = $sqs->receiveMessage(array(
        'QueueUrl' => $queue_url,
    ));
    
    foreach ($receive_result->getPath('Messages/*/Body') as $messageBody) {
      
        echo $messageBody;
    }

?>