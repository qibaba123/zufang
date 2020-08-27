<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/7/20
 * Time: 上午10:59
 */
class App_Model_Wechat_MysqlChatMsgStorage extends Libs_Mvc_Model_BaseModel{

    const CHAT_TYPE_TEXT        = 0;//文本类型消息
    const CHAT_TYPE_IMAGE       = 1;//图片类型消息

    const CHAT_FROM_CUSTOMER    = 0;//来源客户
    const CHAT_FROM_SERVICE     = 1;//来源客服

    private $sid;
    private $member_table;
    public function __construct($sid){
        $this->_table 	= 'shop_chatmsg';
        $this->_pk 		= 'sc_id';
        $this->_shopId 	= 'sc_s_id';
        parent::__construct();
        $this->sid  = $sid;
        $this->member_table = DB::table('member');
    }

    /**
     * 获取聊天的最新一条记录
     */
    public function newestChat($openid){
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'sc_openid','oper'=>'=','value'=>$openid);
        $sort = array('sc_create_time'=>'DESC');
        $data = array();
        $list = $this->getList($where,0,1,$sort);
        if($list){
            $data = $list[0];
        }
        return $data;
    }

    /*
     * 获得聊天记录 关联用户表
     */
    public function getChatList($where,$index,$count,$sort){
        $sql = "select sc.*,m.m_nickname,m.m_avatar,m.m_openid ";
        $sql .= " from `".DB::table($this->_table)."` sc ";
        $sql .= " left join ".$this->member_table." m on m.m_openid = sc.sc_openid ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}