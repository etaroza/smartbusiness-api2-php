<?php
    declare(strict_types=1);

    use LourensSystems\ApiWrapper\OAuth2\Client\Provider\Provider;
    use smartbusiness\api2\Endpoints\EndpointStrategy;

    if (!isset($_ENV['CLIENT_ID']) || !isset($_ENV['CLIENT_SECRET'])) {
        throw new Exception('Client-ID or/and secret not available from environment variables. Maybe you forgot to pass them, or php is not receiving them.');
    }

    return new Provider(
        [
            'clientId'     => $_ENV['CLIENT_ID'], // The client ID assigned to you by the provider
            'clientSecret' => $_ENV['CLIENT_SECRET'], // The client password assigned to you by the provider
            'baseUrl'      => isset($_ENV['STAGING']) ? EndpointStrategy::getApiURLStaging() : EndpointStrategy::getApiURLProduction(),
        ]);