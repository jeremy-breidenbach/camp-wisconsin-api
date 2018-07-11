<?php

namespace App\Libraries;

use GuzzleHttp\Client;

class XmlRequest
{
    function getApiXml($baseUri, $params)
    {
        $client = new Client(['base_uri' => $baseUri, 'delay' => 500]);
        $response = $client->request('GET', $params);
        $body = (string) $response->getBody();
        return $xml = simplexml_load_string($body);
    }
}
