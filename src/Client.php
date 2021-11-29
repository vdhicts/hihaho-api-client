<?php

namespace Vdhicts\HiHaHo;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use Vdhicts\HiHaHo\Contracts\Client as ClientContract;
use Vdhicts\HiHaHo\Contracts\Response as ResponseContract;
use Vdhicts\HiHaHo\Contracts\Request as RequestContract;

class Client implements ClientContract
{
    private const CONNECT_TIMEOUT = 60;
    private const TIMEOUT = 180;
    private const VERSION = '1.0.0';
    private const USER_AGENT = 'vdhicts-hihaho-api-client/' . self::VERSION;

    private Configuration $configuration;
    private GuzzleClient $httpClient;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;

        $this->httpClient = new GuzzleClient([
            'base_uri' => $this
                ->configuration
                ->getUrl(),
            'timeout' => self::TIMEOUT,
            'connect_timeout' => self::CONNECT_TIMEOUT,
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json',
                'User-Agent' => self::USER_AGENT,
            ]
        ]);
    }

    private function authenticate(): bool
    {
        // When an access token is already provided, skip authentication
        if ($this->configuration->hasAccessToken()) {
            return true;
        }

        $request = (new Request(Request::METHOD_POST, 'oauth/access_token'))
            ->setAuthenticationRequired(false);
        $this->configuration->hasRefreshToken()
            ? $request->setBody([
                'grant_type' => 'refresh_token',
                'client_id' => $this->configuration->getClientId(),
                'client_secret' => $this->configuration->getClientSecret(),
                'refresh_token' => $this->configuration->getRefreshToken(),
            ])
            : $request->setBody([
                'grant_type' => 'password',
                'client_id' => $this->configuration->getClientId(),
                'client_secret' => $this->configuration->getClientSecret(),
                'username' => $this->configuration->getUsername(),
                'password' => $this->configuration->getPassword(),
            ]);

        $response = $this->perform($request);
        if (!$response->isSuccess()) {
            return false;
        }

        $this
            ->configuration
            ->setAccessToken($response->getData('access_token'))
            ->setRefreshToken($response->getData('refresh_token'));

        return true;
    }

    private function getRequestOptions(RequestContract $request): array
    {
        $requestOptions = [];
        if (count($request->getBody()) !== 0) {
            if ($request->getMethod() === RequestContract::METHOD_GET) {
                $requestOptions['query'] = $request->getBody();
            } else {
                $requestOptions['json'] = $request->getBody();
            }
        }

        if ($request->authenticationRequired()) {
            $requestOptions['headers'] = [
                'Authorization' => sprintf(
                    'Bearer %s',
                    $this
                        ->configuration
                        ->getAccessToken()
                ),
            ];
        }

        return $requestOptions;
    }

    public function perform(RequestContract $request): ResponseContract
    {
        if ($request->authenticationRequired() && !$this->authenticate()) {
            return (new Response(Response::ERROR))
                ->setError('Authentication required but authentication failed');
        }

        try {
            $httpResponse = $this
                ->httpClient
                ->request($request->getMethod(), $request->getUrl(), $this->getRequestOptions($request));
        } catch (GuzzleException $exception) {
            return (new Response(Response::ERROR))
                ->setError($exception->getMessage());
        }

        $data = json_decode((string)$httpResponse->getBody(), true);

        if ($httpResponse->getStatusCode() >= 400) {
            return (new Response(Response::ERROR))
                ->setError(Arr::get($data, 'message', $httpResponse->getReasonPhrase()));
        }

        return new Response(Response::SUCCESS, $data);
    }
}