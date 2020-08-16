<?php

namespace sjs\shareposters;

abstract class AbDecorator implements DecoratorInterface
{
    protected $component;
    protected $src_img;

    public function __construct(DecoratorInterface $component)
    {
        $this->component = $component;
    }

    public function echoImg()
    {
        header('Content-Type: '.'image/jpeg');
        imagejpeg($this->src_img); //输出图片
        imagedestroy($this->src_img); //删除图片资源
    }

    /**
     * 参数设置
     * @param array $params
     * @return $this
     */
    public function setParam($params = [])
    {
        foreach ($params as $key => $param) {
            $this->$key = $param;
        }
        return $this;

    }


}