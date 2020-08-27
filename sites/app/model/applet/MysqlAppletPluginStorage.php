<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletPluginStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_plugin_open';
        $this->_pk = 'apo_id';
        $this->_shopId = 'apo_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
      * 通过店铺id获取模版配置
      */
    public function findUpdateBySid($type,$data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'apo_plugin_id', 'oper' => '=', 'value' => $type);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    // 保存插件未开通是否可见
    public function savePluginShowStatus($plugin_id,$status){
        $this->_table='applet_plugin_show';
        // 查看如果是存在的话就修改，不存在的话就插入
        $where=[
            ['name'=>'aps_s_id','oper'=>'=','value'=>$this->sid],
            ['name'=>'aps_plugin_id','oper'=>'=','value'=>$plugin_id]
        ];
        $res=$this->getRow($where);
        if(!empty($res)){
            $data=[
                'aps_is_show'   =>$status,
                'aps_time'      =>time(),
            ];
            return $this->updateValue($data,$where);
        }else{
            $data=[
                'aps_is_show'   =>$status,
                'aps_time'      =>time(),
                'aps_s_id'      =>$this->sid,
                'aps_plugin_id' =>$plugin_id 
            ];
            return  $this->insertValue($data);
        }
    }

    // 查看插件可见状态列表
    public function getPluginShowList($where = array(), $index = 0, $count = 20, $sort = array(), $field = array(), $primary = false,$test=0){
        $this->_table='applet_plugin_show';
        $where[]=['name'=>'aps_s_id','oper'=>'=','value'=>$this->sid];
        return $this->getList($where, $index, $count, $sort, $field, $primary,$test);
    }
    // 获取单行的插件的数据
    public function getPluginOpenRow($where){
        $this->_table='applet_plugin_open';
        $where[]=['name'=>'apo_s_id','oper'=>'=','value'=>$this->sid];
        return  $this->getRow($where);
    }

    /**
     * 批量获取插件是否开通
     * @param  array  $ids [description]
     * @return [type]      [description]
     */
    public function getPlugsByIds($ids=[]){
        if(empty($ids))
            return null;
        $where[]    = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        $where[]    = ['name' => 'apo_plugin_id', 'oper' => 'in', 'value' => $ids];
        return $this->getList($where,0,0);
    }
}