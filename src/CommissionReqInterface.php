<?php
/**
 * FileName:ApiReqInterface.php
 * Author:ZhangZhe
 * Email:1061180002@qq.com
 * Date:2022/6/29 0029
 * Time:16:13
 */
declare(strict_types=1);

namespace HuYingKeJi\Qdgcommissionsdk;

interface CommissionReqInterface {

    public function getApiParams(): array;

    public function getUri(): string;

    public function getHttpMethod(): string;

}
