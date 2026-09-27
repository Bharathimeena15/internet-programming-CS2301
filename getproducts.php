<?php

header("Content-Type: application/xml");

$xml = simplexml_load_file("products.xml");

echo $xml->asXML();

?>