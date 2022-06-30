<?php
/**
 * FileName:QdgCommissionClient.php
 * Author:ZhangZhe
 * Email:1061180002@qq.com
 * Date:2022/6/30 0030
 * Time:9:38
 */
declare(strict_types=1);

namespace HuYingKeJi\Qdgcommissionsdk;

class CommissionSdkClient {
    private string $appKey;
    private string $secret;
    private string $userAgent = "qdg-commission-sdk:1.0.0";
    private string $host = "https://api.qudaogo.com/api";
    private int $timestamp;
    private string $publicKey;

    /**
     * @param string $appKey key | appid
     * @param string $appSecret secret
     */
    public function __construct(string $appKey, string $appSecret, string $publicKey) {
        $this->appKey = $appKey;
        $this->secret = $appSecret;
        $this->timestamp = time();
        $this->publicKey = $publicKey;
    }

    /**
     * @param \HuYingKeJi\Qdgcommissionsdk\CommissionReqInterface $commissionReq
     * @return bool|string
     * @throws \HuYingKeJi\Qdgcommissionsdk\Exceptions\CommissionSdkSignException|\HuYingKeJi\Qdgcommissionsdk\Exceptions\CommissionSdkHttpException
     */
    public function execute(CommissionReqInterface $commissionReq) {

        $bodySign = Signer::rsaEncode(json_encode($commissionReq->getApiParams()), $this->publicKey);
        $sign = md5($bodySign . $this->secret);
        $header = [
            "Content-Type" => "application/json;charset=utf-8",
            "Accept"       => "application/json",
            "User-Agent"   => $this->userAgent,
            "Timestamp"    => $this->timestamp,
            "Appid"        => $this->appKey,
            "Sign"         => $sign,
        ];
        if ("get" === strtolower($commissionReq->getHttpMethod())) {
            $resp = Http::httpGet(
                $this->host . "/" . ltrim($commissionReq->getUri(), "/"),
                ["data" => $bodySign],
                $header
            );
        } else {

            $resp = Http::httpPost(
                $this->host . "/" . ltrim($commissionReq->getUri(), "/"),
                ["data" => $bodySign],
                $header
            );
        }
        return $resp;
    }

}
