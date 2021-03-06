<?php

namespace AsyncAws\Sqs\Tests\Unit\Input;

use AsyncAws\Core\Test\TestCase;
use AsyncAws\Sqs\Input\ReceiveMessageRequest;

class ReceiveMessageRequestTest extends TestCase
{
    public function testRequest(): void
    {
        $input = new ReceiveMessageRequest([
            'QueueUrl' => 'queueUrl',
            'AttributeNames' => ['VisibilityTimeout', 'DelaySeconds', 'ReceiveMessageWaitTimeSeconds'],
            'MessageAttributeNames' => ['Attribute1'],
            'MaxNumberOfMessages' => 5,
            'VisibilityTimeout' => 15,
            'WaitTimeSeconds' => 20,
            'ReceiveRequestAttemptId' => 'abcdef',
        ]);

        /** @see https://docs.aws.amazon.com/AWSSimpleQueueService/latest/APIReference/API_ReceiveMessage.html */
        $expected = '
            POST / HTTP/1.0
            Content-Type: application/x-www-form-urlencoded

            Action=ReceiveMessage
            &Version=2012-11-05
            &QueueUrl=queueUrl
            &AttributeName.1=VisibilityTimeout
            &AttributeName.2=DelaySeconds
            &AttributeName.3=ReceiveMessageWaitTimeSeconds
            &MessageAttributeName.1=Attribute1
            &MaxNumberOfMessages=5
            &VisibilityTimeout=15
            &WaitTimeSeconds=20
            &ReceiveRequestAttemptId=abcdef
        ';

        self::assertRequestEqualsHttpRequest($expected, $input->request());
    }
}
