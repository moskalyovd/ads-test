<?php

$connectionParams = array(
    'path' => __DIR__ . '/ads.db',
    'driver' => 'pdo_sqlite',
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);

return $conn;