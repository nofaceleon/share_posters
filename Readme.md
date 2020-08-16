```php
<?php

require_once "./vendor/autoload.php";

try {
    $src_img_url = 'test/banner.jpg'; //背景图片地址
    $av_img_url = 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eoxmpn6icFOYGednicZib4QZZdpd0o1aXUP9ia9ibftyu3wMiakic9IWS0kCFohTR3ObT26v4zbBAt1yAtXg/132';

    $img = new \sjs\shareposters\Image($src_img_url); //创建一个待装饰的对象

    $img = (new \sjs\shareposters\QrcodeDecorator($img))->setParam([
        'qr_size' => 100, //二维码大小
        'qr_x' => 600, //距离底图左边距
        'qr_y' => 500, //距离底图右边距
        'qr_text' => 'https://www.baidu.com', //二维码内容
        'src_img_url' => $src_img_url //底图地址
    ]);//使用二维码装饰


    $img = (new \sjs\shareposters\TextDecorator($img))->setParam([
        'text_x' => 370, //距离底图左边距
        'text_y' => 400, //距离底图右边距
        'text_size' => 20, //文字大小
        'text_color' => [ //文字颜色
            'r' => 122, 
            'g' => 44,
            'b' => 5
        ],
        'text' => '你好世界', //文字内容
        'src_img_url' => $src_img_url, //底图地址
        'font' => './font.tty' //字体文件
    ]); //在图片上加上文字

    $img = (new \sjs\shareposters\AvatarDecorator($img))->setParam([
        'src_img_url' => $src_img_url, //底图地址
        'another_img' => $av_img_url, //水印图地址
        'img_size' => 60, //水印图大小
        'img_x' => 80, //距离底图左边距
        'img_y' => 100, //距离底图右边距
    ]);


    $img->draw(); //绘图
    $img->echoImg(); //将图片输出到浏览器
} catch (Exception $e) {
    echo $e->getMessage();
}


```

#### 使用方法

1. 使用装饰器模式实现对图片加上文字, 二维码, 水印等功能
2. 位置最大不会超过底图