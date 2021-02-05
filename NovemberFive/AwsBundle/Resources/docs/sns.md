# Amazon Simple Notification Service - SNS

Service: https://aws.amazon.com/sns/

## Usage

    $applicationArn = '0000000'; // application Amazon Resource Name (ARN)
    $token = '0000'; // device push id
    $customerUserData = array(); // optional user data to be saved on SNS, this has NO functional reason on SNS
    $options = array(); // optional SNS Client options
    $applicationEndpointArn = '0000000'; // the application endpoint ARN
    $topicArn = '0000000'; // the topic ARN
    $message = ''; // message to be published

    // create platform endpoint on SNS for a given application
    $this->get('november_five_aws.sns_manager')->createPlatformEndpoint($applicationArn, $token, $customerUserData, $options);

    // update application endpoint on SNS
    $this->get('november_five_aws.sns_manager')->updatePlatformEndpoint($applicationEndpointArn, $token, $customerUserData, $options);
    
    // subscribe a given endpoint to a given topic
    $this->get('november_five_aws.sns_manager')->createSubscription($applicationEndpointArn, $topicArn, $options);
    
    // publish a given message
    $this->get('november_five_aws.sns_manager')->publish($message);
    
    // get platform endpoint attributes
    $this->get('november_five_aws.sns_manager')->getPlatformEndpointAttributes($applicationArn);