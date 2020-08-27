<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/1/31
 * Time: 下午2:40
 */

class Libs_Captcha_Captcha{

    const SESSION_IDENTIFY      = 'captcha_code';       //普通验证码标识
    const SESSION_IDENTIFY_ZH   = 'captcha_code_zh';    //中文验证码标识

    private $im;
    private $interfere_count;//干扰点数量

    /**
     * 字符字体枚举
     * @var array
     */
    private $font_char    = array(
        '/captcha/font/char1.ttf',
        '/captcha/font/char2.ttf',
        '/captcha/font/char3.ttf',
        '/captcha/font/numchar1.ttf',
        '/captcha/font/numchar2.ttf',
        '/captcha/font/numchar3.ttf',
        '/captcha/font/numchar4.ttf',
        '/captcha/font/numchar5.ttf',
        '/captcha/font/numchar6.ttf',
        '/captcha/font/numchar7.ttf',
        '/captcha/font/numchar9.ttf',
        '/captcha/font/numchar10.ttf',
        '/captcha/font/numchar11.ttf',
        '/captcha/font/numchar12.ttf',
        '/captcha/font/numchar13.ttf',
    );
    /**
     * 数字字体枚举
     * @var array
     */
    private $font_num     = array(
        '/captcha/font/num1.ttf',
        '/captcha/font/num2.ttf',
        '/captcha/font/num3.ttf',
        '/captcha/font/numchar1.ttf',
        '/captcha/font/numchar2.ttf',
        '/captcha/font/numchar3.ttf',
        '/captcha/font/numchar4.ttf',
        '/captcha/font/numchar5.ttf',
        '/captcha/font/numchar6.ttf',
        '/captcha/font/numchar7.ttf',
        '/captcha/font/numchar9.ttf',
        '/captcha/font/numchar10.ttf',
        '/captcha/font/numchar11.ttf',
        '/captcha/font/numchar12.ttf',
        '/captcha/font/numchar13.ttf',
    );

    /**
     * 中文字体枚举
     * @var array
     */
    private $font_zh    = array(
        '/captcha/font/zh1.ttf',
    );

    /**
     * 构造方法，将直接输出png格式的图片验证码
     * @param int $width
     * @param int $height
     * @param string $type 验证码类型，可取值为num,math,zh,auth,char
     * @param int $length 验证码字符个数，math类型忽略此参数
     */
    public function __construct($width = 200, $height = 50, $type = 'num', $length = 4) {
        $width  = intval($width);
        $height = intval($height);
        $code   = '';
        $this->interfere_count  = ceil(($width*$height)/25);
        //清除session
        unset($_SESSION[self::SESSION_IDENTIFY]);
        unset($_SESSION[self::SESSION_IDENTIFY_ZH]);
        switch($type) {
            case 'math' :
                //只做加法
                $num1   = rand(0, 9);
                $num2   = rand(0, 9);
                $code   = $num1 + $num2;
                $_SESSION[self::SESSION_IDENTIFY] = $code;
                $this->getMathCode($num1, $num2, $width, $height);
                break;
            case 'zh' :
                $str        = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借";
                $str        = iconv('utf-8','gbk',$str);
                for($i = 0; $i < $length; $i++){
                    $xi = mt_rand(0, strlen($str)/2);
                    if($xi%2){
                        $xi +=1;
                    }
                    $code .= substr($str, $xi, 2);
                }
                $_SESSION[self::SESSION_IDENTIFY_ZH] = $code;
                $this->getZhCode($code, $width, $height);
                break;
            case 'auth' :
                $str    = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                for($i = 0; $i < $length; $i++){
                    $code   .= $str[mt_rand(0, strlen($str)-1)];
                }
                $_SESSION[self::SESSION_IDENTIFY] = $code;
                $this->getAuthCode($code, $width, $height);
                break;
            case 'char' :
                //去掉了 0 1 I O l o 等，以避免混淆
                $str    = "23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz";
                for ($i = 0; $i < $length; $i++) {
                    $code .= $str[mt_rand(0, strlen($str)-1)];
                }
                $_SESSION[self::SESSION_IDENTIFY] = $code;
                $this->getCharCode($code, $width, $height);
                break;
            case 'num' :
            default :
                for ($i = 0; $i < $length; $i++) {
                    $code .= rand(0, 9);
                }
                $_SESSION[self::SESSION_IDENTIFY] = $code;
                $this->getNumCode($code, $width, $height);
                break;
        }

        return $this;
    }

    /**
     * 以图片形式显示验证码
     */
    public function outputCaptcha() {
        header("Content-type: image/PNG");
        imagepng($this->im);
    }

    /**
     * 校验验证码是否正确
     * @param string $code
     * @return bool
     */
    public static function verifyCode($code) {
        //中文验证码特殊处理
        if (isset($_SESSION[self::SESSION_IDENTIFY_ZH])) {
            //处理接收中文字符串
            $text = preg_replace_callback("/%u[0-9A-Za-z]{4}/", function($ar) {
                $c = '';
                foreach ($ar as $val) {
                    $val = intval(substr($val, 2), 16);
                    if ($val < 0x7F) { // 0000-007F
                        $c .= chr($val);
                    } else if ($val < 0x800) { // 0080-0800
                        $c .= chr(0xC0 | ($val / 64));
                        $c .= chr(0x80 | ($val % 64));
                    } else { // 0800-FFFF
                        $c .= chr(0xE0 | (($val / 64) / 64));
                        $c .= chr(0x80 | (($val / 64) % 64));
                        $c .= chr(0x80 | ($val % 64));
                    }
                }
                return $c;
            }, $code);
            $ver_code = mb_convert_encoding($text, 'utf-8');
            $ses_code = iconv('gbk', 'utf-8', $_SESSION[self::SESSION_IDENTIFY_ZH]);

            if ($ver_code == $ses_code) {
                return true;
            }
        } else {
            if (strcasecmp($code, $_SESSION[self::SESSION_IDENTIFY]) == 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * 生成数字验证码
     * @param string $code
     * @param int $w
     * @param int $h
     */
    private function getNumCode($code, $w, $h) {
        //创建图片，定义颜色值
        $im     = imagecreate($w, $h);
        $black  = imagecolorallocate($im, 0, 0, 0);
        $gray   = imagecolorallocate($im, 200, 200, 200);
        imagefill($im, 0, 0, $gray);

        //画边框
        imagerectangle($im, 0, 0, $w-1, $h-1, $black);

        //随机绘制两条虚线，起干扰作用
        $style = array (
            $black,
            $black,
            $black,
            $black,
            $black,
            $gray,
            $gray,
            $gray,
            $gray,
            $gray
        );
        imagesetstyle($im, $style);
        $y1 = rand(0, $h);
        $y2 = rand(0, $h);
        $y3 = rand(0, $h);
        $y4 = rand(0, $h);
        imageline($im, 0, $y1, $w, $y3, IMG_COLOR_STYLED);
        imageline($im, 0, $y2, $w, $y4, IMG_COLOR_STYLED);

        //在画布上随机生成大量黑点，起干扰作用;
        for ($i = 0; $i < $this->interfere_count; $i++) {
            imagesetpixel($im, rand(0, $w), rand(0, $h), $black);
        }
        $font       = PLUM_DIR_LIB . $this->font_num[array_rand($this->font_num)];
        $font_size  = ceil($h/2);
        $font_blank = ceil($h/4);
        //将数字随机显示在画布上,字符的水平间距和位置都按一定波动范围随机生成
        for($i = 0; $i < strlen($code); $i++){
            $fontcolor  = imagecolorallocate($im, mt_rand(0,120), mt_rand(0,120), mt_rand(0,120)); //这样保证随机出来的颜色较深。
            imagettftext($im, $font_size, mt_rand(-20,20), ceil(($i+0.5)*$font_size), $h-$font_blank, $fontcolor, $font, $code[$i]);
        }
        $this->im = $im;
    }

    /**
     * 生成数学验证码
     * @param int $num1
     * @param int $num2
     * @param int $w
     * @param int $h
     */
    private function getMathCode($num1, $num2, $w, $h) {
        $im     = imagecreatetruecolor($w, $h);
        //浅色随机背景
        $bg_color  = imagecolorallocate($im, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
        imagefill($im, 0, 0, $bg_color);
        //在画布上随机生成大量点，起干扰作用;
        for ($i = 0; $i < $this->interfere_count; $i++) {
            $if_color   = imagecolorallocate($im, mt_rand(100, 200), mt_rand(100, 200), mt_rand(100, 200));
            imagesetpixel($im, rand(0, $w), rand(0, $h), $if_color);
        }
        $font       = PLUM_DIR_LIB . $this->font_num[array_rand($this->font_num)];
        $font_size  = ceil($h/2);
        $font_blank = ceil($h/4);
        $char_arr   = array($num1, '+', $num2, '=', '?');
        for($i = 0; $i < count($char_arr); $i++){
            $fontcolor  = imagecolorallocate($im, mt_rand(0,120), mt_rand(0,120), mt_rand(0,120)); //这样保证随机出来的颜色较深。
            imagettftext($im, $font_size, mt_rand(-20,20), ceil(($i+0.5)*$font_size), $h-$font_blank, $fontcolor, $font, $char_arr[$i]);
        }

        $this->im = $im;
    }

    /**
     * 生成中文验证码
     * @param string $code
     * @param int $w
     * @param int $h
     */
    private function getZhCode($code, $w, $h) {
        $fontface   = PLUM_DIR_LIB . "/captcha/font/zh1.ttf"; //字体文件
        $im         = imagecreatetruecolor($w, $h);
        //设置背景色
        $bkcolor    = imagecolorallocate($im, mt_rand(175, 250), mt_rand(175, 250), mt_rand(175, 250));
        imagefill($im, 0, 0, $bkcolor);
        /***添加椭圆弧干扰***/
        for ($i = 0; $i < 15; $i++) {
            $fontcolor  = imagecolorallocate($im, mt_rand(0,175), mt_rand(0,175), mt_rand(0,175));
            imagearc($im, mt_rand(-10,$w), mt_rand(-10,$h), mt_rand(30,300), mt_rand(20,200), 55, 44, $fontcolor);
        }
        /***添加像素干扰点***/
        for($i=0;$i<$this->interfere_count;$i++){
            $fontcolor  = imagecolorallocate($im,mt_rand(0,175),mt_rand(0,175),mt_rand(0,175));
            imagesetpixel($im,mt_rand(0,$w),mt_rand(0,$h),$fontcolor);
        }
        /***********内容*********/
        $font_size  = ceil($h/2);
        $font_blank = ceil($h/3);
        for($i=0;$i<strlen($code)/2;$i++){
            $fontcolor  = imagecolorallocate($im, mt_rand(0,120), mt_rand(0,120), mt_rand(0,120)); //这样保证随机出来的颜色较深。
            $codex      = iconv("GBK", "UTF-8", substr($code, $i*2, 2));
            imagettftext($im, $font_size, mt_rand(-20,20), ceil(($i+0.5)*$font_size+$i*$font_blank), $h-$font_blank, $fontcolor, $fontface, $codex);
        }
        $this->im = $im;
    }

    /**
     * 类谷歌验证码图片，仅大写字母
     * @param string $code
     * @param int $w
     * @param int $h
     */
    private function getAuthCode($code, $w, $h) {
        $im         = imagecreatetruecolor($w, $h);
        //字体颜色
        $text_c     = imagecolorallocate($im, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
        //设置背景色
        $buttum_c   = imagecolorallocate($im, mt_rand(100,255), mt_rand(100,255), mt_rand(100,255));
        imagefill($im, 0, 0, $buttum_c);
        //字体文件，随机获取
        $font       = PLUM_DIR_LIB . $this->font_char[array_rand($this->font_char)];
        $font_size  = ceil($h/2);
        $font_blank = ceil($h/4);

        for ($i = 0; $i < strlen($code); $i++){
            $tmp    = substr($code, $i, 1);
            $array  = array(-1,1);
            $p      = array_rand($array);
            $an     = $array[$p]*mt_rand(1,10);//角度
            imagettftext($im, $font_size, $an, $font_blank+$i*$font_size, $h-$font_blank, $text_c, $font, $tmp);
        }

        //新建图片资源，并设置背景色
        $distortion_im = imagecreatetruecolor($w, $h);
        imagefill($distortion_im, 0, 0, $buttum_c);
        for ( $i=0; $i<$w; $i++) {
            for ( $j=0; $j<$h; $j++) {
                //获取每个像素点的颜色索引值
                $rgb = imagecolorat($im, $i , $j);
                if( (int)($i+20+sin($j/$h*2*M_PI)*10) <= imagesx($distortion_im)&& (int)($i+20+sin($j/$h*2*M_PI)*10) >=0 ) {
                    imagesetpixel($distortion_im, (int)($i+10+sin($j/$h*2*M_PI-M_PI*0.1)*4) , $j , $rgb);
                }
            }
        }
        //加入干扰像素
        for($i=0; $i<$this->interfere_count; $i++){
            $randcolor = imagecolorallocate($distortion_im, mt_rand(0,255), mt_rand(0,255) ,mt_rand(0,255));
            //随机生成干扰像素点
            imagesetpixel($distortion_im, mt_rand()%$w , mt_rand()%$h , $randcolor);
        }
        //加入干扰线
        $rand = mt_rand($font_blank, 3*$font_blank);
        $rand1 = mt_rand(15,25);
        $rand2 = mt_rand(5,10);
        for ($yy = $rand; $yy <= $rand+ceil($font_blank/8); $yy++) {
            for ($px = -$w;$px <= 0;$px = $px+0.1) {
                $x  = $px/$rand1;
                $y  = 0;
                if ($x != 0){
                    $y = sin($x);
                }
                $py = $y*$rand2;
                imagesetpixel($distortion_im, $px+$w, $py+$yy, $text_c);
            }
        }
        imagedestroy($im);
        $this->im = $distortion_im;
    }

    /**
     * 获取数字字母混合验证码
     * @param string $code
     * @param int $w
     * @param int $h
     */
    private function getCharCode($code, $w, $h) {
        //创建图片，定义颜色值
        $im         = imagecreate($w, $h);
        $black      = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
        $gray       = imagecolorallocate($im, 118, 151, 199);
        $bgcolor    = imagecolorallocate($im, 235, 236, 237);
        //画背景
        imagefill($im, 0, 0, $bgcolor);
        //画边框
        imagerectangle($im, 0, 0, $w-1, $h-1, $gray);

        //在画布上随机生成大量点，起干扰作用;
        for ($i = 0; $i < $this->interfere_count; $i++) {
            imagesetpixel($im, rand(0, $w), rand(0, $h), $black);
        }
        $font       = PLUM_DIR_LIB . $this->font_num[array_rand($this->font_num)];
        $font_size  = ceil($h/2);
        $font_blank = ceil($h/4);
        //将数字随机显示在画布上,字符的水平间距和位置都按一定波动范围随机生成
        for($i = 0; $i < strlen($code); $i++){
            $fontcolor  = imagecolorallocate($im, mt_rand(0,120), mt_rand(0,120), mt_rand(0,120)); //这样保证随机出来的颜色较深。
            imagettftext($im, $font_size, mt_rand(-20,20), ceil(($i+0.5)*$font_size), $h-$font_blank, $fontcolor, $font, $code[$i]);
        }
        $this->im = $im;
    }

    /**
     * 析构函数，以销毁图片资源
     */
    function __destruct() {
        imagedestroy($this->im);
    }
}