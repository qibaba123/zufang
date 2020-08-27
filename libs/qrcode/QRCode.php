<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/2/1
 * Time: 下午6:20
 */

include 'phpqrcode/phpqrcode.php';

class Libs_Qrcode_QRCode extends QRcode {

    //L水平    7%的字码可被修正
    //M水平    15%的字码可被修正
    //Q水平    25%的字码可被修正
    //H水平    30%的字码可被修正

    /**
     * 生成或输出二维码图片
     * @param string $text      文字内容
     * @param mixed $outfile    是否直接输出二维码图片，为false时直接输出，其他传入存储的二维码文件名
     * @param mixed $level      容错级别，接收0-3或L-H或l-h
     * @param int $size         像素大小
     * @param int $margin       二维码周围边框空白区域间距值
     * @param bool $saveandprint 是否显示并保存二维码图片，为true时，$outfile为输出的文件名
     */
    public static function png($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4, $saveandprint = false) {
        parent::png($text, $outfile, $level, $size, $margin, $saveandprint);
    }

    /**
     * 生成中间带有logo的二维码图片
     * @param string $text
     * @param string $logo
     * @param mixed $outfile
     * @param mixed $level
     * @param int $size
     * @param int $margin
     * @param bool $saveandprint
     * @return bool
     */
    public static function pngWithLogo($text, $logo, $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4, $saveandprint = false) {
        //检查tmp目录是否存在,默认存放路径为==根目录/sites/app/storage/tmp
        if (!plum_setmod_dir(PLUM_DIR_TEMP)) {
            return false;
        }

        if (!file_exists($logo)) {
            trigger_error('logo图片不存在', E_USER_WARNING);
            return false;
        }

        $tmp_qr_png = PLUM_DIR_TEMP . '/' . uniqid('qrcode_');
        //生成临时二维码图片
        self::png($text, $tmp_qr_png, $level, $size, $margin);

        $qr_im      = imagecreatefromstring(file_get_contents($tmp_qr_png));
        $logo_im    = imagecreatefromstring(file_get_contents($logo));

        $qr_width   = imagesx($qr_im);
        $qr_height  = imagesy($qr_im);
        $logo_width = imagesx($logo_im);
        $logo_height= imagesy($logo_im);

        $logo_qr_width  = $qr_width / 5;
        $scale          = $logo_width / $logo_qr_width;
        $logo_qr_height = $logo_height / $scale;
        $from_width     = ($qr_width - $logo_qr_height) / 2;

        imagecopyresampled($qr_im, $logo_im, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

        if ($outfile === false) {
            header("Content-type: image/png");
            imagepng($qr_im);
        } else {
            if($saveandprint === TRUE){
                imagepng($qr_im, $outfile);
                header("Content-type: image/png");
                imagepng($qr_im);
            }else{
                imagepng($qr_im, $outfile);
            }
        }
        imagedestroy($qr_im);
    }

}