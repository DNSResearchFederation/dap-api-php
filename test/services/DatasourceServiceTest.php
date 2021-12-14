<?php

namespace DAP\API\Test\Services;

use DAP\API\DAPAPI;
use DAP\API\Services\DatasourceService;
use DAP\API\Test\DAPAPITest;
use DAP\API\Util\DAPProxy;

class DatasourceServiceTest extends \PHPUnit\Framework\TestCase {


    /**
     * @var DatasourceService
     */
    private $datasourceService;


    /**
     * @var DAPProxy
     */
    private $proxy;

    /**
     * Set up the datasource service
     */
    public function setUp(): void {
        $api = new DAPAPI("TESTAPIKEY", "TESTAPISECRET", DAPAPITest::DEV_ENDPOINT);
        $this->datasourceService = $api->datasource();

        $this->proxy = new DAPProxy("TESTAPIKEY", "TESTAPISECRET", DAPAPITest::DEV_ENDPOINT);
    }

    public function testCanReadAddAndRemoveDataFromDatasource() {

        // Firstly read existing entries
        $results = $this->proxy->callJSONApi("api/datasource/evaluate", "POST", [
            "key" => "customers_1"
        ]);

        $this->assertEquals(0, sizeof($results["allData"]));

        $this->datasourceService->updateDatasourceInstance("customers_1", [
            [
                "name" => "Bob Jones",
                "age" => 13
            ],
            [
                "name" => "Mary Smith",
                "age" => 25
            ]
        ]);

        // Firstly read existing entries
        $results = $this->proxy->callJSONApi("api/datasource/evaluate", "POST", [
            "key" => "customers_1"
        ]);

        $this->assertEquals(2, sizeof($results["allData"]));
        $this->assertEquals("Bob Jones", $results["allData"][0]["name"]);


        $this->datasourceService->updateDatasourceInstance("customers_1", [
            [
                "id" => $results["allData"][0]["id"]
            ],
            [
                "id" => $results["allData"][1]["id"]
            ]
        ], "delete");


        // Firstly read existing entries
        $results = $this->proxy->callJSONApi("api/datasource/evaluate", "POST", [
            "key" => "customers_1"
        ]);

        $this->assertEquals(0, sizeof($results["allData"]));

    }

}