<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/8/10
 * Time: 下午1:25
 */
class App_Helper_Image {
    /**
     * RGB格式
     */
    const RGB = 1;

    /**
     * 6位十六进制格式
     */
    const HEX_6_BIT = 2;

    /**
     * 8位十六进制格式
     */
    const HEX_8_BIT = 3;

    //测试方法
    public static function addTextWatermark($imgPath, $text){
        /*给图片加文字水印的方法*/
        $dst_path = PLUM_DIR_ROOT.$imgPath;
        $dstInfo = @getimagesize($dst_path);
        $dst = imagecreatefromstring(file_get_contents($dst_path));

        $font = '/public/wxapp/css/font.ttf';
        $colorType = self::getColorType($dst_path, $dstInfo);
        if($colorType == 1){
            $color = imagecolorallocate($dst, 50, 50, 50);
        }else{
            $color = imagecolorallocate($dst, 200, 200, 200);
        }

        $fontSize = $dstInfo[0]/20;
        $fontNum  = mb_strlen($text, 'UTF-8');

        $x = $dstInfo[0]-($fontSize*($fontNum + 3)); $y = $dstInfo[1]-$fontSize/2-20;
        imagefttext($dst, $fontSize, 0, $x, $y, $color, $font, $text);

        list($dst_w,$dst_h,$dst_type) = getimagesize($dst_path);
        switch($dst_type){
            case 1://GIF
                $result = imagegif($dst, $dst_path);
                break;
            case 2://JPG
                $result = imagejpeg($dst, $dst_path);
                break;
            case 3://PNG
                $result = imagepng($dst, $dst_path);
                break;
            default:
                break;
        }
        imagedestroy($dst);
        return $result;
    }

    public static function getColorType($img_path, $dstInfo){
        $brightness = 0;
        for ($i = ($dstInfo[0] - 100); $i < $dstInfo[0]; $i++) {
            for ($j = ($dstInfo[1] - 100); $j < $dstInfo[1]; $j++) {
                $brightness += self::getBrightnessOfPixel($img_path, $i, $j);
            }
        }

        $brightness /= 10000;

        return $brightness > 125 ? 1 : 2;
    }

    public static function getBrightnessOfPixel($img_path = '', $x, $y){
        list($r, $g, $b) = self::getColor($img_path, $x, $y, self::RGB);
        $g = $r * 0.299 + $g * 0.587 + $b * 0.114;

        return $g;
    }

    public static function getColor($img_path = '', $x, $y, $format = self::HEX_8_BIT)
    {
        static $img;

        $getRgb = function($img) use ($x, $y) {
            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            return [$r, $g, $b];
        };

        if (!(isset($img) && is_resource($img))) {
            $img = self::openImg($img_path);
        }

        return self::rgbToFormat($getRgb($img), $format);
    }

    public static function openImg($img_path)
    {


        $info = getimagesize($img_path);



        $img_info = array(
            'width'  => $info[0],
            'height' => $info[1],
            'type'   => image_type_to_extension($info[2], false),
            'mime'   => $info['mime'],
        );

        $fun = "imagecreatefrom{$img_info['type']}";
        $img = $fun($img_path);

        return $img;
    }

    public static function rgbToFormat($rgb, $format)
    {
        list($r, $g, $b) = $rgb;
        $result = '#';

        switch ($format) {
            case self::RGB:
                return $rgb;
                break;
            case self::HEX_6_BIT:
                $result .= str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
                $result .= str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
                $result .= str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
                return $result;
                break;
            case self::HEX_8_BIT:
                $result .= 'ff';
                $result .= str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
                $result .= str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
                $result .= str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
                return $result;
                break;
        }

    }

    /*
     * 修改图片尺寸
     */
    public static function updateImageSize($imgsrc,$newWidth = 200,$newHeight = 200){
        //取得图片的宽度,高度值
        list($width,$height,$type) = getimagesize($imgsrc);
        $imagecreate    = "imagecreatefrom";
        $imageoutput    = "image";
        $imageext       = '';
        // 如果类型不存在，则直接返回图片路径
        if(!$type || !in_array($type,array(1,2,3))){
            return $imgsrc;
        }
        switch ($type) {
            case IMAGETYPE_GIF :
                $imagecreate    .= "gif";
                $imageoutput    .= "gif";
                $imageext       = '.gif';
                break;
            case IMAGETYPE_JPEG :
                $imagecreate    .= "jpeg";
                $imageoutput    .= "jpeg";
                $imageext       = '.jpg';
                break;
            case IMAGETYPE_PNG :
                $imagecreate    .= "png";
                $imageoutput    .= "png";
                $imageext       = '.png';
                break;
        }
        // Create image and define colors
        $imgsrc = $imagecreate($imgsrc);
        $image = imagecreatetruecolor($newWidth, $newHeight); //创建一个彩色的底图
        imagecopyresized($image, $imgsrc, 0, 0, 0, 0,$newWidth,$newHeight,$width, $height);
        $filename   = PLUM_APP_BUILD."/".plum_random_code(8, false) . '-' . plum_random_code(6, false) . $imageext;
        $imageoutput($image,$filename);
        imagedestroy($image);
        // 将图片缩小尺寸再次请求
        return $filename;
    }
}