# Amazon Simple Queue Service - SQS

Service: https://aws.amazon.com/sqs/

## Usage

    // create sqs message
    $message = json_encode(
        array('command' => 'your-awesome-command')
    );
    $queue = 'your-queue-name';
    $options  = array() # optional arguments for the SQS client

    // send message to sqs
    $this->get('november_five_aws.sqs_manager')->sendMessage($message, $queue, $options);

    // send encrypted message to sqs
    $this->get('november_five_aws.sqs_manager')->sendEncryptedMessage($message, $queue, $options);
    
    // get the queue url
    $this->get('november_five_aws.sqs_manager')->getQueueUrl($queue, $options);