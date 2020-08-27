<?php

//未引入PHPMailer的类自动加载机制，所以需要手动引入
require_once 'PHPMailer/class.smtp.php';
require_once 'PHPMailer/class.phpmailer.php';

/**
 * 使用PHPMailer发送邮件
 * Class Libs_Mail_Mailer
 */
class Libs_Mail_Mailer {
    /**
     * PHPMailer 实例
     * @var null|PHPMailer
     */
    protected $phpmailer = null;

    /**
     * 发送状态标识
     * @var bool
     */
    private $send_flag = true;
    /**
     * 错误信息栈
     * @var array
     */
    private $error_stack = array();

    /**
     * 构造函数
     * @param null|string|array $to 收件人，默认为null,将获取默认配置的收件人列表；string单个收件人地址；array多个收件人地址
     *  array('test1@ikinvin.com', 'test2@ikinvin.com') | array(array('address' => '', 'name' => ''),array('address' => '', 'name' => ''))
     * @param null|string|array $cc 抄送人，参考收件人参数配置说明
     */
    public function __construct($to = null, $cc = null) {
        $this->phpmailer = new PHPMailer(true);
        $this->phpmailer->clearAllRecipients();

        $this->_config_smtp_mail();
        $this->_set_default_mail($to, $cc);
    }

    private function _config_smtp_mail() {
        //获取SMTP的默认配置
        $smtp_cfg = plum_parse_config('smtp', 'mail', null);
        if (!$smtp_cfg) {
            $this->send_flag = false;
            array_push($this->error_stack, '未找到SMTP配置参数');
            return false;
        }
        $this->phpmailer->isSMTP();
        $this->phpmailer->isHTML(true);
        $this->phpmailer->Host      = $smtp_cfg['host'];
        $this->phpmailer->Port      = $smtp_cfg['port'];
        $this->phpmailer->SMTPAuth  = true;
        $this->phpmailer->SMTPSecure= $smtp_cfg['secure'];
        $this->phpmailer->Username  = $smtp_cfg['username'];
        $this->phpmailer->Password  = $smtp_cfg['password'];
        $this->phpmailer->From      = $smtp_cfg['from'];
        $this->phpmailer->FromName  = $smtp_cfg['fromname'];
        $this->phpmailer->CharSet   = $smtp_cfg['charset'];

        return true;
    }

    private function _set_default_mail($to, $cc) {
        //未设置收件人信息，或设置为空
        if (!$to || empty($to)) {
            //使用默认配置的收件人列表
            $to_cfg = plum_parse_config('to', 'mail', null);
            if ($to_cfg && !empty($to_cfg)) {
                foreach ($to_cfg as $toAddr) {
                    $this->addToAddress($toAddr['address'], $to['name']);
                }
            } else {
                $this->send_flag = false;
                array_push($this->error_stack, '未找到默认的收件人列表');
                return false;
            }
        } else {
            if (is_string($to)) {
                $this->addToAddress($to);
            } else if (is_array($to)) {
                foreach ($to as $toAddr) {
                    if (is_array($toAddr)) {
                        $this->addToAddress($toAddr['address'], $toAddr['name']);
                    } else {
                        $this->addToAddress($toAddr);
                    }
                }
            }
        }
        //未设置抄送人信息，或抄送人为空
        if (!$cc || empty($cc)) {
            $cc_cfg = plum_parse_config('cc', 'mail', null);
            if ($cc_cfg && !empty($cc_cfg)) {
                foreach ($cc_cfg as $ccAddr) {
                    $this->addCcAddress($ccAddr['address'], $ccAddr['name']);
                }
            }
        } else {
            if (is_string($cc)) {
                $this->addCcAddress($cc);
            } else if (is_array($cc)) {
                foreach ($cc as $ccAddr) {
                    if (is_array($ccAddr)) {
                        $this->addCcAddress($ccAddr['address'], $ccAddr['name']);
                    } else {
                        $this->addCcAddress($ccAddr);
                    }
                }
            }
        }
        return true;
    }

    public function setContent($subject, $body) {
        if ($subject && $body) {
            $this->phpmailer->Subject   = $subject;
            //$this->phpmailer->Body      = $body;
            $this->phpmailer->msgHTML($body);
        } else {
            $this->send_flag = false;
            array_push($this->error_stack, '未设置邮件标题或内容');
        }
    }

    /**
     * 添加收件人地址，添加多个时，循环调用
     * @param string $address 收件人邮箱地址
     * @param string $name  收件人姓名
     */
    public function addToAddress($address, $name = '') {
        try {
            $this->phpmailer->addAddress($address, $name);
        } catch (phpmailerException $e) {
            $this->send_flag = false;
            array_push($this->error_stack, $e->getMessage().'#收件人邮箱格式不正确');
        }
    }

    /**
     * 添加抄送人地址，添加多个时，循环调用
     * @param string $address 抄送人邮箱地址
     * @param string $name  抄送人姓名
     */
    public function addCcAddress($address, $name = '') {
        try {
            $this->phpmailer->addCC($address, $name);
        } catch (phpmailerException $e) {
            $this->send_flag = false;
            array_push($this->error_stack, $e->getMessage().'#抄送人邮箱格式不正确');
        }
    }

    /**
     * 发送邮件
     * @param string $subject 邮件主题
     * @param string $body  邮件内容
     * @return bool
     */
    public function sendMail($subject, $body) {
        $this->setContent($subject, $body);

        if ($this->send_flag) {
            try {
                $this->phpmailer->send();
            } catch (phpmailerException $e) {
                $this->send_flag = false;
                array_push($this->error_stack, $e->getMessage().'#邮件发送失败');
            }
        }

        return $this->send_flag;
    }

    /**
     * 发送附件邮件
     * @param string $subject 邮件主题
     * @param string $body  邮件内容
     * @return bool
     */
    public function sendAddAttachmentMail($subject, $body, $file, $fromName='') {
        $this->setContent($subject, $this->embed_images($body));
        if ($this->send_flag) {
            try {
                if($fromName){
                    $this->phpmailer->FromName  = $fromName;
                }
                $this->phpmailer->SMTPSecure = 'ssl';
                $this->phpmailer->Port = 465;
                $this->phpmailer->AddAttachment($file, $subject.'.pdf');
                $this->phpmailer->send();
            } catch (phpmailerException $e) {
                $this->send_flag = false;
                array_push($this->error_stack, $e->getMessage().'#邮件发送失败');
            }
        }

        return $this->send_flag;
    }

    private function embed_images($html){
       $resutl = preg_match_all('/<img.*?>/', $html, $matches);
       if(!$resutl) return $html;
       $trans = array();
       foreach ($matches[0] as $key => $img) {
           $id = 'img' . $key;
           preg_match('/src="(.*?)"/', $img, $path);
           preg_match('/class="(.*?)"/', $img, $class);
           if ($path[1]){
               $this->phpmailer->addEmbeddedImage(PLUM_DIR_ROOT.$path[1], $id);
               $trans[$img] = '<img src="cid:' . $id . '" class="'.$class[1].'" />';
           }
       }
       $html = strtr($html, $trans);
       return $html;
    }

    /**
     * 返回错误信息栈
     * @return array
     */
    public function getErrorStack() {
        return $this->error_stack;
    }
}