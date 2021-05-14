<?php

namespace Ipad90\Sinegy;

use Ipad90\Sinegy\Base;

class Marketplace extends Base
{
    public function __construct($api_key, $secret_key)
    {
        parent::__construct($api_key, $secret_key);
    }

    public function getCurrencies()
    {
        return $this->curlAPI("GET", "{$this->version}/general/currency", []);
    }

    public function getCurrencyPairs()
    {
        return $this->curlAPI("GET", "{$this->version}/general/currency-pair", []);
    }

    public function getServerTime()
    {
        return $this->curlAPI("GET", "{$this->version}/server/time", []);
    }

    public function getServerStatus()
    {
        return $this->curlAPI("GET", "{$this->version}/server/status", []);
    }

    public function ticker($pair)
    {
        $url = "{$this->version}/market/spot/orderbook";
        $path = [
            "currencyPair" => $pair
        ];
        $url .= "?" . http_build_query($path);
        return $this->curlAPI("GET", $url, []);
    }

    public function getOrderBook($pair)
    {
        $url = "{$this->version}/market/spot/orderbook";
        $path = [
            "currencyPair" => $pair
        ];
        $url .= "?" . http_build_query($path);
        return $this->curlAPI("GET", $url, []);
    }

    public function getRecentTrades($pair, $page = 1, $limit = 250)
    {
        $url = "{$this->version}/market/spot/trades";
        $path = [
            "currencyPair" => $pair,
            "page" => $page,
            "limit" => $limit
        ];
        $url .= "?" . http_build_query($path);
        return $this->curlAPI("GET", $url, []);
    }

    public function getChartData($pair, $reso, $to_ts, $limit = 2000)
    {
        $url = "{$this->version}/market/spot/chart/klines";
        $path = [
            "currencyPair" => $pair,
            "limit" =>  $limit,
            "reso" => $reso,
            "toTs" => $to_ts
        ];
        $url .= "?" . http_build_query($path);
        return $this->curlAPI("GET", $url, []);
    }

    public function getAccountBalance($currency = null)
    {
        $url = "{$this->version}/account/balance";
        $path = [
            "timestamp" => $this->timestamp()
        ];
        if (isset($currency)) {
            $path["currency"] = $currency;
        }
        $path["signature"] = $this->signature("GET", $url, $path);
        $url .= "?" . http_build_query($path);
        return $this->curlAPI("GET", $url, []);
    }

    public function getTransactions($currency, $page = 1, $limit = 250, $start_time = 0, $end_time = 0)
    {
        $url = "{$this->version}/account/transaction";
        $path = [
            "currency" => $currency,
            "timestamp" => $this->timestamp(),
        ];
        if ($start_time > 0) {
            $path['startTime'] = $start_time;
        }
        if ($end_time > 0) {
            $path['endTime'] = $end_time;
        }
        $path["signature"] = $this->signature("GET", $url, $path);
        $url .= "?" . http_build_query($path);
        return $this->curlAPI("GET", $url, []);
    }

    public function getDeposits($currency, $page = 1, $limit = 250, $start_time = 0, $end_time = 0)
    {
        $url = "{$this->version}/account/wallet/deposit/asset";
        $path = [
            "currency" => $currency,
            "timestamp" => $this->timestamp(),
        ];
        if ($start_time > 0) {
            $path['startTime'] = $start_time;
        }
        if ($end_time > 0) {
            $path['endTime'] = $end_time;
        }
        $path["signature"] = $this->signature("GET", $url, $path);
        $url .= "?" . http_build_query($path);
        return $this->curlAPI("GET", $url, []);
    }

    public function getWithdrawals($currency, $page = 1, $limit = 250, $start_time = 0, $end_time = 0)
    {
        $url = "{$this->version}/account/wallet/withdrawal/asset";
        $path = [
            "currency" => $currency,
            "timestamp" => $this->timestamp(),
        ];
        if ($start_time > 0) {
            $path['startTime'] = $start_time;
        }
        if ($end_time > 0) {
            $path['endTime'] = $end_time;
        }
        $path["signature"] = $this->signature("GET", $url, $path);
        $url .= "?" . http_build_query($path);
        return $this->curlAPI("GET", $url, []);
    }

    public function getTradeFees($pair)
    {
        $url = "{$this->version}/general/trade/fees";
        return $this->curlAPI("GET", $url, []);
    }

    public function getSpecificOrder($pair, $transaction_no)
    {
        $url = "{$this->version}/account/order/check";
        $path = [
            "currencyPair" => $pair,
            "transactionNo" => $transaction_no,
            "timestamp" => $this->timestamp()
        ];
        $path["signature"] = $this->signature("GET", $url, $path);
        return $this->curlAPI("GET", $url, []);
    }

    public function getActiveOrders($pair, $page = 1, $limit = 250, $start_time = 0, $end_time = 0)
    {
        $url = "{$this->version}/account/orders";
        $path = [
            "currencyPair" => $pair,
            "page" => $page,
            "limit" => $limit,
            "timestamp" => $this->timestamp(),
        ];
        if ($start_time > 0) {
            $path['startTime'] = $start_time;
        }
        if ($end_time > 0) {
            $path['endTime'] = $end_time;
        }
        $path["signature"] = $this->signature("GET", $url, $path);
        $url .= "?" . http_build_query($path);
        return $this->curlAPI("GET", $url, []);
    }
    
    public function getFilledOrders($pair, $page = 1, $limit = 250, $start_time = 0, $end_time = 0)
    {
        $url = "{$this->version}/account/orders/history";
        $path = [
            "currencyPair" => $pair,
            "page" => $page,
            "limit" => $limit,
            "timestamp" => $this->timestamp(),
        ];
        if ($start_time > 0) {
            $path['startTime'] = $start_time;
        }
        if ($end_time > 0) {
            $path['endTime'] = $end_time;
        }
        $path["signature"] = $this->signature("GET", $url, $path);
        $url .= "?" . http_build_query($path);
        return $this->curlAPI("GET", $url, []);
    }

    public function getTrades($pair, $page = 1, $limit = 250, $start_time = 0, $end_time = 0)
    {
        $url = "{$this->version}/account/trades";
        $path = [
            "currencyPair" => $pair,
            "page" => $page,
            "limit" => $limit,
            "timestamp" => $this->timestamp()
        ];
        if ($start_time > 0) {
            $path['startTime'] = $start_time;
        }
        if ($end_time > 0) {
            $path['endTime'] = $end_time;
        }
        $path["signature"] = $this->signature("GET", $url, $path);
        $url .= "?" . http_build_query($path);
        return $this->curlAPI("GET", $url, []);
    }
    
    public function placeTestOrder($pair, $price, $volume, $side, $order_type, $recv_window = 5000)
    {
        $url = "{$this->version}/account/orders/test";
        $parameters = [
            "currencyPair" => $pair,
            "unitPrice" => $price,
            "volume" => $volume,
            "orderSide" => $side,
            "orderType" => $order_type,
            "recvWindow" => $recv_window,
            "timestamp" => $this->timestamp()
        ];
        $parameters["signature"] = $this->signature("POST", $url, $parameters);
        return $this->curlAPI("POST", $url, $parameters);
    }

    public function placeOrder($pair, $price, $volume, $side, $order_type, $recv_window = 5000)
    {
        $url = "{$this->version}/account/orders/place";
        $parameters = [
            "currencyPair" => $pair,
            "unitPrice" => $price,
            "volume" => $volume,
            "orderSide" => $side,
            "orderType" => $order_type,
            "recvWindow" => $recv_window,
            "timestamp" => $this->timestamp()
        ];
        $parameters["signature"] = $this->signature("POST", $url, $parameters);
        return $this->curlAPI("POST", $url, $parameters);
    }

    public function cancelOrder($pair, $order_id, $recv_window = 5000)
    {
        $url = "{$this->version}/account/orders/cancel";
        $parameters = [
            "currencyPair" => $pair,
            "orderId" => $order_id,
            "recvWindow" => $recv_window,
            "timestamp" => $this->timestamp()
        ];
        $parameters["signature"] = $this->signature("DELETE", $url, $parameters);
        return $this->curlAPI("DELETE", $url, $parameters);
    }
}
