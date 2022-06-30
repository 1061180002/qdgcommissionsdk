#!/usr/bin/env php
<?php declare(strict_types=1);
// load autoload.php
$possibleFiles = [__DIR__ . '/../vendor/autoload.php', __DIR__ . '/../../../autoload.php', __DIR__ . '/../../autoload.php'];
$file = null;
foreach ($possibleFiles as $possibleFile) {
    if (\file_exists($possibleFile)) {
        $file = $possibleFile;
        break;
    }
}
if (null === $file) {
    throw new \RuntimeException('Unable to locate autoload.php file.');
}

require_once $file;
unset($possibleFiles, $possibleFile, $file);
$report = "---- 请输入appid -----";
$appid = "";
$secret = "";
$filePath = "";
while (true) {
    fwrite(STDOUT, $report . PHP_EOL);
    $str = fread(STDIN, 20480);
    if (!$appid) {
        $appid = $str;
        $report = "---- 请输入secret ----" . PHP_EOL;
    } else if (!$secret) {
        $secret = $str;
        $res = getPubKey(
            str_replace(["\n", "\r"], ["", ""], $appid),
            str_replace(["\n", "\r"], ["", ""], $secret)
        );
        if ($res["status"] == 1) {

            exit($res['data'] . "\n");
        } else {

            exit($res['msg'] . "\n");
        }
    }
}

function getPubKey($appid, $secret) {
    echo "【" . date("Y-m-d H:i:s") . "】发送请求中。。。。。。。。。。。。。。。。。。。\n";
    return httpRequest($appid, $secret);
}


function httpRequest($appid, $secret) {
    $time = time() . "";
    $none_str = uniqid();
    $post_data = [
        "appid"     => $appid,
        "none_str"  => $none_str,
        "timestamp" => $time,
    ];
    $sign = "";
    foreach ($post_data as $key => $val) {
        $sign .= $key . $val;
    }
    $sign .= $secret;
    $signStr = strtolower(md5($sign));
    $post_data["sign"] = $signStr;

    $ch = curl_init("https://api.qudaogo.com/api/qdg/get_pub_key");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HEADER, [
        "Content-Type: application/json",
        "Accept: application/json",
    ]);
    $resp = curl_exec($ch);
    $errmsg = curl_error($ch);
    $errcode = curl_errno($ch);
    $info = curl_getinfo($ch);
    if ($info['http_code'] != 200 || $resp == false || $errmsg != "" || $errcode != 0) {
        foreach ($info as $key => $item) {
            if (is_string($item)) {
                echo "[" . $key . "=>>>" . $item . "]\n";
            } else {
                echo "[" . $key . "=>>>" . json_encode($item, 256) . "]\n";
            }
        }
        exit("请求出现错误请检查参数，并重新输入。。。。。。。。。。。。。。。。");
    }

    [$header, $body] = explode("\r\n\r\n", $resp, 2);
    return json_decode($body, true);
}
