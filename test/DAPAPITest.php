<?php

namespace DAP\API\Test;

use DAP\API\DAPAPI;

include_once "autoloader.php";

class DAPAPITest extends \PHPUnit\Framework\TestCase {

    const DEV_ENDPOINT = "http://127.0.0.1:3055";

    public function testPingReturnsBooleanAccordingToValidAPIKeyAndSecret() {

        $dapAPI = new DAPAPI("BADKEY", "BADSECRET", self::DEV_ENDPOINT);
        $this->assertFalse($dapAPI->ping());

        $dapAPI = new DAPAPI("TESTAPIKEY", "TESTAPISECRET", self::DEV_ENDPOINT);
        $this->assertTrue($dapAPI->ping());

    }


}