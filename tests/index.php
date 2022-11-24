<?php

require_once __DIR__ . "/../vendor/autoload.php";

use HuYingKeJi\Qdgcommissionsdk\Apis\CommissionSubmitItemRequest;
use HuYingKeJi\Qdgcommissionsdk\Apis\CommissionSubmitRequest;
use HuYingKeJi\Qdgcommissionsdk\CommissionSdkClient;

$commissionSdkClient = new CommissionSdkClient("qdgf2a6bd1f67cdd3b4", "sadasd4", file_get_contents(__DIR__."/pub.pem"));
$commissionSubmitRequest = new CommissionSubmitRequest();
$commissionSubmitRequest->setCommissionSubmitItemRequest(new CommissionSubmitItemRequest(10, "osapoda", "面筋"));
$resp = $commissionSdkClient->execute($commissionSubmitRequest);
var_dump($resp);

