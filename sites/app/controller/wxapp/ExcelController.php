<?php


class App_Controller_Wxapp_ExcelController extends App_Controller_Wxapp_InitController
{

    public function __construct()
    {
        parent::__construct();
    }


    
    public function cityShopExportExcelAction(){
        $startDate  = $this->request->getStrParam('startDate');
        $endDate    = $this->request->getStrParam('endDate');
        $category    = $this->request->getIntParam('category');
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $sort  = array('acs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'acs_status', 'oper' => '=', 'value' => 2);
        if($startDate){
            $where[] = array('name' => 'acs_expire_time','oper' => '<=','value' =>strtotime($startDate));
        }
        if($endDate){
            $where[] = array('name' => 'acs_expire_time','oper' => '<=','value' =>strtotime($endDate));
        }
        if($category){
            $where[] = array('name' => 'acs_category_id','oper' => '=','value' =>$category);
        }
        $shopList = $shop_storage->fetchListMember($where, 0, 0, $sort);
        if($shopList){
            $category_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
            $category = $category_model->fetchCategoryListForSelect(false,false,false,0);
            $date       = date('Ymd',$_SERVER['REQUEST_TIME']);
            $rows    = array();
            $rows[]  = array('名称','类型','联系电话','联系地址','简介','标签','到期时间','加入时间');
            $width   = array(
                'A' => 30,
                'B' => 20,
                'C' => 30,
                'D' => 40,
                'E' => 50,
                'F' => 20,
                'G' => 30,
                'H' => 30,
            );
            foreach($shopList as $key => $val){
                $rows[] = array(
                    $val['acs_name'],
                    $category[$val['acs_category_id']],
                    $val['acs_mobile'],
                    $val['acs_address'],
                    $val['acs_brief'],
                    $val['acs_label'],
                    $val['acs_expire_time'] > 0 ? date('Y-m-d', $val['acs_expire_time']) : '无',
                    $val['acs_create_time'] > 0 ? date('Y-m-d', $val['acs_create_time']) : '无',
                );
            }
            $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
            $excel->down_common_excel($rows,$date.'入驻店铺信息导出.xls',$width);
        }else{
            plum_url_location('暂无入驻店铺');
        }
    }


    
    public function communityShopExportExcelAction(){
        $startDate  = $this->request->getStrParam('startDate');
        $category    = $this->request->getIntParam('category');
        $shop_storage = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        $sort  = array('es_createtime' => 'DESC');
        $where = array();
        $where[] = array('name' => 'es_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'es_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'es_status', 'oper' => '=', 'value' => 0);
        if($startDate){
            $where[] = array('name' => 'es_expire_time','oper' => '<=','value' =>strtotime($startDate));
        }

        if($category){
            $where[] = array('name' => 'es_cate2','oper' => '=','value' =>$category);
        }
        $shopList = $shop_storage->getShopMangerList($where,0,0,$sort);
        if($shopList){
            $category = $this->_get_select_category();
            $district= $this->_get_select_district();
            $date       = date('Ymd',$_SERVER['REQUEST_TIME']);
            $rows    = array();
            $rows[]  = array('店铺名称','负责人','登录账号','类型','联系电话','联系地址','所属商圈','标签','到期时间','加入时间');
            $width   = array(
                'A' => 20,
                'B' => 20,
                'C' => 20,
                'D' => 30,
                'E' => 20,
                'F' => 50,
                'G' => 30,
                'H' => 30,
                'I' => 30,
                'J' => 30,
            );
            foreach($shopList as $key => $val){
                $rows[] = array(
                    $val['es_name'],
                    $val['es_contact'],
                    $val['esm_mobile'],
                    $category[$val['es_cate1']].'--'.$category[$val['es_cate2']],
                    $val['es_phone'],
                    $val['es_addr'],
                    $district[$val['es_district2']]['area_name'].'--'.$district[$val['es_district2']]['name'],
                    $val['es_label'],
                    $val['es_expire_time'] > 0 ? date('Y-m-d', $val['es_expire_time']) : '无',
                    $val['es_createtime'] > 0 ? date('Y-m-d', $val['es_createtime']) : '无',
                );
            }
            $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
            $excel->down_common_excel($rows,$date.'入驻店铺信息导出.xls',$width);
        }else{
            plum_url_location('暂无入驻店铺');
        }


    }

    
    private function _parse_job_cfg_data($id, $name, $key='title', $type='jobcfg'){
        $cfg = plum_parse_config($name, $type);
        foreach ($cfg as $value){
            if($value['id'] == $id){
                return $value[$key];
            }
        }
        return false;
    }

    
    private function _get_select_category(){
        $category_model = new App_Model_Community_MysqlKindStorage($this->curr_sid);
        $category_list  = $category_model->getAllCategorySelect();
        return $category_list;
    }
    
    private function _get_select_district(){
        $district_model = new App_Model_Community_MysqlCommunityDistrictStorage($this->curr_sid);
        $district_list  = $district_model->getListBySid();
        $data = array();
        foreach($district_list as $val){
            $data[$val['acd_id']] = array(
                'name' => $val['acd_name'],
                'area_name' => $val['acd_area_name']
            );
        }
        return $data;
    }

}