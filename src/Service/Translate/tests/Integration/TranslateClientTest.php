<?php

namespace AsyncAws\Translate\Tests\Integration;

use AsyncAws\Core\Credentials\NullProvider;
use AsyncAws\Core\Test\TestCase;
use AsyncAws\Translate\Enum\Formality;
use AsyncAws\Translate\Enum\Profanity;
use AsyncAws\Translate\Input\TranslateTextRequest;
use AsyncAws\Translate\TranslateClient;
use AsyncAws\Translate\ValueObject\TranslationSettings;

class TranslateClientTest extends TestCase
{
    public function testTranslateText(): void
    {
        $client = $this->getClient();

        $input = new TranslateTextRequest([
            'Text' => 'Jag gillar glass',
            'SourceLanguageCode' => 'sv',
            'TargetLanguageCode' => 'en',
            'Settings' => new TranslationSettings([
                'Formality' => Formality::INFORMAL,
                'Profanity' => Profanity::MASK,
            ]),
        ]);
        $result = $client->translateText($input);

        $result->resolve();

        self::assertSame('I like ice cream', $result->getTranslatedText());
    }

    private function getClient(): TranslateClient
    {
        self::markTestSkipped('There is no Docker image for Translate');

        return new TranslateClient([
            'endpoint' => 'http://localhost',
        ], new NullProvider());
    }
}
