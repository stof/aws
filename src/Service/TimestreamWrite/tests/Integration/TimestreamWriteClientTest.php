<?php

namespace AsyncAws\TimestreamWrite\Tests\Integration;

use AsyncAws\Core\Credentials\NullProvider;
use AsyncAws\Core\Test\TestCase;
use AsyncAws\TimestreamWrite\Enum\DimensionValueType;
use AsyncAws\TimestreamWrite\Enum\MeasureValueType;
use AsyncAws\TimestreamWrite\Input\WriteRecordsRequest;
use AsyncAws\TimestreamWrite\TimestreamWriteClient;
use AsyncAws\TimestreamWrite\ValueObject\Dimension;
use AsyncAws\TimestreamWrite\ValueObject\MeasureValue;
use AsyncAws\TimestreamWrite\ValueObject\Record;

class TimestreamWriteClientTest extends TestCase
{
    public function testWriteRecords(): void
    {
        $client = $this->getClient();

        $input = new WriteRecordsRequest([
            'DatabaseName' => 'change me',
            'TableName' => 'change me',
            'CommonAttributes' => new Record([
                'Dimensions' => [new Dimension([
                    'Name' => 'change me',
                    'Value' => 'change me',
                    'DimensionValueType' => DimensionValueType::VARCHAR,
                ])],
                'MeasureName' => 'change me',
                'MeasureValue' => 'change me',
                'MeasureValueType' => MeasureValueType::VARCHAR,
                'Time' => 'change me',
                'TimeUnit' => 'change me',
                'Version' => 1337,
                'MeasureValues' => [new MeasureValue([
                    'Name' => 'change me',
                    'Value' => 'change me',
                    'Type' => MeasureValueType::VARCHAR,
                ])],
            ]),
            'Records' => [new Record([
                'Dimensions' => [new Dimension([
                    'Name' => 'change me',
                    'Value' => 'change me',
                    'DimensionValueType' => DimensionValueType::VARCHAR,
                ])],
                'MeasureName' => 'change me',
                'MeasureValue' => 'change me',
                'MeasureValueType' => 'change me',
                'Time' => 'change me',
                'TimeUnit' => 'change me',
                'Version' => 1337,
                'MeasureValues' => [new MeasureValue([
                    'Name' => 'change me',
                    'Value' => 'change me',
                    'Type' => MeasureValueType::VARCHAR,
                ])],
            ])],
        ]);
        $result = $client->writeRecords($input);

        $result->resolve();

        // self::assertTODO(expected, $result->getRecordsIngested());
    }

    private function getClient(): TimestreamWriteClient
    {
        self::markTestSkipped('There is no Docker image for Timestream Write');

        return new TimestreamWriteClient([
            'endpoint' => 'http://localhost',
        ], new NullProvider());
    }
}
