<?php

declare(strict_types=1);

namespace AsyncAws\Core;

use AsyncAws\AppSync\AppSyncClient;
use AsyncAws\Athena\AthenaClient;
use AsyncAws\CloudFormation\CloudFormationClient;
use AsyncAws\CloudFront\CloudFrontClient;
use AsyncAws\CloudWatch\CloudWatchClient;
use AsyncAws\CloudWatchLogs\CloudWatchLogsClient;
use AsyncAws\CodeBuild\CodeBuildClient;
use AsyncAws\CodeCommit\CodeCommitClient;
use AsyncAws\CodeDeploy\CodeDeployClient;
use AsyncAws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use AsyncAws\Comprehend\ComprehendClient;
use AsyncAws\Core\Credentials\CacheProvider;
use AsyncAws\Core\Credentials\ChainProvider;
use AsyncAws\Core\Credentials\CredentialProvider;
use AsyncAws\Core\Exception\InvalidArgument;
use AsyncAws\Core\Exception\MissingDependency;
use AsyncAws\Core\Sts\StsClient;
use AsyncAws\DynamoDb\DynamoDbClient;
use AsyncAws\Ecr\EcrClient;
use AsyncAws\ElastiCache\ElastiCacheClient;
use AsyncAws\EventBridge\EventBridgeClient;
use AsyncAws\Firehose\FirehoseClient;
use AsyncAws\Iam\IamClient;
use AsyncAws\Iot\IotClient;
use AsyncAws\IotData\IotDataClient;
use AsyncAws\Kinesis\KinesisClient;
use AsyncAws\Kms\KmsClient;
use AsyncAws\Lambda\LambdaClient;
use AsyncAws\LocationService\LocationServiceClient;
use AsyncAws\MediaConvert\MediaConvertClient;
use AsyncAws\RdsDataService\RdsDataServiceClient;
use AsyncAws\Rekognition\RekognitionClient;
use AsyncAws\Route53\Route53Client;
use AsyncAws\S3\S3Client;
use AsyncAws\Scheduler\SchedulerClient;
use AsyncAws\SecretsManager\SecretsManagerClient;
use AsyncAws\Ses\SesClient;
use AsyncAws\Sns\SnsClient;
use AsyncAws\Sqs\SqsClient;
use AsyncAws\Ssm\SsmClient;
use AsyncAws\Sso\SsoClient;
use AsyncAws\StepFunctions\StepFunctionsClient;
use AsyncAws\TimestreamQuery\TimestreamQueryClient;
use AsyncAws\TimestreamWrite\TimestreamWriteClient;
use AsyncAws\Translate\TranslateClient;
use AsyncAws\XRay\XRayClient;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Factory that instantiate API clients.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class AwsClientFactory
{
    /**
     * @var array<string, mixed>
     * @psalm-var class-string-map<T as AbstractApi, T>
     */
    private $serviceCache;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var CredentialProvider
     */
    private $credentialProvider;

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * @param Configuration|array<Configuration::OPTION_*, string|null> $configuration
     */
    public function __construct($configuration = [], ?CredentialProvider $credentialProvider = null, ?HttpClientInterface $httpClient = null, ?LoggerInterface $logger = null)
    {
        if (\is_array($configuration)) {
            $configuration = Configuration::create($configuration);
        } elseif (!$configuration instanceof Configuration) {
            throw new InvalidArgument(sprintf('Second argument to "%s::__construct()" must be an array or an instance of "%s"', __CLASS__, Configuration::class));
        }

        $this->httpClient = $httpClient ?? HttpClient::create();
        $this->logger = $logger ?? new NullLogger();
        $this->configuration = $configuration;
        $this->credentialProvider = $credentialProvider ?? new CacheProvider(ChainProvider::createDefaultChain($this->httpClient, $this->logger));
    }

    public function appSync(): AppSyncClient
    {
        if (!class_exists(AppSyncClient::class)) {
            throw MissingDependency::create('async-aws/app-sync', 'AppSync');
        }

        if (!isset($this->serviceCache[AppSyncClient::class])) {
            $this->serviceCache[AppSyncClient::class] = new AppSyncClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[AppSyncClient::class];
    }

    public function cloudFormation(): CloudFormationClient
    {
        if (!class_exists(CloudFormationClient::class)) {
            throw MissingDependency::create('async-aws/cloud-formation', 'CloudFormation');
        }

        if (!isset($this->serviceCache[CloudFormationClient::class])) {
            $this->serviceCache[CloudFormationClient::class] = new CloudFormationClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[CloudFormationClient::class];
    }

    public function cloudFront(): CloudFrontClient
    {
        if (!class_exists(CloudFrontClient::class)) {
            throw MissingDependency::create('async-aws/cloud-front', 'CloudFront');
        }

        if (!isset($this->serviceCache[CloudFrontClient::class])) {
            $this->serviceCache[CloudFrontClient::class] = new CloudFrontClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[CloudFrontClient::class];
    }

    public function cloudWatch(): CloudWatchClient
    {
        if (!class_exists(CloudWatchClient::class)) {
            throw MissingDependency::create('async-aws/cloud-watch', 'CloudWatch');
        }

        if (!isset($this->serviceCache[CloudWatchClient::class])) {
            $this->serviceCache[CloudWatchClient::class] = new CloudWatchClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[CloudWatchClient::class];
    }

    public function cloudWatchLogs(): CloudWatchLogsClient
    {
        if (!class_exists(CloudWatchLogsClient::class)) {
            throw MissingDependency::create('async-aws/cloud-watch-logs', 'CloudWatchLogs');
        }

        if (!isset($this->serviceCache[CloudWatchLogsClient::class])) {
            $this->serviceCache[CloudWatchLogsClient::class] = new CloudWatchLogsClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[CloudWatchLogsClient::class];
    }

    public function codeBuild(): CodeBuildClient
    {
        if (!class_exists(CodeBuildClient::class)) {
            throw MissingDependency::create('async-aws/code-build', 'CodeBuild');
        }

        if (!isset($this->serviceCache[CodeBuildClient::class])) {
            $this->serviceCache[CodeBuildClient::class] = new CodeBuildClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[CodeBuildClient::class];
    }

    public function codeCommit(): CodeCommitClient
    {
        if (!class_exists(CodeCommitClient::class)) {
            throw MissingDependency::create('async-aws/code-commit', 'CodeCommit');
        }

        if (!isset($this->serviceCache[CodeCommitClient::class])) {
            $this->serviceCache[CodeCommitClient::class] = new CodeCommitClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[CodeCommitClient::class];
    }

    public function codeDeploy(): CodeDeployClient
    {
        if (!class_exists(CodeDeployClient::class)) {
            throw MissingDependency::create('async-aws/code-deploy', 'CodeDeploy');
        }

        if (!isset($this->serviceCache[CodeDeployClient::class])) {
            $this->serviceCache[CodeDeployClient::class] = new CodeDeployClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[CodeDeployClient::class];
    }

    public function comprehend(): ComprehendClient
    {
        if (!class_exists(ComprehendClient::class)) {
            throw MissingDependency::create('async-aws/comprehend', 'ComprehendClient');
        }

        if (!isset($this->serviceCache[ComprehendClient::class])) {
            $this->serviceCache[ComprehendClient::class] = new ComprehendClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[ComprehendClient::class];
    }

    public function dynamoDb(): DynamoDbClient
    {
        if (!class_exists(DynamoDbClient::class)) {
            throw MissingDependency::create('async-aws/dynamo-db', 'DynamoDb');
        }

        if (!isset($this->serviceCache[DynamoDbClient::class])) {
            $this->serviceCache[DynamoDbClient::class] = new DynamoDbClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[DynamoDbClient::class];
    }

    public function ecr(): EcrClient
    {
        if (!class_exists(EcrClient::class)) {
            throw MissingDependency::create('async-aws/ecr', 'ECR');
        }

        if (!isset($this->serviceCache[EcrClient::class])) {
            $this->serviceCache[EcrClient::class] = new EcrClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[EcrClient::class];
    }

    public function elastiCache(): ElastiCacheClient
    {
        if (!class_exists(ElastiCacheClient::class)) {
            throw MissingDependency::create('async-aws/elasti-cache', 'ElastiCache');
        }

        if (!isset($this->serviceCache[ElastiCacheClient::class])) {
            $this->serviceCache[ElastiCacheClient::class] = new ElastiCacheClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[ElastiCacheClient::class];
    }

    public function eventBridge(): EventBridgeClient
    {
        if (!class_exists(EventBridgeClient::class)) {
            throw MissingDependency::create('async-aws/event-bridge', 'EventBridge');
        }

        if (!isset($this->serviceCache[EventBridgeClient::class])) {
            $this->serviceCache[EventBridgeClient::class] = new EventBridgeClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[EventBridgeClient::class];
    }

    public function firehose(): FirehoseClient
    {
        if (!class_exists(FirehoseClient::class)) {
            throw MissingDependency::create('async-aws/firehose', 'Firehose');
        }

        if (!isset($this->serviceCache[FirehoseClient::class])) {
            $this->serviceCache[FirehoseClient::class] = new FirehoseClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[FirehoseClient::class];
    }

    public function iam(): IamClient
    {
        if (!class_exists(IamClient::class)) {
            throw MissingDependency::create('async-aws/iam', 'IAM');
        }

        if (!isset($this->serviceCache[IamClient::class])) {
            $this->serviceCache[IamClient::class] = new IamClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[IamClient::class];
    }

    public function iot(): IotClient
    {
        if (!class_exists(IotClient::class)) {
            throw MissingDependency::create('async-aws/iot', 'Iot');
        }

        if (!isset($this->serviceCache[IotClient::class])) {
            $this->serviceCache[IotClient::class] = new IotClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[IotClient::class];
    }

    public function iotData(): IotDataClient
    {
        if (!class_exists(IotDataClient::class)) {
            throw MissingDependency::create('async-aws/iot-data', 'IotData');
        }

        if (!isset($this->serviceCache[IotDataClient::class])) {
            $this->serviceCache[IotDataClient::class] = new IotDataClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[IotDataClient::class];
    }

    public function kinesis(): KinesisClient
    {
        if (!class_exists(KinesisClient::class)) {
            throw MissingDependency::create('aws/kinesis', 'Kinesis');
        }

        if (!isset($this->serviceCache[KinesisClient::class])) {
            $this->serviceCache[KinesisClient::class] = new KinesisClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[KinesisClient::class];
    }

    public function kms(): KmsClient
    {
        if (!class_exists(KmsClient::class)) {
            throw MissingDependency::create('aws/kms', 'Kms');
        }

        if (!isset($this->serviceCache[KmsClient::class])) {
            $this->serviceCache[KmsClient::class] = new KmsClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[KmsClient::class];
    }

    public function lambda(): LambdaClient
    {
        if (!class_exists(LambdaClient::class)) {
            throw MissingDependency::create('async-aws/lambda', 'Lambda');
        }

        if (!isset($this->serviceCache[LambdaClient::class])) {
            $this->serviceCache[LambdaClient::class] = new LambdaClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[LambdaClient::class];
    }

    public function locationService(): LocationServiceClient
    {
        if (!class_exists(LocationServiceClient::class)) {
            throw MissingDependency::create('async-aws/location-service', 'LocationService');
        }

        if (!isset($this->serviceCache[LocationServiceClient::class])) {
            $this->serviceCache[LocationServiceClient::class] = new LocationServiceClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[LocationServiceClient::class];
    }

    public function mediaConvert(): MediaConvertClient
    {
        if (!class_exists(MediaConvertClient::class)) {
            throw MissingDependency::create('async-aws/media-convert', 'MediaConvert');
        }

        if (!isset($this->serviceCache[MediaConvertClient::class])) {
            $this->serviceCache[MediaConvertClient::class] = new MediaConvertClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[MediaConvertClient::class];
    }

    public function rdsDataService(): RdsDataServiceClient
    {
        if (!class_exists(RdsDataServiceClient::class)) {
            throw MissingDependency::create('async-aws/rds-data-service', 'RdsDataService');
        }

        if (!isset($this->serviceCache[RdsDataServiceClient::class])) {
            $this->serviceCache[RdsDataServiceClient::class] = new RdsDataServiceClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[RdsDataServiceClient::class];
    }

    public function rekognition(): RekognitionClient
    {
        if (!class_exists(RekognitionClient::class)) {
            throw MissingDependency::create('aws/rekognition', 'Rekognition');
        }

        if (!isset($this->serviceCache[RekognitionClient::class])) {
            $this->serviceCache[RekognitionClient::class] = new RekognitionClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[RekognitionClient::class];
    }

    public function route53(): Route53Client
    {
        if (!class_exists(Route53Client::class)) {
            throw MissingDependency::create('aws/route53', 'Route53');
        }

        if (!isset($this->serviceCache[Route53Client::class])) {
            $this->serviceCache[Route53Client::class] = new Route53Client($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[Route53Client::class];
    }

    public function s3(): S3Client
    {
        if (!class_exists(S3Client::class)) {
            throw MissingDependency::create('async-aws/s3', 'S3');
        }

        if (!isset($this->serviceCache[S3Client::class])) {
            $this->serviceCache[S3Client::class] = new S3Client($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[S3Client::class];
    }

    public function scheduler(): SchedulerClient
    {
        if (!class_exists(SchedulerClient::class)) {
            throw MissingDependency::create('async-aws/scheduler', 'Scheduler');
        }

        if (!isset($this->serviceCache[SchedulerClient::class])) {
            $this->serviceCache[SchedulerClient::class] = new SchedulerClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[SchedulerClient::class];
    }

    public function secretsManager(): SecretsManagerClient
    {
        if (!class_exists(SecretsManagerClient::class)) {
            throw MissingDependency::create('async-aws/secret-manager', 'SecretsManager');
        }

        if (!isset($this->serviceCache[SecretsManagerClient::class])) {
            $this->serviceCache[SecretsManagerClient::class] = new SecretsManagerClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[SecretsManagerClient::class];
    }

    public function ses(): SesClient
    {
        if (!class_exists(SesClient::class)) {
            throw MissingDependency::create('async-aws/ses', 'SES');
        }

        if (!isset($this->serviceCache[SesClient::class])) {
            $this->serviceCache[SesClient::class] = new SesClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[SesClient::class];
    }

    public function sns(): SnsClient
    {
        if (!class_exists(SnsClient::class)) {
            throw MissingDependency::create('async-aws/sns', 'SNS');
        }

        if (!isset($this->serviceCache[SnsClient::class])) {
            $this->serviceCache[SnsClient::class] = new SnsClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[SnsClient::class];
    }

    public function sqs(): SqsClient
    {
        if (!class_exists(SqsClient::class)) {
            throw MissingDependency::create('async-aws/sqs', 'SQS');
        }

        if (!isset($this->serviceCache[SqsClient::class])) {
            $this->serviceCache[SqsClient::class] = new SqsClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[SqsClient::class];
    }

    public function ssm(): SsmClient
    {
        if (!class_exists(SsmClient::class)) {
            throw MissingDependency::create('async-aws/ssm', 'SSM');
        }

        if (!isset($this->serviceCache[SsmClient::class])) {
            $this->serviceCache[SsmClient::class] = new SsmClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[SsmClient::class];
    }

    public function sso(): SsoClient
    {
        if (!isset($this->serviceCache[SsoClient::class])) {
            $this->serviceCache[SsoClient::class] = new SsoClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[SsoClient::class];
    }

    public function sts(): StsClient
    {
        if (!isset($this->serviceCache[StsClient::class])) {
            $this->serviceCache[StsClient::class] = new StsClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[StsClient::class];
    }

    public function stepFunctions(): StepFunctionsClient
    {
        if (!class_exists(StepFunctionsClient::class)) {
            throw MissingDependency::create('async-aws/step-functions', 'StepFunctions');
        }

        if (!isset($this->serviceCache[StepFunctionsClient::class])) {
            $this->serviceCache[StepFunctionsClient::class] = new StepFunctionsClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[StepFunctionsClient::class];
    }

    public function timestreamQuery(): TimestreamQueryClient
    {
        if (!class_exists(TimestreamQueryClient::class)) {
            throw MissingDependency::create('async-aws/timestream-query', 'TimestreamQuery');
        }

        if (!isset($this->serviceCache[TimestreamQueryClient::class])) {
            $this->serviceCache[TimestreamQueryClient::class] = new TimestreamQueryClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[TimestreamQueryClient::class];
    }

    public function timestreamWrite(): TimestreamWriteClient
    {
        if (!class_exists(TimestreamWriteClient::class)) {
            throw MissingDependency::create('async-aws/timestream-write', 'TimestreamWrite');
        }

        if (!isset($this->serviceCache[TimestreamWriteClient::class])) {
            $this->serviceCache[TimestreamWriteClient::class] = new TimestreamWriteClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[TimestreamWriteClient::class];
    }

    public function translate(): TranslateClient
    {
        if (!class_exists(TranslateClient::class)) {
            throw MissingDependency::create('async-aws/translate', 'Translate');
        }

        if (!isset($this->serviceCache[TranslateClient::class])) {
            $this->serviceCache[TranslateClient::class] = new TranslateClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[TranslateClient::class];
    }

    public function xRay(): XRayClient
    {
        if (!class_exists(XRayClient::class)) {
            throw MissingDependency::create('async-aws/x-ray', 'XRay');
        }

        if (!isset($this->serviceCache[XRayClient::class])) {
            $this->serviceCache[XRayClient::class] = new XRayClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[XRayClient::class];
    }

    public function cognitoIdentityProvider(): CognitoIdentityProviderClient
    {
        if (!class_exists(CognitoIdentityProviderClient::class)) {
            throw MissingDependency::create('aws/cognito-identity-provider', 'CognitoIdentityProvider');
        }

        if (!isset($this->serviceCache[CognitoIdentityProviderClient::class])) {
            $this->serviceCache[CognitoIdentityProviderClient::class] = new CognitoIdentityProviderClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[CognitoIdentityProviderClient::class];
    }

    public function athena(): AthenaClient
    {
        if (!class_exists(AthenaClient::class)) {
            throw MissingDependency::create('async-aws/athena', 'Athena');
        }

        if (!isset($this->serviceCache[AthenaClient::class])) {
            $this->serviceCache[AthenaClient::class] = new AthenaClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }

        return $this->serviceCache[AthenaClient::class];
    }
}
