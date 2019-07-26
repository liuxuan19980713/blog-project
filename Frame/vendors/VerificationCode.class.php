<?php

namespace Frame\Vendors;

/**
 * 这是验证码类
 */
final class VerificationCode
{
    # 定义一些验证码的属性
    private $codeLength; // 验证码的长度
    private $widht; //验证码的宽度
    private $height; // 验证码的高度
    private $font; // 验证码字体的大小
    private $img; // 画布资源
    private $code; # 验证码字符串
    private $fontfile = ROOT_PATH."Public".DS."Admin".DS."Images".DS."STFANGSO.TTF";

    public function __construct($codeLength = 4, $widht = 80, $height = 36, $font = 18)
    {
        $this->codeLength = $codeLength;
        $this->widht = $widht;
        $this->height = $height;
        $this->font = $font;
        # 创建画布
        $this->createCanvas();
        #为画布分配颜色
        $this->allocateColor();
        # 绘制画布的点和线
        $this->drawLineAndDot();
        # 生成验证码
        $this->createCode();
        #　绘制文字
        $this->drawText();
        # 输出图片
        $this->outputImage();
    }
    private function createCanvas(){
        $this->img  = imagecreatetruecolor($this->widht,$this->height);
    }
    private function allocateColor(){
        $color1 = imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        imagefill($this->img,0,0,$color1);
    }
    private function drawLineAndDot(){
        $color2 = imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        // 绘制点
        
        for($i=0;$i<50;$i++){ 
            imagesetpixel($this->img,mt_rand(0,$this->widht),mt_rand(0,$this->height),$color2);
        }
        // 绘制线
        $color3 = imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        for($i=0;$i<6;$i++){
            imageline($this->img,mt_rand(0,$this->widht),mt_rand(0,$this->height),mt_rand(0,$this->widht),mt_rand(0,$this->height),$color3);
        }
    }
   //生成验证码
	private function createCode()
        {
            $str = "";
            $arr = array_merge(range("a","z"),range("A","Z"),range(0,9));
            shuffle($arr);
            shuffle($arr);
            $arr_index = array_rand($arr,4);
            shuffle($arr_index);
            //生成随机字符串
            foreach($arr_index as $i)
            {
                $str .= $arr[$i];
            }
            //将字符串赋给$code属性
            $this->code = $str;
            // 将产生的验证码保存到session中去
            $_SESSION['code'] = $str;
        }
    private function drawText(){
        $color4 = imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        imagettftext($this->img,$this->font,0,15,25, $color4,$this->fontfile,$this->code);
    }
    private function outputImage(){
       
        header('Content-type:image/png');
        imagepng($this->img);
        imagedestroy($this->img);
    }
}
