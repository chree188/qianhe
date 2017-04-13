<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
	
	'index' => ['index/Index/index',['method' => 'post|get|put'],],
	'aboutus' => ['index/Index/aboutus',['method' => 'post|get|put'],],
	'product' => ['index/Index/product',['method' => 'post|get|put'],],
	'cases' => ['index/Index/cases',['method' => 'post|get|put'],],
	'culture' => ['index/Index/culture',['method' => 'post|get|put'],],
	'culture' => ['index/Index/culture',['method' => 'post|get|put'],],
	'honor' => ['index/Index/honor',['method' => 'post|get|put'],],
	'news' => ['index/Index/news',['method' => 'post|get|put'],],
	'newsdetail' => ['index/Index/newsdetail',['method' => 'post|get|put'],],
	'contact' => ['index/Index/contact',['method' => 'post|get|put'],],
    'productdetail' => ['index/Index/productdetail',['method' => 'post|get|put'],],
    'ajaxIndex' => ['index/Index/ajaxIndex',['method' => 'post|get|put'],],
    'productLst' => ['index/Product/productLst',['method' => 'post|get|put'],],
    'productDetail' => ['index/Product/productDetail',['method' => 'post|get|put'],],
    'casesLst' => ['index/Cases/lst',['method' => 'post|get|put'],],
    'cultureLst' => ['index/Culture/culture',['method' => 'post|get|put'],],
    'honorLst' => ['index/Honor/honor',['method' => 'post|get|put'],],
    'newsLst' => ['index/News/lst',['method' => 'post|get|put'],],
    'newsD' => ['index/News/detail',['method' => 'post|get|put'],],
    'cont' => ['index/Contact/system',['method' => 'post|get|put'],],
	'msg' => ['index/Contact/msg',['method' => 'post|get|put'],],
];
