<?php

namespace DAP\API\Traits;

use DAP\API\Util\DAPProxy;

/**
 *
 *
 * Class DAPProxyService
 *
 */
trait DAPProxyService {

    /**
     * @var DAPProxy
     */
    protected $dapProxy;

    /**
     * DAPProxyService constructor.
     *
     * @param DAPProxy $dapProxy
     */
    public function __construct($dapProxy) {
        $this->dapProxy = $dapProxy;
    }


}