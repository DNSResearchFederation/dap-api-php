<?php


namespace DAP\API\Util;


use Kinikit\Core\DependencyInjection\Container;
use Kinikit\Core\HTTP\Dispatcher\HttpRequestDispatcher;
use Kinikit\Core\HTTP\HttpRequestErrorException;
use Kinikit\Core\HTTP\Request\Request;

class DAPProxy {

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $apiSecret;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var HttpRequestDispatcher
     */
    private $requestDispatcher;


    /**
     * DAPProxy constructor.
     * @param string $apiKey
     * @param string $apiSecret
     * @param string $endpoint
     */
    public function __construct($apiKey, $apiSecret, $endpoint) {
        $this->apikey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->endpoint = $endpoint;
        $this->requestDispatcher = Container::instance()->get(HttpRequestDispatcher::class);
    }


    /**
     * Call a DAP JSON api
     *
     * @param $path
     * @param string $methodType
     * @param null $payloadObject
     * @param array $queryParams
     *
     * @return mixed
     */
    public function callJSONApi($path, $methodType = Request::METHOD_GET, $payloadObject = null, $queryParams = []) {

        $queryParams["apiKey"] = $this->apikey;
        $queryParams["apiSecret"] = $this->apiSecret;

        $request = new Request($this->endpoint . "/" . $path, $methodType, $queryParams, json_encode($payloadObject));
        $response = $this->requestDispatcher->dispatch($request);

        $responseJSON = json_decode($response->getBody(), true);
        if ($response->getStatusCode() == 200) {
            return $responseJSON;
        } else {
            throw new HttpRequestErrorException($path, $response->getStatusCode(), $responseJSON["message"] ?? "Unknown error occurred");
        }
    }

}