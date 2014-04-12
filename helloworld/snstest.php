<?php
    
    // Include the SDK using the Composer autoloader
    require '../vendor/autoload.php';
    
    use Aws\SNS\SNSClient;

    //creating Amazon SNS
    $sns = SNSClient::factory(array(
        'key'    => 'Your Key',
        'secret' => 'Your Secret',
        'region' => 'us-east-1',
    ));
    
               
    //creating a new topic in the SNS
    $response = $sns->createTopic(array(
        'Name' => 'test-topic',
    ));
    
    //get topic arn
    $topic_arn = $response->get('TopicArn');
    
    echo $topic_arn;
        

    //The given email address will get a subscription confirmation message , once the user confirms the subscription , the email address will receive the email notification if any message is published to this topic 
    $result = $sns->subscribe(array(
        'TopicArn' => $topic_arn,
        'Protocol' => 'email',
        'Endpoint' => 'caoqisd@hotmail.com',
        ));
    
    
    
    
    //message publish to the topic arn
    
    $publish_result = $sns->publish(array(
        'TopicArn' => $topic_arn,
        'Message' => 'This is test for nova miaas.',
    ));
    
    if ($publish_result) {
        echo 'success sent notification of SNS.';
    }
    else {
        echo 'Error sent notificaiton of SNS.';
    }

?>