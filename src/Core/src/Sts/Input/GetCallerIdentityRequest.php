<?php

namespace AsyncAws\Core\Sts\Input;

class GetCallerIdentityRequest
{
    public static function create($input): self
    {
        return $input instanceof self ? $input : new self();
    }

    /**
     * @internal
     */
    public function requestBody(): string
    {
        $payload = ['Action' => 'GetCallerIdentity', 'Version' => '2011-06-15'];

        return http_build_query($payload, '', '&', \PHP_QUERY_RFC1738);
    }

    /**
     * @internal
     */
    public function requestHeaders(): array
    {
        $headers = ['content-type' => 'application/x-www-form-urlencoded'];

        return $headers;
    }

    /**
     * @internal
     */
    public function requestQuery(): array
    {
        $query = [];

        return $query;
    }

    /**
     * @internal
     */
    public function requestUri(): string
    {
        return '/';
    }

    public function validate(): void
    {
        // There are no required properties
    }
}
