<?php
namespace CybSource;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/autoload.php';

interface ConnectionHeaders
{
    public function httpParseHeaders($raw_headers);
    public function getConnection($signature, $resourcePath, $postData, $method, $merchantConfig);
}

?>