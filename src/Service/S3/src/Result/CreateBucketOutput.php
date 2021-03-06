<?php

namespace AsyncAws\S3\Result;

use AsyncAws\Core\Response;
use AsyncAws\Core\Result;

class CreateBucketOutput extends Result
{
    /**
     * Specifies the Region where the bucket will be created. If you are creating a bucket on the US East (N. Virginia)
     * Region (us-east-1), you do not need to specify the location.
     */
    private $Location;

    public function getLocation(): ?string
    {
        $this->initialize();

        return $this->Location;
    }

    protected function populateResult(Response $response): void
    {
        $headers = $response->getHeaders();

        $this->Location = $headers['location'][0] ?? null;
    }
}
