<?php

namespace Perimeterx;

abstract class PerimeterxRiskClient
{

    /**
     * @var PerimeterxContext
     */
    protected $pxCtx;

    /**
     * @var object - perimeterx configuration object
     */
    protected $pxConfig;

    /**
     * @var PerimeterxHttpClient
     */
    protected $httpClient;

    /**
     * @param $pxCtx PerimeterxContext - perimeterx context
     * @param $pxConfig array - perimeterx configurations
     */
    public function __construct($pxCtx, $pxConfig)
    {
        $this->pxCtx = $pxCtx;
        $this->pxConfig = $pxConfig;
        $this->httpClient = $pxConfig['http_client'];
    }

    /**
     * @return array
     */
    protected function formatHeaders()
    {
        $retval = [];
        foreach ($this->pxCtx->getHeaders() as $key => $value) {
            if (!in_array(strtolower($key), $this->pxConfig['sensitive_headers'])) {
                array_push($retval, ['name' => $key, 'value' => $value]);
            }
        }

        return $retval;
    }
}
