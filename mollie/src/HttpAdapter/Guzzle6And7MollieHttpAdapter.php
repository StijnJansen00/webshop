<?php

namespace Mollie\Api\HttpAdapter;

use _PhpScoper49d996c9b91b\Composer\CaBundle\CaBundle;
use _PhpScoper49d996c9b91b\GuzzleHttp\Client;
use _PhpScoper49d996c9b91b\GuzzleHttp\ClientInterface;
use _PhpScoper49d996c9b91b\GuzzleHttp\Exception\GuzzleException;
use _PhpScoper49d996c9b91b\GuzzleHttp\HandlerStack;
use _PhpScoper49d996c9b91b\GuzzleHttp\Psr7\Request;
use _PhpScoper49d996c9b91b\GuzzleHttp\RequestOptions as GuzzleRequestOptions;
use Mollie\Api\Exceptions\ApiException;
use _PhpScoper49d996c9b91b\Psr\Http\Message\ResponseInterface;
final class Guzzle6And7MollieHttpAdapter implements \Mollie\Api\HttpAdapter\MollieHttpAdapterInterface
{
    /**
     * Default response timeout (in seconds).
     */
    const DEFAULT_TIMEOUT = 10;
    /**
     * Default connect timeout (in seconds).
     */
    const DEFAULT_CONNECT_TIMEOUT = 2;
    /**
     * HTTP status code for an empty ok response.
     */
    const HTTP_NO_CONTENT = 204;
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;
    public function __construct(\_PhpScoper49d996c9b91b\GuzzleHttp\ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    /**
     * Instantiate a default adapter with sane configuration for Guzzle 6 or 7.
     *
     * @return static
     */
    public static function createDefault()
    {
        $retryMiddlewareFactory = new \Mollie\Api\HttpAdapter\Guzzle6And7RetryMiddlewareFactory();
        $handlerStack = \_PhpScoper49d996c9b91b\GuzzleHttp\HandlerStack::create();
        $handlerStack->push($retryMiddlewareFactory->retry());
        $client = new \_PhpScoper49d996c9b91b\GuzzleHttp\Client([\_PhpScoper49d996c9b91b\GuzzleHttp\RequestOptions::VERIFY => \_PhpScoper49d996c9b91b\Composer\CaBundle\CaBundle::getBundledCaBundlePath(), \_PhpScoper49d996c9b91b\GuzzleHttp\RequestOptions::TIMEOUT => self::DEFAULT_TIMEOUT, \_PhpScoper49d996c9b91b\GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => self::DEFAULT_CONNECT_TIMEOUT, 'handler' => $handlerStack]);
        return new \Mollie\Api\HttpAdapter\Guzzle6And7MollieHttpAdapter($client);
    }
    /**
     * Send a request to the specified Mollie api url.
     *
     * @param $httpMethod
     * @param $url
     * @param $headers
     * @param $httpBody
     * @return \stdClass|null
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function send($httpMethod, $url, $headers, $httpBody)
    {
        $request = new \_PhpScoper49d996c9b91b\GuzzleHttp\Psr7\Request($httpMethod, $url, $headers, $httpBody);
        try {
            $response = $this->httpClient->send($request, ['http_errors' => \false]);
        } catch (\_PhpScoper49d996c9b91b\GuzzleHttp\Exception\GuzzleException $e) {
            // Not all Guzzle Exceptions implement hasResponse() / getResponse()
            if (\method_exists($e, 'hasResponse') && \method_exists($e, 'getResponse')) {
                if ($e->hasResponse()) {
                    throw \Mollie\Api\Exceptions\ApiException::createFromResponse($e->getResponse(), $request);
                }
            }
            throw new \Mollie\Api\Exceptions\ApiException($e->getMessage(), $e->getCode(), null, $request, null);
        }
        if (!$response) {
            throw new \Mollie\Api\Exceptions\ApiException("Did not receive API response.", 0, null, $request);
        }
        return $this->parseResponseBody($response);
    }
    /**
     * Parse the PSR-7 Response body
     *
     * @param ResponseInterface $response
     * @return \stdClass|null
     * @throws ApiException
     */
    private function parseResponseBody(\_PhpScoper49d996c9b91b\Psr\Http\Message\ResponseInterface $response)
    {
        $body = (string) $response->getBody();
        if (empty($body)) {
            if ($response->getStatusCode() === self::HTTP_NO_CONTENT) {
                return null;
            }
            throw new \Mollie\Api\Exceptions\ApiException("No response body found.");
        }
        $object = @\json_decode($body);
        if (\json_last_error() !== \JSON_ERROR_NONE) {
            throw new \Mollie\Api\Exceptions\ApiException("Unable to decode Mollie response: '{$body}'.");
        }
        if ($response->getStatusCode() >= 400) {
            throw \Mollie\Api\Exceptions\ApiException::createFromResponse($response, null);
        }
        return $object;
    }
    /**
     * The version number for the underlying http client, if available. This is used to report the UserAgent to Mollie,
     * for convenient support.
     * @example Guzzle/6.3
     *
     * @return string|null
     */
    public function versionString()
    {
        if (\defined('\\GuzzleHttp\\ClientInterface::MAJOR_VERSION')) {
            // Guzzle 7
            return "Guzzle/" . \_PhpScoper49d996c9b91b\GuzzleHttp\ClientInterface::MAJOR_VERSION;
        } elseif (\defined('\\GuzzleHttp\\ClientInterface::VERSION')) {
            // Before Guzzle 7
            return "Guzzle/" . \_PhpScoper49d996c9b91b\GuzzleHttp\ClientInterface::VERSION;
        }
        return null;
    }
}
