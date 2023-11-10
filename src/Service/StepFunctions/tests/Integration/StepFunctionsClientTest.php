<?php

namespace AsyncAws\StepFunctions\Tests\Integration;

use AsyncAws\Core\Credentials\Credentials;
use AsyncAws\Core\Test\TestCase;
use AsyncAws\StepFunctions\Input\SendTaskFailureInput;
use AsyncAws\StepFunctions\Input\SendTaskHeartbeatInput;
use AsyncAws\StepFunctions\Input\SendTaskSuccessInput;
use AsyncAws\StepFunctions\Input\StartExecutionInput;
use AsyncAws\StepFunctions\Input\StopExecutionInput;
use AsyncAws\StepFunctions\StepFunctionsClient;

class StepFunctionsClientTest extends TestCase
{
    public function testSendTaskFailure(): void
    {
        $client = $this->getClient();

        $input = new SendTaskFailureInput([
            'taskToken' => 'change me',
            'error' => 'change me',
            'cause' => 'change me',
        ]);
        $result = $client->sendTaskFailure($input);

        $result->resolve();
    }

    public function testSendTaskHeartbeat(): void
    {
        $client = $this->getClient();

        $input = new SendTaskHeartbeatInput([
            'taskToken' => 'change me',
        ]);
        $result = $client->sendTaskHeartbeat($input);

        $result->resolve();
    }

    public function testSendTaskSuccess(): void
    {
        $client = $this->getClient();

        $input = new SendTaskSuccessInput([
            'taskToken' => 'change me',
            'output' => 'change me',
        ]);
        $result = $client->sendTaskSuccess($input);

        $result->resolve();
    }

    public function testStartExecution(): void
    {
        $client = $this->getClient();

        $input = new StartExecutionInput([
            'stateMachineArn' => 'change me',
            'name' => 'change me',
            'input' => 'change me',
            'traceHeader' => 'change me',
        ]);
        $result = $client->startExecution($input);

        $result->resolve();
    }

    public function testStopExecution(): void
    {
        $client = $this->getClient();

        $input = new StopExecutionInput([
            'executionArn' => 'change me',
            'error' => 'change me',
            'cause' => 'change me',
        ]);
        $result = $client->stopExecution($input);

        $result->resolve();
    }

    private function getClient(): StepFunctionsClient
    {
        return new StepFunctionsClient([
            'endpoint' => 'http://localhost:4580',
        ], new Credentials('aws_id', 'aws_secret'));
    }
}
