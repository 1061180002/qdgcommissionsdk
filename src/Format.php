<?php
/**
 * FileName:Format.php
 * Author:ZhangZhe
 * Email:1061180002@qq.com
 * Date:2022/6/29 0029
 * Time:16:10
 */
declare(strict_types=1);

namespace HuYingKeJi\Qdgcommissionsdk;

class Format {

    public static function jsonDecode(string $jsonStr, $option = null) {
        return \json_decode($jsonStr, $option);
    }

    public static function jsonEncode(array $jsonEncode, $option = JSON_UNESCAPED_UNICODE) {
        return \json_encode($jsonEncode, $option);
    }

    public static function base64Encode(string $str): string {
        return \base64_encode($str);
    }

    public static function base64Decode(string $str): string {
        return \base64_decode($str);
    }
}
