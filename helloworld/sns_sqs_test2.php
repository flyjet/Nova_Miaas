<?php
    
    // Include the SDK using the Composer autoloader
    require '../vendor/autoload.php';
    
    use Aws\SNS\SNSClient;
    use Aws\SQS\SQSClient;

    //creating Amazon SNS
    $sns = SNSClient::factory(array(
        'key'    => 'Your Key',
        'secret' => 'Your Secret',
        'region' => 'us-east-1',
    ));    
               
    //creating a new topic in the SNS
    $response_topic = $sns->createTopic(array(
        'Name' => 'test-topic2',
    ));
    
    //get topic arn
    $topic_arn = $response_topic->get('TopicArn');
    
    //echo $topic_arn;
    
    
    //creating Amazon SQS    
    $sqs = SQSClient::factory(array(
        'key'    => 'Your Key',
        'secret' => 'Your Secret',
        'region' => 'us-east-1',
    ));
    
    //creating a new queue in SQS
    $response_queue = $sqs->createQueue(array(
        'QueueName' => 'test-queue2',
    ));
    
    //grabing the queue_url
    $queue_url = $response_queue->get('QueueUrl');
    //echo $queue_url;
    
    //grabing the queue_arn
    $queue_arn = $sqs->getQueueArn( $queue_url);
    //echo $queue_arn;
    

    
    //set Queue attribute
    //should be use $queue_arn and $topic_arn
    
    $policy = '{
        "Version": "2008-10-17",
        "Id": "arn:aws:sqs:us-east-1:024141142612:test-queue/SQSDefaultPolicy",
        "Statement": [
            {
                "Sid": "Sid1397322757984",
                "Effect": "Allow",
                "Principal": {
                    "AWS": "*"
                },
                "Action": "SQS:SendMessage",
                "Resource": "arn:aws:sqs:us-east-1:024141142612:test-queue2",
                "Condition": {
                    "ArnEquals": {
                        "aws:SourceArn": "arn:aws:sns:us-east-1:024141142612:test-topic2"
                                       
                    }
                }
            }
        ]
    }'
    ;
    
    echo $policy;
    
    $response_att = $sqs->setQueueAttributes(array(
                                              
       'QueueUrl' => $queue_url,
       'Attributes' => array(                             
            'Policy' => $policy,
        )
    ));
    

   
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