<?php


namespace App\Hooks;


class PluginAP extends Base
{
    protected array $transaction_types = [BOOK_GAMES];
    protected int $ap_value = 100;

    public function execute_book_from($params)
    {
        if (in_array($params["transaction_type"], $this->transaction_types)) {
            $map = ApMapper();
            $ap_amount = floor($params["amount"] / $this->ap_value);
            $map->sendAps($ap_amount, $params["user"]->getId());
        }
    }

    public function execute($hook_point, $params)
    {
        if ($hook_point == 'BOOK_FROM') {
            $this->execute_book_from($params);
        }
    }
}