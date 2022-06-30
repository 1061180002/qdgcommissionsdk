<?php
/**
 * FileName:Signer.php
 * Author:ZhangZhe
 * Email:1061180002@qq.com
 * Date:2022/6/29 0029
 * Time:16:10
 */
declare(strict_types=1);

namespace HuYingKeJi\Qdgcommissionsdk;

use HuYingKeJi\Qdgcommissionsdk\Exceptions\CommissionSdkSignException;

class Signer {

    public static function generateSign(array $body, string $secret): string {
        $str = "";
        foreach ($body as $key => $item) {
            $str .= $key . $item;
        }
        $str .= $secret;
        return strtolower(md5($str));
    }

    public static function checkSign(array $content, string $secret): bool {
        $array = $content;
        $sign = $array['sign'];
        unset($array["sign"]);
        ksort($array);
        $str = "";
        foreach ($array as $key => $val) {
            $str .= $key . $val;
        }
        $str .= $secret;
        $sig = strtoupper(md5($str));
        return $sign == $sig;
    }

    /**
     * RSA签名
     *
     * @param string $data 待签名数据
     * @param string $publicKey 公钥
     * @return string 检验结果
     * @throws \HuYingKeJi\Qdgcommissionsdk\Exceptions\CommissionSdkSignException
     *
     */
    public static function rsaEncode(string $data, string $publicKey): string {
       $isEncode = openssl_public_encrypt($data, $res, $publicKey);
        if (!$isEncode) {
            throw new CommissionSdkSignException("公钥加密错误");
        }
        return base64_encode($res);
    }

    /**
     * @param string $data
     * @param string $publicKey
     * @return mixed
     * @throws \HuYingKeJi\Qdgcommissionsdk\Exceptions\CommissionSdkSignException
     */
    public static function rsaDecode(string $data, string $publicKey) {
        $isDecode=  openssl_public_decrypt($data, $res, $publicKey);
        if (!$isDecode) {
            throw new CommissionSdkSignException("公钥解密错误");
        }
        return $res;
    }
}
