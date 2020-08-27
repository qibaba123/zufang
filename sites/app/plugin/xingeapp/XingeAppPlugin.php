<?php
require_once(DRUPAL_ROOT.'/sites/app/plugin/xingeapp/XingeApp.php');
/*
 * 信鸽推送解析：
 * 信鸽账户：又称别名，客户端请求信鸽服务器，注册信鸽账号，
 *          Android通过registerPush(context,account)接口，ios通过setAccount设置
 * token和账户的关系：token是一台设备的标识，账号是一个用户的标识。账号相当于QQ号码，token相当于电脑(有限制10)。
 */
class App_Plugin_XingeApp_XingeAppPlugin{

    private $push = null;
    private $mess = null;

    public function __construct($accessId, $secretKey){
        $this->push = new XingeApp($accessId, $secretKey);
        $this->mess = new Message();
        $this->iosmess = new MessageIOS();

        #含义：样式编号0，响铃，震动，不可从通知栏清除，不影响先前通知
        $this->style = new Style(0,1,1,1,0);
        $this->action = new ClickAction();
        $this->acceptTime1 = new TimeInterval(0, 0, 23, 59);
        $this->environment = XingeApp::IOSENV_DEV;    // IOSENV_PROD :生产环境   IOSENV_DEV：开发环境

    }

    /**
     * 使用默认设置推送消息给单个android设备
     * @param $title    推送标题
     * @param $content  推送内容
     * @param $token    android设备的token
     * @return array|mixed
     */
    public function PushTokenAndroid($title, $content, $token)
    {
        $this->mess->setTitle($title);
        $this->mess->setContent($content);
        $this->mess->setType(Message::TYPE_NOTIFICATION);
        $this->mess->setStyle($this->style);
        $this->action->setActionType(ClickAction::TYPE_ACTIVITY);
        $this->mess->setAction($this->action);
        $ret = $this->push->PushSingleDevice($token, $this->mess);
        return $ret;
    }


    /**
     * 使用默认设置推送消息给单个android版账户
     * @param $title     推送标题
     * @param $content   推送内容
     * @param $account   android设备的账户
     * @return array|mixed
     */
    public function PushAccountAndroid($title, $content, $account)
    {
        $this->mess->setTitle($title);
        $this->mess->setContent($content);
        $this->mess->setType(Message::TYPE_NOTIFICATION);
        $this->mess->setStyle($this->style);
        $this->action->setActionType(ClickAction::TYPE_ACTIVITY);
        $this->mess->setAction($this->action);
        $ret = $this->push->PushSingleAccount(0, $account, $this->mess);
        return $ret;
    }

    /**
     * 使用默认设置推送消息给多个android版账户
     * @param $title     推送标题
     * @param $content   推送内容
     * @param $accountList   android设备的账户
     * @return array|mixed
     */
    public function PushAccountListAndroid($title, $content, $accountList,$order=array())
    {
        $this->mess->setTitle($title);
        $this->mess->setContent($content);
        $this->mess->setType(Message::TYPE_NOTIFICATION);
        $this->mess->setStyle($this->style);
        $this->action->setActionType(ClickAction::TYPE_ACTIVITY);
        $this->mess->setCustom($order);
        $this->mess->setAction($this->action);
        $ret = $this->push->PushAccountList(0, $accountList, $this->mess);
        return $ret;
    }

    /**
     * 使用默认设置推送消息给所有设备android版
     * @param $title    推送标题
     * @param $content  推送内容
     * @return array|mixed
     */
    public function PushAllAndroid($title, $content)
    {
        $this->mess->setTitle($title);
        $this->mess->setContent($content);
        $this->mess->setType(Message::TYPE_NOTIFICATION);
        $this->mess->setStyle($this->style);
        $this->action->setActionType(ClickAction::TYPE_ACTIVITY);
        $this->mess->setAction($this->action);
        $ret = $this->push->PushAllDevices(0, $this->mess);
        return $ret;
    }


    /**
     * 使用默认设置推送消息给标签选中设备android版
     * @param $title     推送标题
     * @param $content   推送内容
     * @param $tag       需要推送的设备标签
     * @return mixed
     */
    public function PushTagAndroid($title, $content, $tag)
    {
        $this->mess->setTitle($title);
        $this->mess->setContent($content);
        $this->mess->setType(Message::TYPE_NOTIFICATION);
        $this->mess->setStyle($this->style);
        $this->action->setActionType(ClickAction::TYPE_ACTIVITY);
        $this->mess->setAction($this->action);
        $ret = $this->push->PushTags(0, array(0 => $tag), 'OR', $this->mess);
        return $ret;
    }

    /**
     * 使用默认设置推送消息给单个ios设备
     * @param $content       推送标题
     * @param $token         设备token
     * @return array|mixed
     */
    public function PushTokenIos($content, $token)
    {
        $this->iosmess->setAlert($content);
        $this->mess->setType(Message::TYPE_NOTIFICATION);
        $this->mess->setStyle($this->style);
        $this->iosmess->setBadge(1);
        $this->action->setActionType(ClickAction::TYPE_ACTIVITY);
        $ret = $this->push->PushSingleDevice($token, $this->iosmess, $this->environment);
        return $ret;
    }


    /**
     * 使用默认设置推送消息给单个ios版账户
     * @param $content
     * @param $account
     * @return array|mixed
     */
    public function PushAccountIos($content, $account)
    {
        $this->iosmess->setAlert($content);
        $this->mess->setType(Message::TYPE_NOTIFICATION);
        $this->mess->setStyle($this->style);
        $this->iosmess->setBadge(1);
        $this->action->setActionType(ClickAction::TYPE_ACTIVITY);
        $ret = $this->push->PushSingleAccount(0, $account, $this->iosmess, $this->environment);
        return $ret;
    }

    /**
     * 使用默认设置推送消息给多个ios版账户
     * @param $content  推送内容
     * @param $accountList  推送账户
     * @return array|mixed
     */
    public function PushAccountListIos($content, $accountList,$order=array())
    {
        $this->iosmess->setAlert($content);
        $this->iosmess->setSound('default');
        $this->iosmess->setType(12);
        $this->mess->setStyle($this->style);
        $this->iosmess->setCustom($order);
        $this->iosmess->setBadge(1);
        $this->action->setActionType(ClickAction::TYPE_ACTIVITY);
        $ret = $this->push->PushAccountList(0, $accountList, $this->iosmess, $this->environment);
        return $ret;
    }

    /**
     * 使用默认设置推送消息给所有设备ios版
     * @param $content
     * @return array|mixed
     */
    public function PushAllIos($content)
    {
        $this->iosmess->setAlert($content);
        $this->mess->setType(Message::TYPE_NOTIFICATION);
        $this->mess->setStyle($this->style);
        $this->iosmess->setBadge(1);
        $this->action->setActionType(ClickAction::TYPE_ACTIVITY);
        $ret = $this->push->PushAllDevices(0, $this->iosmess, $this->environment);
        return $ret;
    }


    /**
     * 使用默认设置推送消息给标签选中设备ios版
     * @param $content       推送内容
     * @param $tagList           选中的标签
     * @return mixed
     */
    public function PushTagIos($content,$tagList,$and_or='OR')
    {
        $this->iosmess->setAlert($content);
        $this->mess->setType(Message::TYPE_NOTIFICATION);
        $this->mess->setStyle($this->style);
        $this->iosmess->setBadge(1);
        $this->action->setActionType(ClickAction::TYPE_ACTIVITY);
        $ret = $this->push->PushTags(0, $tagList, $and_or, $this->iosmess, $this->environment);
        return $ret;
    }

    /**
     * @return array|mixed
     * 查询所有标签
     */
    public function QueryTags(){
        return $this->push->QueryTags();
    }

    /**
     * @param $account
     * @return array|mixed
     * 查询单个帐户的Token
     */
    public function getTokensOfAccount($account){
        return $this->push->QueryTokensOfAccount($account);
    }
}
