<?php

namespace sjs\shareposters;

class Image implements DecoratorInterface
{

    protected $back_img;
    /**
     * @var false|resource
     */
    private $src_img;

    public function __construct($back_img = '')
    {
        $this->back_img = $back_img;
    }


    public function draw()
    {
        //把背景图片加载到内存中
//        var_dump($this->back_img);

        $src_img_info = getimagesize($this->back_img);
        $type = explode('/', $src_img_info['mime'])[1];
        $fun = "imagecreatefrom{$type}";
        $this->src_img = $fun($this->back_img); //根据图片资源文件
        return $this->src_img; //返回一个图片资源
    }

    public function echoImg()
    {
        header('Content-Type: '.'image/jpeg');
        imagejpeg($this->src_img); //输出图片
        imagedestroy($this->src_img); //删除图片资源
    }

}