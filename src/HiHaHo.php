<?php

namespace Vdhicts\HiHaHo;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\Response;
use Vdhicts\HiHaHo\Endpoints\VideoContainerEndpoint;
use Vdhicts\HiHaHo\Endpoints\VideoEndpoint;

class HiHaHo extends Factory
{
    use VideoEndpoint;
    use VideoContainerEndpoint;

    private const TIMEOUT = 180;
    private const VERSION = '2.0.0';
    private const USER_AGENT = 'vdhicts-hihaho-api-client/' . self::VERSION;

    protected Configuration $configuration;
    protected array $defaultOptions = [];

    public function __construct(Configuration $configuration)
    {
        parent::__construct();

        $this->configuration = $configuration;

        $this->defaultOptions = [
            'base_uri' => $this->configuration->getUrl(),
            'timeout' => self::TIMEOUT,
            'headers' => [
                'User-Agent' => self::USER_AGENT,
                'Accept' => 'application/json',
            ],
        ];
    }

    private function login(): Response
    {
        $data = [
            'grant_type' => $this->configuration->hasRefreshToken()
                ? 'refresh_token'
                : 'password',
            'client_id' => $this->configuration->getClientId(),
            'client_secret' => $this->configuration->getClientSecret(),
        ];
        if ($this->configuration->hasRefreshToken()) {
            $data['refresh_token'] = $this->configuration->getRefreshToken();
        } else {
            $data['username'] = $this->configuration->getUsername();
            $data['password'] = $this->configuration->getPassword();
        }

        return $this->post('oauth/access_token', $data);
    }

    public function getAccessToken(): ?string
    {
        // When an access token is already provided, skip authentication
        if ($this->configuration->hasAccessToken()) {
            return $this
                ->configuration
                ->getAccessToken();
        }

        $response = $this->login();
        if ($response->failed()) {
            return null;
        }

        $this
            ->configuration
            ->setAccessToken($response->object()->access_token)
            ->setRefreshToken($response->object()->refresh_token);

        return $this
            ->configuration
            ->getAccessToken();
    }

    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        // Override this to include the default options
        return tap($this->newPendingRequest(), function ($request) {
            $request
                ->withOptions($this->defaultOptions)
                ->stub($this->stubCallbacks);
        })->{$method}(...$parameters);
    }
}