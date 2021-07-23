<?php

require_once __DIR__ . '/vendor/autoload.php';

$conn = require_once __DIR__ . '/config/db.php';

$schema = new \Doctrine\DBAL\Schema\Schema();
$schemaManager = $conn->getSchemaManager();

if (!$schemaManager->tablesExist(['ads', 'ads_view'])) {

    $adsTable = $schema->createTable("ads");
    $id = $adsTable->addColumn("id", "integer", array("unsigned" => true));
    $id->setAutoincrement(true);
    $adsTable->addColumn("text", "text");
    $adsTable->addColumn("price", "integer", array("unsigned" => true));
    $adsTable->addColumn("limit", "integer", array("unsigned" => true));
    $adsTable->addColumn("banner", "string");
    $adsTable->addColumn("views_count", "integer", array("unsigned" => true));
    $adsTable->setPrimaryKey(array("id"));

    $adsViewTable = $schema->createTable("ads_view");
    $id = $adsViewTable->addColumn("id", "integer", array("unsigned" => true));
    $id->setAutoincrement(true);
    $adsViewTable->addColumn("ads_id", "integer");
    $adsViewTable->addColumn("view_date", "datetime");
    $adsViewTable->addForeignKeyConstraint($adsTable, array("ads_id"), array("id"));
    $adsViewTable->setPrimaryKey(array("id"));

    $sql = $schema->toSql($conn->getDatabasePlatform());

    foreach ($sql as $op) {
        $conn->executeQuery($op);
    }
}