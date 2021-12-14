<?php

namespace DAP\API;

use DAP\API\Services\DatasourceService;
use DAP\API\Util\DAPProxy;
use Kinikit\Core\HTTP\HttpRequestErrorException;


class DAPAPI {

    /**
     * @var DAPProxy
     */
    private $dapProxy;

    /**
     * @var DatasourceService
     */
    private $datasourceService;

    // Production endpoint
    const PRODUCTION_ENDPOINT = "https://webservices.dap.live";

    /**
     * DAPAPI constructor.
     * @param string $apiKey
     * @param string $apiSecret
     * @param string $endpoint
     */
    public function __construct($apiKey, $apiSecret, $endpoint = self::PRODUCTION_ENDPOINT) {
        $this->dapProxy = new DAPProxy($apiKey, $apiSecret, $endpoint);
    }

    /**
     * Ping the API, should return true if credentials valid
     */
    public function ping() {
        try {
            $this->dapProxy->callJSONApi("api/ping");
            return true;
        } catch (HttpRequestErrorException $e) {
            return false;
        }
    }

    /**
     * Return singleton datasource service
     *
     * @return DatasourceService
     */
    public function datasource() {
        if (!$this->datasourceService)
            $this->datasourceService = new DatasourceService($this->dapProxy);

        return $this->datasourceService;
    }

}