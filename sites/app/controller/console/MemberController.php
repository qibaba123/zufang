<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/14
 * Time: 下午11:18
 */
class App_Controller_Console_MemberController extends Libs_Mvc_Controller_ConsoleController {

    private $pid;

    public function __construct() {
        parent::__construct();
    }

    /*
    * 创建守护进程
    * 执行示例: php /alidata/www/sale/scripts/console.php "member/create"
    */
    public function createAction() {

        $this->createDaemon(2, function ($instance, $pattern, $chan, $msg) {
            $this->eventDistribute($msg);
        });

    }

    /*
     * redis键过期事件分发
     */
    public function eventDistribute($key) {
        $data   = explode('_', $key);
        $kind   = array_shift($data);
        $type   = array_shift($data);

        $method = array_shift($data);
        $sid = array_shift($data);
        $did = array_shift($data);
        switch ($kind) {
            case 'member' :
                switch ($type) {
                    //夺宝计划定时任务
                    case 'weixin' :
                        $shop_weixin    = new App_Helper_ShopWeixin($sid);
                        switch ($method) {
                            //定时计算任务
                            case 'qrcode' :
                                $shop_weixin->sendQrcode($did);
                                break;
                            //定时同步任务
                            case 'pull' :
                                $shop_weixin->pullFollowedUser();
                                break;
                        }
                        break;
                }
                break;
            case 'coupon' :
                switch ($type) {
                    case 'receive' :
                        $coupon_helper  = new App_Helper_Coupon($sid);
                        switch ($method) {
                            //优惠券即将失效
                            case 'invalid' :
                                $coupon_helper->sendCouponInvalid($did);
                                break;
                        }
                        break;
                }
                break;
            case 'redpack' :
                switch ($type) {
                    case 'send' :
                        $rdpk_helper    = new App_Helper_Redpack($sid);
                        switch ($method) {
                            case 'feedback' :
                                $rdpk_helper->checkRedpackSend($did);
                                break;
                        }
                        break;
                }
                break;
        }
    }

    /*
     * 重启守护进程
     * 执行示例：php scripts/console.php "member/restart"
     */
    public function restartAction() {
        $this->stopAction();
        $this->createAction();
    }

    /*
     * 停止守护进程
     * 执行示例：php scripts/console.php "member/stop"
     */
    public function stopAction(){
        $this->stopDaemon();
    }


    public function __destruct() {
        //切到根目录
        Libs_Log_Logger::outputLog($this->process_id, 'ele.log');

        global $argv;
        $enter   = explode('/', $argv[1])[0];
        $operate = explode('/', $argv[1])[1];
        $times   = $argv[2]?$argv[2]:0; //重启的次数

        if ($this->process_id == 0 && $times < 5 && ($operate == 'create' || $operate == 'restart')) {
            Libs_Log_Logger::outputLog($enter."守护进程异常退出", 'daemon-error.log');
            $this->restartDaemon($enter, $times+1);
        }
    }

    /*
     * 修改会员编号
     */
    public function updateMemberShowIdAction(){
        $sid      = plum_get_int_param('sid');
        $mid      = plum_get_int_param('mid');
        if($sid && $mid){
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $ret = $member_storage->updateMemberShowId($sid,$mid);
        }
    }

    /*
     * 批量修改会员编号
     */
    public function batchUpdateMemberShowIdAction(){
        set_time_limit(0);
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $where[] = array('name' => 'm_source', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'm_show_id', 'oper' => '=', 'value' => 0);
        $num = 0;
        $complete = true;
        do {
            $list  = $member_storage->getList($where,0,50,array('m_id'=>'ASC'));
            if($list && !empty($list)){
                foreach ($list as $value){
                    $ret = $member_storage->updateMemberShowId($value['m_s_id'],$value['m_id']);
                    if($ret){
                        $num+=1;
                    }
                }
            }else{
                $complete = false;
            }
            if(($num%1000)==0){
                Libs_Log_Logger::outputLog($num.'这是第'.$num.'条。。。。。。。。。。。。。。','test.log');
            }
        }while($complete);
    }

    /*
     * 批量设置最大会员编号(已经执行完成，不能再调用此方法)
     */
    public function batchSetMemberShowIdAction(){
        set_time_limit(0);
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $n = 1;
        do {
            $max = $member_storage->fetchMemberShowMax($n);
            if($max>0){
                $member_redis   = new App_Model_Member_RedisMemberStorage($n);
                $member_redis->setShopMaxShowId($max);
            }
            $n++;
            if(($n%1000)==0){
                Libs_Log_Logger::outputLog('现在已经执行到第'.$n.'条。。。。。。。。。。。。。。','test.log');
            }
        }while($n<9230);
    }

    /*
     * 批量修改会员编号
     */
    public function newBatchUpdateMemberShowIdAction(){
        set_time_limit(0);
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $where[] = array('name' => 'm_source', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'm_show_id', 'oper' => '=', 'value' => 0);
        $num = 0;
        $complete = true;
        do {
            $list  = $member_storage->getList($where,0,50,array('m_id'=>'ASC'));
            if($list && !empty($list)){
                foreach ($list as $value){
                    $member_redis   = new App_Model_Member_RedisMemberStorage($value['m_s_id']);
                    $max = $member_redis->fetchShopMaxShowId();
                    $ret = $member_storage->newUpdateMemberShowId($value['m_id'],$max);
                    if($ret){
                        $num+=1;
                    }
                }
            }else{
                $complete = false;
            }
            if(($num%1000)==0){
                Libs_Log_Logger::outputLog($num.'这是第'.$num.'条。。。。。。。。。。。。。。','test.log');
            }
            if(!$complete){
                Libs_Log_Logger::outputLog('执行完毕这是第'.$num.'条。。。。。。。。。。。。。。','test.log');
            }
        }while($complete);
    }
}