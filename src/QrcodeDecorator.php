<?php

namespace sjs\shareposters;

use Endroid\QrCode\QrCode;

class QrcodeDecorator extends AbDecorator
{

    protected $qr_size; //二维码宽度
    protected $qr_x = 0; //左边距
    protected $qr_y = 0; //右边距
    protected $qr_text; //二维码内容
    protected $src_img_url; //源文件路径


    public function draw()
    {

        if(empty($this->qr_text)){
            throw new \Exception('qr_text参数不能为空');
        }
        $this->src_img = $this->component->draw(); //这边获取的是一个资源类型
        $qr_code = new QrCode($this->qr_text);
        $qr_code->setSize($this->qr_size);
        $qr_code->setMargin(5);
        $qr_dataUri = $qr_code->writeDataUri();

        $qr_info = getimagesize($qr_dataUri);

        $this->qr_x = max(0, $this->qr_x); //坐标最小是0
        $this->qr_y = max(0, $this->qr_y);

        if($this->qr_x > 0 || $this->qr_y > 0){ //限制偏移量
            if(empty($this->src_img_url)){
                throw new \Exception('src_img_url参数不能为空');
            }
            $src_img_info = getimagesize($this->src_img_url);

            $dst_x = $src_img_info[0] - $qr_info[0]; //左边距最大偏移量
            $dst_y = $src_img_info[1] - $qr_info[1]; //上边距最大偏移量

            $this->qr_x = min($this->qr_x, $dst_x);
            $this->qr_y = min($this->qr_y, $dst_y);

        }
        $qr_h = imagecreatefrompng($qr_dataUri); //二维码图片加载到内存中
        imagecopymerge($this->src_img, $qr_h, $this->qr_x, $this->qr_y, 0, 0, $qr_info[0], $qr_info[1], 100);
        return $this->src_img; //返回的也是一个处理过的资源类型

    }


}