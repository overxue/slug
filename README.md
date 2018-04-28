<h1 align="center">Slug</h1>

<p align="center">中文的 url slug 支持，目的是实现文章和帖子中文标题也可以使用 slug 类型的 url（目前只支持laravel框架中使用）</p>

## 安装

这是一个标准的 Composer 包,你可以直接通过下面的命令行来安装:

```shell
$ composer require "overxue/slug"
```

## 在laravel中使用
1. 在`config/services.php`中添加：
```php
'baidu' => [
      'appId' => env('BAIDU_APP_ID'),
      'appKey' => env('BAIDU_APP_KEY')
  ],
```
在`.env`文件中添加 [百度开放平台](http://api.fanyi.baidu.com/api/trans/product/desktop?req=developer) 中申请的appid和秘钥(不配置appid和秘钥，程序会自动使用汉字转拼音方案来生成 Slug)
```
BAIDU_APP_ID=APP ID
BAIDU_APP_KEY=密钥
```
2. 使用
```php

app('slug')->translate('如何翻译laravel文档');
// how-to-translate-laravel-documents
// 不配置秘钥和appid返回     ru-he-fan-yi-laravel-wen-dang

或者

use Overxue\Slug\Slug;

$slug = new Slug(config('services.baidu'));
$slug->translate('如何翻译laravel文档');
// how-to-translate-laravel-documents

```

## License

MIT
