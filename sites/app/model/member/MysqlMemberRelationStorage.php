<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/20
 * Time: 下午9:28
 */
class App_Model_Member_MysqlMemberRelationStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'member_relation';
        $this->_pk      = null;
    }

    /**
     * 添加新的会员关系
     * @param int $fid 父id
     * @param int $sid 子id
     */
    public function addNewMemberRelation($fid, $sid) {
        $data = array(
            'mr_f_id'   => $fid,
            'mr_s_id'   => $sid,
        );
        $this->insertValue($data);
    }

    /**
     * 清空会员关系
     */
    public function deletedMemberRelation($where, $isand=false){
        $sql = "delete from `".DB::table($this->_table)."` ";
        $sql .= $this->formatWhereSql($where,$isand);;
        return DB::query($sql);
    }
}