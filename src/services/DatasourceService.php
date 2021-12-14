<?php

namespace DAP\API\Services;

use DAP\API\Traits\DAPProxyService;
use Kinikit\Core\HTTP\Request\Request;

/**
 * Class Datasource
 */
class DatasourceService {

    use DAPProxyService;

    /**
     * Update a datasource instance with some new data
     *
     * @param $datasourceInstanceKey
     * @param $data
     * @param string $updateMode
     */
    public function updateDatasourceInstance($datasourceInstanceKey, $data, $updateMode = "add") {
        $this->dapProxy->callJSONApi("api/datasource/$datasourceInstanceKey",
            Request::METHOD_PUT, $data, [
                "updateMode" => $updateMode
            ]);
    }


}