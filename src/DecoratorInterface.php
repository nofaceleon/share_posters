<?php
namespace sjs\shareposters;

interface DecoratorInterface
{
    //绘图接口
    public function draw();

    //输出
    public function echoImg();
}