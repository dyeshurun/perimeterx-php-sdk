<?php
namespace Perimeterx\Tests\Fixtures;

use Perimeterx\PerimeterxContext;
use GuzzleHttp\Client;

class PerimeterxContextBadCookie extends PerimeterxContext
{
    /**
     * PerimeterxContextGoodCookie constructor.
     */
    public function __construct()
    {
        $ua = 'PhantomJS';
        $url = 'http://www.perimeterx.com/';
        $this->headers = [
            ['name' => 'user-agent', 'value' => $ua],
            ['name' => 'origin', 'value' => 'http://www.perimeterx.com/']
        ];
        $this->hostname = 'perimeterx.com';
        $this->userAgent = $ua;
        $this->uri = '/';
        $this->full_url = $url;
        $this->ip = PX_LOCAL_IP_ADDR;
        $this->px_cookie = $this->fetchCookie($ua);
    }

    private function fetchCookie($ua)
    {
        $httpclient = new Client(['base_uri' => PX_SERVER_URL]);
        $headers = [
            'Origin' => 'http://localhost/',
            'User-Agent' => $ua,
            'Content-type' => 'application/x-www-form-urlencoded'
        ];
        
        $rawResponse = $httpclient->request('POST', '/api/v1/collector', ['body' => PX_ACTIVITY_PAYLOAD, 'headers' => $headers]);
        $response = json_decode($rawResponse->getBody());
        fwrite(STDOUT, var_dump($response));
        return explode("|", $response->do[1])[3];
    }
}