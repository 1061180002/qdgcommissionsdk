<?php
/**
 * FileName:CommissionSubmitItemRequest.php
 * Author:ZhangZhe
 * Email:1061180002@qq.com
 * Date:2022/6/30 0030
 * Time:15:14
 */
declare(strict_types=1);

namespace HuYingKeJi\Qdgcommissionsdk\Apis;

class CommissionSubmitItemRequest implements \JsonSerializable {
    private int $money;
    private string $openid;
    private string $name;

    public function __construct($money, $openid, $name) {
        $this->money = $money;
        $this->name = $name;
        $this->openid = $openid;
    }

    /**
     * @return string
     */
    public function getOpenid(): string {
        return $this->openid;
    }

    /**
     * @param string $openid
     */
    public function setOpenid(string $openid): void {
        $this->openid = $openid;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getMoney(): int {
        return $this->money;
    }

    /**
     * @param int $money
     */
    public function setMoney(int $money): void {
        $this->money = $money;
    }


    public function jsonSerialize(): array {
        return [
            "openid" => $this->openid,
            "money"  => $this->money,
            "name"   => $this->name,
        ];
    }
}
