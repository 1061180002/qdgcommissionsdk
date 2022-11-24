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

		$pk = openssl_pkey_get_public(file_get_contents($publicKey));

		if (strlen($data) > 128) {
			$strArr = str_split($data, 128);
			$str = "";
			$i = 0;
			foreach ($strArr as $item) {
				openssl_public_encrypt($item, $encryptedData, $pk);
				if ($i != 0) {
					$str .= ".";
				}
				$str .= base64_encode($encryptedData);
				$i++;
			}
			return $str;
		} else {
			openssl_public_encrypt($data, $encryptedData, $pk);

			return base64_encode($encryptedData);
		}
	}

	/**
	 * @param string $data
	 * @param string $publicKey
	 * @return mixed
	 * @throws \HuYingKeJi\Qdgcommissionsdk\Exceptions\CommissionSdkSignException
	 */
	public static function rsaDecode(string $data, string $publicKey) {
		$pk = openssl_pkey_get_public(file_get_contents($publicKey));
		if (strpos($data, ".") !== false) {
			$strArr = explode(".", $data);
			$str = "";
			foreach ($strArr as $item) {
				openssl_public_decrypt(base64_decode($item), $encrypted, $pk);
				$str .= $encrypted;
			}
			return $str;
		} else {
			openssl_public_decrypt(base64_decode($data), $decrypted, $pk);
			return $decrypted;
		}
	}
}
