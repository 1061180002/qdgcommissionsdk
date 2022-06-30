<?php

require_once __DIR__ . "/../vendor/autoload.php";

use HuYingKeJi\Qdgcommissionsdk\Apis\CommissionSubmitItemRequest;
use HuYingKeJi\Qdgcommissionsdk\Apis\CommissionSubmitRequest;
use HuYingKeJi\Qdgcommissionsdk\CommissionSdkClient;
use HuYingKeJi\Qdgcommissionsdk\Exceptions\CommissionSdkHttpException;
use HuYingKeJi\Qdgcommissionsdk\Exceptions\CommissionSdkSignException;

$pubStr = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwOAVl98tVw+Sua3AD7mq
qz8GwO2z5VZPIhT353sP2EVWUqbcRaqc6Of4h1qj4fhpHaVyNdhM2EWT34hHtaK6
kwaiSKkrv9kkCf0F/O7v2JOkeIP93thOpBiSUXxxV2lUiZyN90ywK/GRnJmij+Qz
fDpPSn7xgMw1mL+rsYZTiy2TUR/xHcIk4x54BX6wMVeZ1lzTM1AFbNklq5tO6gSo
QqsEudw4TmXZwhUmbarI0e1cILMYjPcOSZel1xdcrGdFl16tjcyw60FfSm5WsTQr
af
-----END PUBLIC KEY-----
";
$commissionSdkClient = new CommissionSdkClient("qasd", "sadasd4", $pubStr);
$commissionSubmitRequest = new CommissionSubmitRequest();
$commissionSubmitRequest->setCommissionSubmitItemRequest(new CommissionSubmitItemRequest(10, "osapoda", "面筋"));
$resp = $commissionSdkClient->execute($commissionSubmitRequest);
var_dump($resp);

