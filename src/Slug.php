<?php

namespace Overxue\Slug;

use GuzzleHttp\Client;

class Slug
{
    protected $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';

    protected $http;

    protected $config;

    public function __construct(Client $http, array $config)
    {
        $this->http = $http;
        $this->config = $config;
    }

    public function translate($text)
    {
        $appid = $this->config['appId'];
        $key = $this->config['appKey'];
        $salt = time();
        $sign = md5($appid. $text . $salt . $key);
        // 构建请求参数
        $query = http_build_query([
            "q"     =>  $text,
            "from"  => "zh",
            "to"    => "en",
            "appid" => $appid,
            "salt"  => $salt,
            "sign"  => $sign,
        ]);
        // 发送 HTTP Get 请求
        $response = $this->http->get($this->api.$query);
        $result = json_decode($response->getBody(), true);
        if (isset($result['trans_result'][0]['dst'])) {
//            return str_slug($result['trans_result'][0]['dst']);
            return str_slug($result['trans_result'][0]['dst']);
        } else {
            // 如果百度翻译没有结果，使用拼音作为后备计划。
            return $this->pinyin($text);
        }
    }


}