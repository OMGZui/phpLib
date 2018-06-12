<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/12
 * Time: 10:36
 */

namespace OMGZui\Avatar;

class Avatar
{
    public $avatar;
    protected $str;
    protected $img;
    public function __construct(\Laravolt\Avatar\Avatar $avatar, String $str)
    {
        $this->avatar = $avatar;
        $this->str = $str;
        $this->img = $this->avatar->create($this->str);
        $this->img->setBackground('#001122');
        $this->img->setForeground('#999999');
        $this->img->setFontSize(72);
        $this->img->setFont('../public/fonts/rockwell.ttf');
        $this->img->setBorder(1, '#aabbcc');
    }

    public function setABase64()
    {
        return $this->img->toBase64();
    }

    public function saveAsFile($path = '../public/sample.png', $quality = 100)
    {
        return $this->img->save($path, $quality);
    }

    public function outAsSVG()
    {
        return $this->img->toSvg();
    }
}