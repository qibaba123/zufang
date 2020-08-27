<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/20
 * Time: 上午7:39
 */

class App_Model_Member_MysqlMemberCoreStorage extends Libs_Mvc_Model_BaseModel {
    //会员表
    private $member_table;
    //会员关系表
    private $relation_table;
    public function __construct() {
        parent::__construct();
        $this->_table   = 'member';
        $this->_pk      = 'm_id';
        $this->_shopId  = 'm_s_id';

        $this->member_table     = DB::table($this->_table);
        $this->relation_table   = DB::table('member_relation');
    }

    /*
     * 按手机号查找或修改会员的手机号
     */
    public function findUpdateMemberByMobile($mobile, $sid, $mid = null) {
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_mobile', 'oper' => '=', 'value' => $mobile);

        $member = $this->getRow($where);

        if (!$mid) {
            return $member;
        } else {
            if ($member) {
                return false;//会员已存在，不允许插入
            } else {
                $updata = array(
                    'm_mobile'  => $mobile
                );
                return $this->updateById($updata, $mid);
            }
        }
    }
    /*
     * 按微店会员ID查找或修改会员的微店会员ID
     */
    public function findUpdateMemberByBuyerid($buyerid, $sid, $mid = null) {
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_buyer_id', 'oper' => '=', 'value' => $buyerid);

        $member = $this->getRow($where);

        if (!$mid) {
            return $member;
        } else {
            if ($member) {
                return false;//会员已存在，不允许修改
            } else {
                $updata = array(
                    'm_buyer_id'  => $buyerid
                );
                return $this->updateById($updata, $mid);
            }
        }
    }


    /*
     * 计算当前店铺虚拟会员的数量
     */
    public function getCountMemberBySource($sid,$source){
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_source', 'oper' => '=', 'value' => $source);
        $count      = $this->getCount($where);
        return $count;
    }
    /*
     * 查找后台添加的会员信息
     */
    public function getMemberListBySource($sid,$source){
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_source', 'oper' => '=', 'value' => $source);
        $list       = $this->getList($where,0,50);
        return $list;
    }

    /*
     * 通过店铺ID,用户ID获取会员信息
     */
    public function findUpdateMemberByUidSid($uid, $sid, $data = null) {
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_uid', 'oper' => '=', 'value' => $uid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 通过会员id以及店铺id获取会员，以保证用户单店铺唯一性
     */
    public function findMemberBySidMid($mid, $sid) {
        $where[]    = array('name' => 'm_show_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);

        return $this->getRow($where);
    }
    /*
     * 获取会员通过ID值,校验sid
     */
    public function findMemberByIdSid($mid, $sid) {
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);

        return $this->getRow($where);
    }

    /*
     * 通过店铺id和用户id查询用户
     * m_s_id与m_user_id构建组合索引
     */
    public function findUpdateMemberBySidUid($sid, $uid, $data = null) {
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_user_id', 'oper' => '=', 'value' => $uid);

        if (!$data) {
            return $this->getRow($where);
        } else {
            return $this->updateValue($data, $where);
        }
    }

    /*
     * 设置会员销售额、佣金自增或自减
     */
    public function incrementMemberAmount($mid, $sale, $deduct) {
        $field  = array('m_sale_amount', 'm_deduct_amount');
        $inc    = array($sale, $deduct);

        $where[]    = array('name' => 'm_id', 'oper' => '=', 'value' => $mid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 同时增加一个并减少另一个金额
     */
    public function editMemberDeductWithdraw($mid, $money, $inc_field, $cut_field) {
        $field  = array($inc_field, $cut_field);
        $inc    = array($money, -$money);

        $where[]    = array('name' => 'm_id', 'oper' => '=', 'value' => $mid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 设置会员金币自增或自减
     */
    public function incrementMemberGoldcoin($mid, $coin) {
        $field  = array('m_gold_coin');
        $inc    = array($coin);

        $where[]    = array('name' => 'm_id', 'oper' => '=', 'value' => $mid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 批量设置会员金币自增或自减
     */
    public function incrementMultiMemberGoldcoin($mids, $sid ,$coin) {
        $field  = array('m_gold_coin');
        $inc    = array($coin);

        $where[]    = array('name' => 'm_id', 'oper' => 'in', 'value' => $mids);
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
    /*
     * 设置会员积分自增或自减
     */
    public function incrementMemberPoint($mid, $point) {
        $field  = array('m_points');
        $inc    = array($point);

        $where[]    = array('name' => 'm_id', 'oper' => '=', 'value' => $mid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 批量改设置会员积分自增或自减
     */
    public function incrementMultiMemberPoint($mids, $sid, $point) {
        $field  = array('m_points');
        $inc    = array($point);

        $where[]    = array('name' => 'm_id', 'oper' => 'in', 'value' => $mids);
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 设置会员成交订单总笔数、总金额自增或自减
     */
    public function incrementMemberTrade($mid, $money, $num = 1) {
        $field  = array('m_traded_money', 'm_traded_num');
        $inc    = array($money, $num);

        $where[]    = array('name' => 'm_id', 'oper' => '=', 'value' => $mid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 获取店铺所有官方推荐人信息
     */
    public function fetchReferMemberBySid($sid) {
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_is_refer', 'oper' => '=', 'value' => 1);//官方设定人

        $sort   = array('m_id' => 'ASC');
        return $this->getList($where, 0, 0, $sort);
    }

    /*
     * 随机获取一位官方推荐人
     */
    public function fetchRandomReferMember($sid) {
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_is_refer', 'oper' => '=', 'value' => 1);//官方设定人
        $where_sql  = $this->formatWhereSql($where);
        $sql    = "SELECT * FROM `{$this->member_table}` {$where_sql} ORDER BY RAND() LIMIT 1";

        return DB::fetch_first($sql);
    }

    /*
     * 获取店铺所有最高级分销员信息
     */
    public function fetchHighestMemberBySid($sid) {
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_is_highest', 'oper' => '=', 'value' => 1);//最高级

        $sort   = array('m_id' => 'ASC');
        return $this->getList($where, 0, 0, $sort);
    }

    /*
     * 设置会员可提现佣金自增或自减
     */
    public function incrementMemberDeduct($mid, $money) {
        $field  = array('m_deduct_ktx');
        $inc    = array($money);

        $where[]    = array('name' => 'm_id', 'oper' => '=', 'value' => $mid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 设置会员可提现佣金、佣金总额自增或自减
     */
    public function incrementMemberDeductAmount($mid,$deduct) {
        $field  = array('m_deduct_ktx', 'm_deduct_amount');
        $inc    = array($deduct, $deduct);

        $where[]    = array('name' => 'm_id', 'oper' => '=', 'value' => $mid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 设置多个会员可提现佣金自增或自减
     */
    public function incrementMultiMemberDeduct(array $mids, $money) {
        $field  = array('m_deduct_ktx');
        $inc    = array($money);

        $where[]    = array('name' => 'm_id', 'oper' => 'in', 'value' => $mids);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 通过微信openID及店铺id查找或修改用户信息
     */
    public function findUpdateMemberByWeixinOpenid($openid, $sid, $data = null) {
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_openid', 'oper' => '=', 'value' => $openid);

        if (!$data) {
            return $this->getRow($where);
        } else {
            return $this->updateValue($data, $where);
        }
    }

    /*
     * 通过邀请码查找会员，保证单店铺会员的唯一性
     */
    public function findMemberByInviteCodeSid($code, $sid) {
        if (!$code) {
            return false;
        }
        $where[]    = array('name' => 'm_invite_code', 'oper' => '=', 'value' => $code);
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);

        return $this->getRow($where);
    }

    /*
     * 递归地设置会员关系
     */
    public function setLevelRecurse($mid, $fid, $sid) {
        $f_member   = $this->getRowById($fid);//获取上级会员信息

        if ($f_member) {
            //首先设置会员的上级ID
            $updata = array(
                'm_1f_id'    => $fid,
                'm_2f_id'   => $f_member['m_1f_id'],
                'm_3f_id'  => $f_member['m_2f_id'],
            );
            $this->updateById($updata, $mid);
            //设置会员关系
            $indata = array(
                'mr_f_id'       => $fid,
                'mr_s_id'       => $mid,
                'mr_shop_id'    => $sid,
                'mr_create_time'=> time()
            );
            $relation_storage   = new App_Model_Member_MysqlMemberRelationStorage();
            $relation_storage->insertValue($indata);
            //各级会员数+1
            for ($i=1; $i<=3; $i++) {
                $tmp    = "{$i}f";
                if ($updata["m_{$tmp}_id"]) {
                    $tmpc   = "{$i}c";
                    $where      = array();
                    $where[]    = array('name' => 'm_id', 'oper' => '=', 'value' => $updata["m_{$tmp}_id"]);
                    $sql_one    = $this->formatIncrementSql("m_{$tmpc}_count", 1, $where);
                    DB::query($sql_one);
                } else {
                    break;
                }
            }
        }

        //返回级别关系
        return isset($updata) ? $updata : false;
    }

    /*
     * 通过会员id数组批量获取会员信息
     */
    public function fetchMembersByids(array $ids) {
        $where[]    = array('name' => 'm_id', 'oper' => 'in', 'value' => $ids);

        return $this->getList($where, 0, 0, array(), array('m_id', 'm_nickname', 'm_show_id', 'm_avatar','m_traded_num', 'm_sale_amount', 'm_follow_time', 'm_invite_code'), true);
    }

    /*
     * 根据关键词搜索下级会员
     * @param int $mid 上级会员id，不加入店铺id判断，因为会员id定的话，店铺id就固定了
     * @param int $level 搜索级别，1、2、3级
     * @param mixed $keyword 待搜索关键词，会员昵称或会员show_id
     */
    public function fetchMemberByMidKeyword($mid, $level, $keyword) {
        $fname      = "m_{$level}f_id";
        $where[]    = array('name' => $fname, 'oper' => '=', 'value' => $mid);

        if (is_numeric($keyword)) {
            $where[]    = array('name' => 'm_show_id', 'oper' => '=', 'value' => $keyword);
        } else {
            $where[]    = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$keyword}%");
        }

        return $this->getList($where, 0, 0);
    }

    /*
     * 获取下级会员列表，可分页
     */
    public function fetchFirstLevelList($uid, $index = 0, $count = 20, $keyword='') {
        $where[]    = array('name' => 'm_1f_id', 'oper' => '=', 'value' => $uid);
        if($keyword){
            if (is_numeric($keyword)) {
                $where[]    = array('name' => 'm_show_id', 'oper' => '=', 'value' => $keyword);
            } else {
                $where[]    = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$keyword}%");
            }
        }

        $sort   = array('m_id' => 'DESC');
        $list   = $this->getList($where, $index, $count, $sort);

        return $list;
    }

    /*
     * 获取下下级会员列表，可分页
     */
    public function fetchSecondLevelList($uid, $index = 0, $count = 20, $keyword='') {
        $where[]    = array('name' => 'm_2f_id', 'oper' => '=', 'value' => $uid);
        if($keyword){
            if (is_numeric($keyword)) {
                $where[]    = array('name' => 'm_show_id', 'oper' => '=', 'value' => $keyword);
            } else {
                $where[]    = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$keyword}%");
            }
        }
        $sort   = array('m_id' => 'DESC');
        $list   = $this->getList($where, $index, $count, $sort);

        return $list;
    }

    /*
     * 获取下下下级会员列表，可分页
     */
    public function fetchThirdLevelList($uid, $index = 0, $count = 20, $keyword='') {
        $where[]    = array('name' => 'm_3f_id', 'oper' => '=', 'value' => $uid);
        if($keyword){
            if (is_numeric($keyword)) {
                $where[]    = array('name' => 'm_show_id', 'oper' => '=', 'value' => $keyword);
            } else {
                $where[]    = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$keyword}%");
            }
        }
        $sort   = array('m_id' => 'DESC');
        $list   = $this->getList($where, $index, $count, $sort);

        return $list;
    }

    public function getInviteCode(){
        do{
            $code = plum_random_code();
            $where = array();
            $where[]    = array('name' => 'm_invite_code', 'oper' => '=', 'value' => $code);
            $count = $this->getCount($where);
        }while($count > 0);
        return $code;
    }

    /*
     * 按店铺插入新会员，难度在于首先获取当前店铺会员展示id最大值
     */
    public function insertShopNewMember($sid, array $indata) {
        //获取当前店铺最大的会员展示值
        $sql = "SELECT MAX(`m_show_id`) FROM `{$this->member_table}` WHERE `m_s_id` = {$sid}";

        $max_id = DB::result_first($sql);
        $max_id = $max_id ? intval($max_id)+1 : 1;

        $indata['m_show_id'] = $max_id;
        $date = date('Ymd', time());
        $indata['m_nickname'] = trim($indata['m_nickname']) ? trim($indata['m_nickname']) : "会员{$date}{$max_id}";
       // return $indata;
        return $this->insertValue($indata, true, false, true);
    }
    /*
     * 转移某个人及其以下的二级会员(加和起来为三级)到另一个人下
     */
    public function shiftMemberToOther($one, $other) {
        $relation_storage   = new App_Model_Member_MysqlMemberRelationStorage();
        //新上级
        $a_member   = $this->getRowById($other);

        //修改会员的会员关系表
        $updata = array(
            'mr_f_id'   => $other
        );
        $where      = array();
        $where[]    = array('name' => 'mr_s_id', 'oper' => '=', 'value' => $one);
        $relation_storage->updateValue($updata, $where);
        //修改会员的层级关系
        $fids   = array(
            'm_1f_id'   => $other,
            'm_2f_id'   => intval($a_member['m_1f_id']),
            'm_3f_id'   => intval($a_member['m_2f_id'])
        );
        $this->updateById($fids, $one);

        //获取一级会员
        $where1 = array();
        $where1[]   = array('name' => 'm_1f_id', 'oper' => '=', 'value' => $one);
        $list   = $this->getList($where1, 0, 0, array(), array('m_id'));
        if ($list && count($list) > 0) {
            $ids1 = array();
            foreach ($list as $val) {
                array_push($ids1, intval($val['m_id']));
            }
            //修改一级会员的会员关系表

            $fids   = array(
                'm_2f_id'   => $other,
                'm_3f_id'   => intval($a_member['m_1f_id'])
            );

            $where2 = array();
            $where2[] = array('name' => 'm_id', 'oper' => 'in', 'value' => $ids1);
            $this->updateValue($fids, $where2);

            //获取二级会员
            $where3  = array();
            $where3[]    = array('name' => 'm_2f_id', 'oper' => 'in', 'value' => $one);
            $list       = $this->getList($where, 0, 0, array(), array('m_id'));
            if ($list && count($list) > 0) {
                $ids2   = array();
                foreach ($list as $val) {
                    array_push($ids2, intval($val['m_id']));
                }
                $fids = array(
                    'm_3f_id'   => $other,
                );
                $where4 = array();
                $where4[] = array('name' => 'm_id', 'oper' => 'in', 'value' => $ids2);
                $this->updateValue($fids, $where2);
            }
        }
    }
    /*
     * 转移某个人下的三级会员到另一个人下
     */
    public function shiftMemberFromOneToAnother($one, $another) {
        $where      = array();
        $where[]    = array('name' => 'mr_f_id', 'oper' => '=', 'value' => $one);
        $relation_storage   = new App_Model_Member_MysqlMemberRelationStorage();

        //获取一级会员
        $list   = $relation_storage->getList($where, 0, 0, array(), array('mr_s_id'));
        if ($list && count($list) > 0) {
            $ids1 = array();
            foreach ($list as $val) {
                array_push($ids1, intval($val['mr_s_id']));
            }
            //修改一级会员的会员关系表
            $updata = array(
                'mr_f_id'   => $another
            );
            $relation_storage->updateValue($updata, $where);

            $a_member   = $this->getRowById($another);
            $fids   = array(
                'm_1f_id'   => $another,
                'm_2f_id'   => intval($a_member['m_1f_id']),
                'm_3f_id'   => intval($a_member['m_2f_id'])
            );
            $where1[] = array('name' => 'm_id', 'oper' => 'in', 'value' => $ids1);
            $this->updateValue($fids, $where1);
            //获取二级会员
            $where  = array();
            $where[]    = array('name' => 'mr_f_id', 'oper' => 'in', 'value' => $ids1);
            $list       = $relation_storage->getList($where, 0, 0, array(), array('mr_s_id'));
            if ($list && count($list) > 0) {
                $ids2   = array();
                foreach ($list as $val) {
                    array_push($ids2, intval($val['mr_s_id']));
                }
                $fids = array(
                    'm_2f_id'   => $another,
                    'm_3f_id'   => intval($a_member['m_1f_id'])
                );
                $where2[] = array('name' => 'm_id', 'oper' => 'in', 'value' => $ids2);
                $this->updateValue($fids, $where2);
                //获取三级会员
                $where  = array();
                $where[]    = array('name' => 'mr_f_id', 'oper' => 'in', 'value' => $ids2);
                $list       = $relation_storage->getList($where, 0, 0, array(), array('mr_s_id'));
                if ($list && count($list) > 0) {
                    $ids3   = array();
                    foreach ($list as $val) {
                        array_push($ids3, intval($val['mr_s_id']));
                    }
                    $fids = array(
                        'm_3f_id'   => $another,
                    );
                    $where3[] = array('name' => 'm_id', 'oper' => 'in', 'value' => $ids3);
                    $this->updateValue($fids, $where3);
                }
            }
        }
    }

    /*
     * @param $mid 会员ID
     * @param $money 申请提现金额
     * @param $status 提现状态，1审核通过，2审核拒绝
     * @return bool
     */
    public function dealWithdrawMoney($mid,$money,$status){
        if(in_array($status,array(1,2))){
            switch ($status){
                case 1 : //提现成功 ：待审核金额减，已提现金额增加
                    $set = ' , m_deduct_ytx = m_deduct_ytx + '.intval($money);
                    break;
                case 2 : //提现拒绝 ：待审核金额减；可提现金额增加
                    $set = ' , m_deduct_ktx = m_deduct_ktx + '.intval($money);
                    break;
            }
            $sql = 'UPDATE '.DB::table($this->_table);
            $sql .= ' set m_deduct_dsh =  m_deduct_dsh - ' .intval($money).$set;
            $sql .= ' WHERE `m_id` = '.intval($mid);
            $ret = DB::query($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }

    /**
     * @param array $shopId
     * @return array|bool
     * 根据店铺ID统计当前会员数量
     */
    public function getCountGroupBySid(array $shopId){
        $where      = array();
        if($shopId && is_array($shopId)){
            $where[]    = array('name' => 'm_s_id', 'oper' => 'in', 'value' => $shopId);
        }
        $sql = 'SELECT count(*) total,m_s_id ';
        $sql .= ' FROM  '.DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY m_s_id ';

        $ret = DB::fetch_all($sql,array(),'m_s_id');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $id
     * @param $sid
     * @return bool
     * 清除会员等级时，把会员表数据清理
     */
    public function clearMemberLevel($id,$sid){
        $where      = array();
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_level', 'oper' => '=', 'value' => $id);
        $set = array(
            'm_level' => 0,
        );
        return $this->updateValue($set,$where);
    }

    /**
     * @param $card
     * @param $sid
     * @return array|bool
     * 根据会员卡号，获取会员记录
     */
    public function getRowByCard($card,$sid){
        $where      = array();
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_level_card', 'oper' => '=', 'value' => $card);
        return $this->getRow($where);
    }

    /**
     * @param $sid
     * @param $code
     * @param int $mid
     * @return bool
     * 不存在则返回0
     */
    public function checkCode($sid,$code,$mid=0){
        $where      = array();
        $where[]    = array('name' => 'm_invite_code', 'oper' => '=', 'value' => $code);
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        if($mid){
            $where[]    = array('name' => $this->_pk, 'oper' => '!=', 'value' => $mid);
        }

        return $this->getCount($where);
    }

    /**
     * @param $money
     * @param $sid
     * @param $mid
     * @return bool
     * 提现回滚:已提现金额减，可提现金额加
     */
    public function rollbackWithdraw($money,$sid,$mid){
        $where      = array();
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);

        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET m_deduct_ytx = m_deduct_ytx - '.intval($money);
        $sql .= ' , m_deduct_ktx = m_deduct_ktx + '.intval($money);
        $sql .= $this->formatWhereSql($where);

        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $money
     * @param $sid
     * @param $mid
     * @return bool
     * 增加可提现金额
     */
    public function addWithdraw($money,$sid,$mid){
        $where      = array();
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);

        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET m_deduct_ktx = m_deduct_ktx + '.floatval($money);
        $sql .= $this->formatWhereSql($where);

        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $sid
     * @param $midArr
     * @param $index
     * @param $count
     * @return array|bool
     * 获取以mid为key的会员信息
     */
    public function getMemberKeyMid($sid,$midArr,$index,$count,$field=array()){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        if(!empty($midArr) && is_array($midArr)){
            $where[]    = array('name' => $this->_pk, 'oper' => 'in', 'value' => $midArr);
        }
        $sort       = array('m_id' => 'DESC');
        return $this->getList($where, $index, $count,$sort ,$field, true);
    }

    /**
     * @param $sid
     * @param $midArr
     * @return array
     * 获取用户的openid,用于微信给用户发消息
     */
    public function getOptionsBySidMid($sid,$midArr){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        if(!empty($midArr)){
            $where[]= array('name' => $this->_pk, 'oper' => 'in', 'value' => $midArr);
        }
        $sort       = array('m_id' => 'DESC');
        $list       = $this->getList($where, 0, 0,$sort);
        $openids    = array();
        foreach($list as $val){
            $openids[] = $val['m_openid'];
        }
        return $openids;
    }

    /**
     * @param $sid
     * @param $index
     * @param $count
     * @return array|bool
     * 列出本店所有会员
     */
    public function getListBySid($sid,$index,$count){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $sort       = array('m_id' => 'DESC');
        return $this->getList($where, $index, $count,$sort );

    }

    public function getRowByCode($sid,$showId){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_show_id', 'oper' => '=', 'value' => $showId);
        return $this->getRow($where);
    }

    public function getMemberCardListBySid($where,$index,$count,$sort){
        $sql  = 'SELECT m_id, m_card_long,m_level_card,om.* ';
        $sql .= ' FROM '.DB::table($this->_table) . ' m ';
        $sql .= ' LEFT JOIN pre_offline_member om ON om_m_id = m_id ';
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

    /*
     * 获取会员总数
     */
    public function getMemberCount($sid){
        $where      = array();
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        return $this->getCount($where);
    }

    public function getListByIds(array $ids,$sid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_id', 'oper' => 'in', 'value' => $ids);
        return $this->getList($where,0,0,array(),array(),true);
    }

    // 根据条件查询会员
    public function getMemberSelect($sid,$nickname){
        $sql  = ' SELECT * ';
        $sql .= ' FROM '.DB::table($this->_table) ;
        $sql .= ' where m_s_id = '.$sid.' and (m_show_id = '."'$nickname'".' or m_nickname like '."'%{$nickname}%'".') ';
        $sql .= ' ORDER BY FIELD(m_id,'."'$nickname'".')';
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
    * 设置会员答题复活卡自增或自减
    */
    public function incrementMemberCard($mid, $num=1) {
        $field  = array('m_revive_card');
        $inc    = array($num);

        $where[]    = array('name' => 'm_id', 'oper' => '=', 'value' => $mid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    public function getMemberLeverByMid($mid){
        $sql  = 'SELECT * ';
        $sql .= ' FROM '.DB::table($this->_table) . ' m ';
        $sql .= ' LEFT JOIN pre_member_level ml ON ml_id = m_level ';
        $sql .= ' where m_id = '.$mid;

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    //返回会员的昵称以及id相关
    public function getMemberNameBysid($sid){
        $sql = 'select m_id,m_nickname,m_avatar from pre_member where m_s_id = '.$sid;
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        $data = array();
        foreach($ret as $val){
            $data[$val['m_id']]['name'] = $val['m_nickname'];
            $data[$val['m_id']]['avatar']= $val['m_avatar'];
        }
        return $data;

    }


    /**
     * @param $mid  会员id
     * @param $field
     * @param $inc
     * @return mixed
     */
    public function incrementMemberLevelCount($mid, $field, $inc) {
        $where[]    = array('name' => 'm_id', 'oper' => '=', 'value' => $mid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }


    public function getMemberBySubordinateCount($where,$index,$count){
        $sql  = ' SELECT m.*';
        $sql .= ' FROM (SELECT *,sum(m_1c_count+m_2c_count+m_3c_count) m_123c_count ';
        $sql .= ' FROM `pre_member` ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY m_id ) m ';
        $sql .= ' ORDER BY m_123c_count DESC, m_1c_count DESC, m_2c_count DESC, m_3c_count DESC ';
        $sql .= $this->formatLimitSql($index,$count);
        //Libs_Log_Logger::outputLog($sql);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getMemberBySubordinateList($where,$index,$count){
        $sql  = ' SELECT m.*';
        $sql .= ' FROM (SELECT *,sum(m_1c_count+m_2c_count+m_3c_count) m_123c_count ';
        $sql .= ' FROM `pre_member` im';
        $sql .= ' LEFT JOIN pre_applet_member_extra ame ON ame.ame_m_id = im.m_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY m_id ) m ';
        $sql .= ' ORDER BY m_123c_count DESC, m_1c_count DESC, m_2c_count DESC, m_3c_count DESC ';
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getMemberBySubordinateRow($where){
        $sql  = ' SELECT m.*';
        $sql .= ' FROM (SELECT *,sum(m_1c_count+m_2c_count+m_3c_count) m_123c_count ';
        $sql .= ' FROM `pre_member` im';
        $sql .= ' LEFT JOIN pre_applet_member_extra ame ON ame.ame_m_id = im.m_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY m_id ) m ';
        $sql .= ' ORDER BY m_123c_count DESC, m_1c_count DESC, m_2c_count DESC, m_3c_count DESC ';
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCopartnerCount($where){
        $sql  = ' SELECT count(*)';
        $sql .= ' FROM `pre_member` m';
        $sql .= ' LEFT JOIN pre_applet_member_extra ame ON ame.ame_m_id = m.m_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取招聘小程序会员列表
     */
    public function getJobMemberList($where,$index,$count,$sort){
        $sql  = ' SELECT m.*,ajr_id';
        $sql .= ' FROM '.DB::table($this->_table).' m ';
        $sql .= ' LEFT JOIN pre_applet_job_resume ajr ON ajr_m_id = m_id ';

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


    /*
     * 修改会员编号(废弃不再使用)
     */
    public function updateMemberShowId($sid,$mid) {
        //获取当前店铺最大的会员展示值
        $sql = "SELECT MAX(`m_show_id`) FROM `{$this->member_table}` WHERE `m_s_id` = {$sid}";

        $max_id = DB::result_first($sql);
        $max_id = $max_id ? intval($max_id)+1 : 1;

        $update['m_show_id'] = $max_id;
        return $this->updateById($update,$mid);
    }

    public function fetchMemberShowMax($sid){
        $sql = "SELECT MAX(`m_show_id`) FROM `{$this->member_table}` WHERE `m_s_id` = {$sid}";
        $max_id = DB::result_first($sql);
        return intval($max_id);
    }

    /*
     * 修改店铺会员的id值
     */
    public function newUpdateMemberShowId($mid,$max) {
        $update['m_show_id'] = $max;
        return $this->updateById($update,$mid);
    }

    /*
     * 根据条件查询会员总数
     */
    public function fetchMemberCount($where){
        $sql = "SELECT COUNT(`m_id`) FROM `{$this->member_table}` ";
        $sql .= $this->formatWhereSql($where);
        $count = DB::result_first($sql);
        return intval($count);
    }

    /*
     * 获得会员列表 关联社区团购团长表
     */
    public function getMemberLeaderList($where,$index,$count,$sort){
        $sql = "SELECT m.*,asl.*,ame.ame_cate ";
        $sql .= " FROM ".DB::table($this->_table)." m ";
        $sql .= " LEFT JOIN `pre_applet_sequence_leader` asl on m.m_id=asl.asl_m_id ";
        $sql .= " LEFT JOIN `pre_applet_member_extra` ame on m.m_id=ame.ame_m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得会员列表 关联社区团购团长表
     */
    public function getMemberLeaderListNew($where,$index,$count,$sort,$test = false){
        $sql = "SELECT m.*,asl.*,ame.ame_cate ";
        $sql .= " FROM ".DB::table($this->_table)." m ";
        $sql .= " LEFT JOIN `pre_applet_sequence_leader` asl on m.m_id=asl.asl_m_id ";
        $sql .= " LEFT JOIN `pre_applet_member_extra` ame on m.m_id=ame.ame_m_id ";
        $sql .= $this->formatWhereSql($where);

        // 调整慢sql 调整
        // zhangzc
        // 2019-09-04 
        $sql=sprintf('SELECT * FROM(%s) AS member_temp',$sql);

        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($test){
            Libs_Log_Logger::outputLog($sql,'test.log');
        }
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得会员数量 关联社区团购团长表
     */
    public function getMemberLeaderCount($where){
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." m ";
        $sql .= " LEFT JOIN `pre_applet_sequence_leader` asl on m.m_id=asl.asl_m_id ";
        $sql .= " LEFT JOIN `pre_applet_member_extra` ame on m.m_id=ame.ame_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getMemberLeaderRow($mid){
        $where      = array();
        $where[]    = array('name' => 'm_id', 'oper' => '=', 'value' => $mid);
        $sql = "SELECT * ";
        $sql .= " FROM ".DB::table($this->_table)." m ";
        $sql .= " LEFT JOIN `pre_applet_sequence_leader` asl on m.m_id=asl.asl_m_id ";
        $sql .= " LEFT JOIN `pre_applet_member_extra` ame on m.m_id=ame.ame_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得单条用户信息 关联额外表
     */
    public function getMemberExtraRow($mid){
        $where      = array();
        $where[]    = array('name' => 'm_id', 'oper' => '=', 'value' => $mid);
        $sql = "SELECT * ";
        $sql .= " FROM ".DB::table($this->_table)." m ";
        $sql .= " LEFT JOIN `pre_applet_member_extra` ame on m.m_id=ame.ame_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得用户数量 关联额外表
     */
    public function getMemberExtraCount($where,$test = 0){
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." m ";
        $sql .= " LEFT JOIN `pre_applet_member_extra` ame on m.m_id=ame.ame_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
//        if($test){
//            Libs_Log_Logger::outputLog($sql,'test.log');
//        }
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得用户信息列表 关联额外表
     */
    public function getMemberExtraList($where,$index,$count,$sort){
        $sql = "SELECT m.*,ame.ame_cate ";
        $sql .= " FROM ".DB::table($this->_table)." m ";
        $sql .= " LEFT JOIN `pre_applet_member_extra` ame on m.m_id=ame.ame_m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得用户信息列表 关联额外表
     */
    public function getMemberExtraListNew($where,$index,$count,$sort,$test = 0){
        $sql = "SELECT m.*,ame.ame_cate ";
        $sql .= " FROM ".DB::table($this->_table)." m ";
        $sql .= " LEFT JOIN `pre_applet_member_extra` ame on m.m_id=ame.ame_m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);

        if($test){
            Libs_Log_Logger::outputLog($sql,'test.log');
        }

        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getMemberCountTime($where,$time = ''){
        if($time == 'today'){
            $timestep = strtotime(date('Y-m-d'));
            $where[] = " (unix_timestamp(m_follow_time) > {$timestep}) ";
        }
        if($time == '7days'){
            $timeStep_0 = strtotime(date('Y-m-d',(time() - 86400*7)));
            //当天24点时间戳
            $timeStep_24 = strtotime(date('Y-m-d',time())) + 86400;
            $where[] = " (unix_timestamp(m_follow_time) > {$timeStep_0} AND unix_timestamp(m_follow_time) < {$timeStep_24}) ";
        }
        return $this->getCount($where);
    }

    /*
     * 获得分销统计信息
     */
    public function getThreeStatInfo($where){
        $sql = "SELECT count(*) as total,sum(m_sale_amount) as sale,sum(m_deduct_amount) as deduct ";
        $sql .= " FROM ".DB::table($this->_table)." m ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
 * 获得分销统计信息
 */
    public function getDistribStatInfo($where){
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." m ";
        $sql .= " LEFT JOIN `pre_member_relation` mr on m.m_id=mr.mr_s_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 会员积分统计
     */
    public function memberPointsStatistic($where){
        $sql = "SELECT sum(m_points) as points ";
        $sql .= " FROM ".DB::table($this->_table)." ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据条件获取每天用户数量
     */
    public function fetchNumGroupByDate($where){
        $sql  = " SELECT COUNT(*) AS total, FROM_UNIXTIME(`follow_time`,'%m/%d') AS curr_date  ";
        $sql .= " FROM (SELECT *,UNIX_TIMESTAMP(`m_follow_time`) AS  follow_time FROM  `pre_member` ";
        $sql .= $this->formatWhereSql($where);
        $sql .= ' ) AS new_member ';
        $sql .= ' GROUP BY curr_date ';
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 字段的自增与自减操作
     * @param  array  $field [description]
     * @param  array  $inc   [description]
     * @param  array  $where [description]
     * @return [type]        [description]
     */
    public function incrementField($field=[],$inc=[],$where=[]){
        $sql=$this->formatIncrementSql($field,$inc,$where);
        return DB::query($sql);
    }



    /**
     * 收银台会员列表
     * zhangzc
     * 2019-09-10
     * @param  [type]  $where [description]
     * @param  integer $index [description]
     * @param  integer $count [description]
     * @param  array   $sort  [description]
     * @param  array   $fields [description]
     * @param  array   $with_card [是否关联会员卡表]
     * @return [type]         [description]
     */
    public function cashierMemberList($where,$index=0,$count=15,$sort=[],$fields=[],$with_card=0){
        // 关联会员卡执行自定义sql
        // 会员卡号查询为精准查询，只会出现一条数据不需要进行分页处理
       
        $sql=sprintf('SELECT %s FROM %s 
            LEFT JOIN `pre_member_level` ON `ml_id`=`m_level` ',
            $this->getFieldString($fields),
            DB::table($this->_table)
        );
        if($with_card){
            $sql.= '  LEFT JOIN `pre_offline_member` ON `om_m_id`=`m_id` ';
        }
        $sql.=$this->formatWhereSql($where);
        if($with_card){ 
            $res=DB::fetch_first($sql);
            $list[0]=$res;
        }else{
            $sql.=$this->getSqlSort($sort);
            $sql.=$this->formatLimitSql($index,$count);
            $res=DB::fetch_all($sql);
            $list=$res;
        }
        if($res===false){
            trigger_error('mysql query failed',E_USER_ERROR);
        }
        return $list;
    }

}