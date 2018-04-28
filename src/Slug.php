<?php

namespace Overxue\Slug;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class Slug
{
    protected $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';

    protected $config;

    public function __construct($config = [])
    {
        $this->config = $config;
    }

    public function translate($text)
    {
        return $this->getTranslatedText($text);
    }

    private function getTranslatedText($text)
    {
        if ($this->isEnglish($text)) {
            return str_slug($text);
        }
        $appid = $this->config['appId'];
        $key = $this->config['appKey'];
        // 如果没有配置百度翻译，自动使用兼容的拼音方案
        if (empty($appid) || empty($key)) {
            return $this->pinyin($text);
        }
        $url = $this->getTranslateUrl($appid, $key, $text);
        // 实例化 HTTP 客户端
        $http = new Client;
        // 发送 HTTP Get 请求
        $response = $http->get($url);
        $result = json_decode($response->getBody(), true);
        if (isset($result['trans_result'][0]['dst'])) {
            return str_slug($result['trans_result'][0]['dst']);
        } else {
            // 如果百度翻译没有结果，使用拼音作为后备计划。
            return $this->pinyin($text);
        }
    }

    private function isEnglish($text)
    {
        if (preg_match("/\p{Han}+/u", $text)) {
            return false;
        }
        return true;
    }

    // 获取百度翻译api;
    private function getTranslateUrl($appid, $key, $text)
    {
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
        return $this->api.$query;
    }

    public function pinyin($text)
    {
        return str_slug(app(Pinyin::class)->permalink($text));
    }
}