<?php 

class App_Controller_Wxapp_ConfigsController extends App_Controller_Wxapp_InitController{
	public function __construct(){
		parent::__construct();
        if(!in_array($this->wxapp_cfg['ac_type'],[32,36])){
            plum_url_location('当前页面无访问权限');
        }
	}

	 
    public function ConfigAction(){
        $this->buildBreadcrumbs([
            ['title' => '系统配置.', 'link' => '#'],
        ]);
        $configs    =   plum_get_config('config');
        $sequence   =   $configs['configs']['sequence'];
        $allows     =   $configs['allow'];

        try{
            $config_values=$this->getAllConfigValues($allows);
            $this->getConfigDataSources($sequence, $config_values);
        }catch(Exception $e){
            $this->displayJsonError($e->getMessage());
        }
        $this->output['configs']=str_replace("'","*&^%$",json_encode($sequence,JSON_UNESCAPED_UNICODE));

        $this->output['config_values']=str_replace("'","*&^%$",json_encode($config_values,JSON_UNESCAPED_UNICODE));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/configs/config.tpl');
    }

    
    public function saveConfigAction(){
        $http_data=$_POST;
        unset($http_data['sub_dir']);
        unset($http_data['ke_textarea_name']);
        $fields_values=[];
        foreach ($http_data as $key => $value) {
            $table_field=explode('|', $key);
            $fields_values[$table_field[0]][$table_field[1]]=$value;
        }
        $configs    =   plum_get_config('config');
        $sequence   =   $configs['configs']['sequence'];
        $allows     =   $configs['allow'];
        try{
            $config_fields=$this->getConfigDefaultFields($sequence,$fields_values);
        	DB::$db->cur_link->begin_transaction();
            foreach ($config_fields as $tk => $tv) {
                $model_name     =$allows[$tk]['modal'];
                $allow_fields   =$allows[$tk]['fields'];
                $update_insert  =$allows[$tk]['updateinsert'];
                $tv[$allows[$tk]['forupdate']]=time();
                foreach ($tv as $k => $v) {
                    if(!in_array($k,$allow_fields) && $k!=$allows[$tk]['forupdate'])
                        throw new Exception(sprintf('字段：%s 未注册',$k));
                }
                if(!class_exists($model_name))
                    throw new Exception("数据模型不存在", 500);

                $model = new $model_name($this->curr_sid);
                if(isset($update_insert)){
                    $is_exist=$model->findUpdateBySid();
                }else{
                    $is_exist=true;
                }
                if($is_exist)
                    $exec=$model->findUpdateBySid($tv);
                else{
                    $tv[$update_insert]=$this->curr_sid;
                    $exec=$model->insertValue($tv);
                }
                if(!isset($exec)){
                    throw new Exception("保存失败",500);
                }

            }
            DB::$db->cur_link->commit();
            App_Helper_OperateLog::saveOperateLog("设置信息保存成功");

            $this->showAjaxResult($exec,'保存');
        }catch(Exception $e){
        	if($e->getCode()==500)
        		DB::$db->cur_link->rollback();
            $this->displayJsonError($e->getMessage());
        }
    }

    
    private function getAllConfigValues($allows=[]){
        $config_values=[];
        foreach ($allows as $table_name => $table_value) {
            $model_name=$table_value['modal'];
            if(!class_exists($model_name))
                throw new Exception("数据模型不存在", 500);

            $model          = new $model_name($this->curr_sid);
            $fields         = $table_value['fields'];

            $fields_values  = $model->findUpdateBySid([],$fields);
            if(!isset($fields_values))
                throw new Exception("未查询到相关配置信息", 1);
            foreach ($fields_values as $key => $value) {
                if($value==='1' || $value==='0')
                    $value=intval($value);
                $config_values[$table_name.'|'.$key]=$value;
            }
        }
        return $config_values;
    }

    
    private function getConfigDataSources(&$sequence, $config_values){
        foreach ($sequence as $key => $value) {
            $list=$value['list'];
            foreach ($list as $k => $v) {
                $fields=$v['values'];
                foreach ($fields as $fk => $fv) {
                    if($fv['type']=='select' || $fv['type']=='selectUnion'){
                    	$source=$fv['source'];
                    	if(!method_exists(__CLASS__,$source))
                    		throw new Exception(sprintf('方法：%s 未定义',$source));
                        $sequence[$key]['list'][$k]['values'][$fk]['sourceData']=$this->$source();
                    }elseif($fv['type']=='imgupload' || $fv['type']=='richtext'){
                    	$sequence[$key]['list'][$k]['values'][$fk]['sourceData']= $config_values[$fv['table'].'|'.$fv['field']];
                    }
                }
            }
        }
    }

    
    private function getConfigDefaultFields($sequence,$fields_values){
        $table_fields=[];
        foreach ($sequence as $key => $value) {
            $list=$value['list'];
            foreach ($list as $k => $v) {
                $fields=$v['values'];
                $label=$v['name'];
                foreach ($fields as $fk => $fv) {
                    $type=$fv['type'];
                    $field=$fv['field'];
                    $table=$fv['table'];
                    $require=$fv['require'];
                    if($type=='selectUnion'){
                        $this->dataTypeRequires($label,$require,$fields_values[$table][$field]);
                        $this->dataTypeRequires($label,$require,$fields_values[$table][$fv['field2']]);
                        
                    	$table_fields[$table][$field]=$fields_values[$table][$field];
                    	$table_fields[$table][$fv['field2']]=$fields_values[$table][$fv['field2']];
                    }else if(isset($fields_values[$table][$field])){
                        $this->dataTypeRequires($label,$require,$fields_values[$table][$field]);
                        $table_fields[$table][$field]=$fields_values[$table][$field];
                    }else{
                        $table_fields[$table][$field]=($type=='switch'?0:'');
                    }
                }
            }
        }
        return $table_fields;
    }

    
    private function dataTypeRequires($name,$require,$field){
        switch ($require) {
            case 'int':
                if(!empty($field) && !is_numeric($field))
                    throw new Exception($name.'应为数字类型！');                    
                break;
            case 'string':
                if(!is_string($field))
                    throw new Exception($name.'应为字符类型！');  
                break;
            default:
                # code...
                break;
        }
    }

    
    private function getLinkSource(){ 	
        $linkType = plum_parse_config('link_type','system');
        unset($linkType[3]);
        $groupType = plum_parse_config('link_type_sequence','system');
        $linkType=array_merge($linkType,$groupType);
        $return_list=[];
        foreach ($linkType as $key => $value) {
        	switch ($value['id']) {
        		case '1':
        			$data_value=$this->_shop_information();
        			break;
        		case '2':
        			$data_value=$this->_linklist();
        			break;
        		case '3':
        			$data_value='plum_text';
        			break;
        		case '32':
        			$data_value=$this->_information_category();
        			break;
        		case '5':
        			$data_value=$this->_goods_list();
        			break;
        		case '23':
        			$data_value=$this->_goods_category_first();
        			break;
        		case '9':
        			$data_value=$this->_goods_category_second();
        			break;
        		default:
        			$data_value=[];
        			break;
        	}
    		$return_list[]=[
        		'key'		=>$value['name'],
        		'value'		=>$value['id'],
        		'data_value'=>$data_value,
        	];

        }
        return $return_list;
    }
    
    private function _shop_information(){
        $where[]       = ['name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid];
        $where[]       = ['name'=>'ai_deleted','oper'=>'=','value'=>0];
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort          = ['ai_create_time' => 'DESC'];
        $list          = $information_storage->getList($where,0,50,$sort,['ai_id','ai_title']);
        $data = [];
        if($list){
            foreach ($list as $val){
                $data[] = [
                    'value'      => $val['ai_id'],
                    'key'   	 => $val['ai_title'],
                ];
            }
        }
        return $data;
    }
    
    private function _linklist(){
    	$linkList = plum_parse_config('link','system');
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        $data=[];
        foreach ($link as $key => $value) {
        	$data[] = [
                'value'      => $value['path'],
                'key'   	 => $value['name'],
            ];
        }
        return $data;
    }
    
    private function _information_category(){
        $data = array();
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $where[] = array('name'=>'aic_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>'aic_s_id','oper'=>'=','value'=>$this->curr_sid);
        $list = $category_storage->getList($where,0,0,array('aic_create_time'=>'DESC'),['aic_id','aic_name']);
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'value' => $val['aic_id'],
                    'key'   => $val['aic_name']
                );
            }
        }
        return $data;
    }
    
    private function _goods_list(){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,50,'',0,[],[],0,0,0);
        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = array(
                    'value'   => $val['g_id'],
                    'key'    => $val['g_name'],
                );
            }
        }
        return $data;
    }
    
    private function _goods_category_first(){
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $list = $kind_model->getAllFirstCategory();
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'value'   	=> $val['sk_id'],
                    'key' 		=> $val['sk_name']
                );
            }
        }
        return $data;
    }
    
    private function _goods_category_second(){
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $list = $kind_model->getAllSonCategory();
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'value'     => $val['sk_id'],
                    'key' 		=> $val['sk_name']
                );
            }
        }
       return $data;
    }
    
    private function getPostAreaSource(){
        return [
         ['key'=>'全部','value'   =>0],
         ['key'=>'市级','value'   =>1],
         ['key'=>'县级','value'   =>2],
     ];
    }
}