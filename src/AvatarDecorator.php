<?php

namespace sjs\shareposters;

class AvatarDecorator extends AbDecorator
{

    protected $src_img_url;
    protected $another_img; //其他图片
    protected $img_size; //图片大小
    protected $img_x; //左边距
    protected $img_y; //上边距


    public function draw()
    {
        $this->src_img = $this->component->draw();
        $src_img_info = getimagesize($this->src_img_url);

        $another_img_info = getimagesize($this->another_img);
        $type = explode('/', $another_img_info['mime'])[1];
        $fun = "imagecreatefrom{$type}";
        $another_img_h = $fun($this->another_img); //创建图片资源

        //对图片进行缩放处理
        $new_img_max_width = $new_img_max_height = $this->img_size;

        $this->img_x = max(0, $this->img_x);
        $this->img_y = max(0, $this->img_y);

        $this->img_x = min($src_img_info[0] - $new_img_max_width, $this->img_x);
        $this->img_y = min($src_img_info[1] - $new_img_max_height, $this->img_y);


        $new_img = imagecreatetruecolor($new_img_max_width, $new_img_max_height);
        imagecopyresized($new_img, $another_img_h, 0, 0, 0, 0, $new_img_max_width, $new_img_max_height, imagesx($another_img_h), imagesy($another_img_h));


        imagecopymerge($this->src_img, $new_img, $this->img_x, $this->img_y, 0, 0, $new_img_max_width, $new_img_max_width, 100);
        return $this->src_img;


    }

}