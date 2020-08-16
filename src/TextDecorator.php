<?php

namespace sjs\shareposters;

/**
 *
 * 给图片上面加上文字
 * Class TextDecorator
 * @package App
 */
class TextDecorator extends AbDecorator
{

    protected $text_size = 10; //字号
    protected $text_x = 0; //左边距
    protected $text_y = 0; //上边距
    protected $text_color = [
        'r' => 255,
        'g' => 255,
        'b' => 255
    ]; //字体颜色
    protected $text = 'hello word'; //内容
    protected $src_img_url;
    protected $font; //字体文件




    public function draw()
    {
        $this->src_img = $this->component->draw(); //获取图像资源

        if(empty($this->font)){
            $this->font = __DIR__.'/simhei.ttf'; //使用默认的字体文件
        }

        $color = imagecolorallocate($this->src_img, $this->text_color['r'], $this->text_color['g'], $this->text_color['b']);

        $src_img_info = getimagesize($this->src_img_url);

        //note: 文字的定位锚点是左下角
        $this->text_x = max(0, $this->text_x);
        $this->text_y = max(0, $this->text_y + $this->text_size); //y坐标转换, 把锚点位置转换成左上角

        $x_max = $src_img_info[0] - ($this->text_size * mb_strlen($this->text) + 20); //字体区域的最大宽度是根据字数决定的

        $this->text_x = min($this->text_x, $x_max);
        $this->text_y = max($this->text_size, $this->text_y); //y轴的最小值必须大于字体的字号
        $this->text_y = min($this->text_y, $src_img_info[1]); //y轴的最大值不能大于图片的高度


        imagettftext($this->src_img, $this->text_size, 0, $this->text_x, $this->text_y, $color, $this->font, $this->text);

        return $this->src_img;
    }


}