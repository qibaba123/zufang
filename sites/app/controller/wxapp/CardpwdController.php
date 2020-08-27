<?php
/**
 * 卡密充值 营销插件
 * zhangzc
 * 2019-07-03
 */
class App_Controller_Wxapp_CardpwdController extends App_Controller_Wxapp_InitController{
	private $cardpwd_model= null;
	const PROMOTION_TOOL_KEY = 'kmcz';
	const FREE_LIST=['21','32']; //默认此插件不进行收费与开通检测的小程序类型
	public  function __construct(){
		parent::__construct();
		// 检查插件是否开通
		// update 如果是营销商城此插件免费开通
		// zhangzc
		// 2019-07-08
		if(!in_array($this->wxapp_cfg['ac_type'],self::FREE_LIST))
			$this->checkToolUsable(self::PROMOTION_TOOL_KEY);
		$this->cardpwd_model=new App_Model_Cardpwd_MysqlCardPwdRechargeStorage($this->curr_sid);
	}

    const excel_cfg = [
        'noUse' => [
            'info' => ['卡号','密码','面额','过期时间','备注'],
            'width' => [25,15,10,20,25],
            'num'  => ['A','B','C','D','E']
        ],
        'use' => [
            'info' => ['卡号','密码','面额','编号/昵称','使用时间','备注'],
            'width' => [25,15,10,25,25,20,25],
            'num'  => ['A','B','C','D','E','F','G']
        ],
    ];


	/**
	 * 首页列表
	 * @return [type] [description]
	 */
	public function indexAction(){
		$this->buildBreadcrumbs(array(
            array('title' => '卡密充值', 'link' => '#'),
        ));

		$page=$this->request->getIntParam('page');
		$search=$this->request->getStrParam('search','');
		$index=$this->count * $page;
		$status=$this->request->getIntParam('status',0);
		$where=[
			['name'	=>'acr_s_id','oper'=>'=','value'=>$this->curr_sid],
			['name'	=>'acr_status','oper'=>'=','value'=>$status],
			['name'	=>'acr_deleted','oper'=>'=','value'=>0],
		];
		//增加搜索
		//zhangzc
		//2019-10-31
		if(!empty($search)){
			$where[]=['name'=>'acr_code','oper'=>'=','value'=>$search];
		}
		$total=$this->cardpwd_model->getCount($where);
		$pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();

        $sort=['acr_create_time'=>'DESC','acr_id'=>'ASC'];
		$cards_list=$this->cardpwd_model->fetchListMember($where,$index,$this->count,$sort);
		$this->output['cards_list']=$cards_list;

		$this->displaySmarty('wxapp/cardpwd/cards-list.tpl');
	}
	/**
	 * 生成卡密数据
	 * @return [type] [description]
	 */
	public function createCardsAction(){
		$num=$this->request->getIntParam('num');
		$value=$this->request->getIntParam('value');
		$expire=$this->request->getStrParam('expire');
		$remark=$this->request->getStrParam('remark');
		if(!num)
			$this->displayJsonError('生成数量必须大于0');
		if(!num)
			$this->displayJsonError('生成数量必须大于0');
		if(!value)
			$this->displayJsonError('面额必须大于0');
		if(!strtotime($expire))
			$this->displayJsonError('过期时间格式不正确');

		// 批量生成券码
		for($i=0;$i<$num;$i++){
			$card=[
				'acr_s_id'			=>$this->curr_sid,
				'acr_code'			=>plum_random_code(16,false),
				'acr_pwd'			=>plum_random(6,true), //生成纯数字6位密码
				'acr_value'			=>$value,
				'acr_expire_time'	=>strtotime($expire),
				'acr_create_time'	=>time(),
				'acr_remark'		=>$remark,
			];
			$res=$this->cardpwd_model->insertValue($card);
		}

		if($res){
            App_Helper_OperateLog::saveOperateLog("卡密信息生成成功");
        }

		$this->showAjaxResult($res,'创建');

	}
	/**
	 * 逻辑删除一张卡密数据
	 * @return [type] [description]
	 */
	public function deleteCardAction(){
		$card_id=$this->request->getIntParam('card_id');
		if(!$card_id)
			$this->displayJsonError('请选择要删除的卡片');
		$set=['acr_deleted'=>1];
		$where=[
			['name'=>'acr_s_id','oper'=>'=','value'=>$this->curr_sid],
			['name'=>'acr_id','oper'=>'=','value'=>$card_id],
			['name'=>'acr_status','oper'=>'=','value'=>0],
		];
		$card = $this->cardpwd_model->getRowById($card_id);
		$res=$this->cardpwd_model->updateValue($set,$where);
		if($res){
            App_Helper_OperateLog::saveOperateLog("删除卡号【{$card['acr_code']}】");
        }
		$this->showAjaxResult($res,'删除');
	}

	/**
	 * 批量导出数据
	 * @return [type] [description]
	 */
	public function exportCardAction(){
		require_once(PLUM_APP_PLUGIN.'/phpexcel/PHPExcel.php');
        $start = $this->request->getIntParam('start');
        $end  = $this->request->getIntParam('end');
        if($end<=$start)
        	// $this->displayJsonError('');
        	plum_url_location('开始编号不能小于结束编号');
        $count = $end-$start+1;
        $objPHPExcel = new PHPExcel();

        //设置属性
        $objPHPExcel->getProperties()
            ->setCreator("WOLF")
            ->setLastModifiedBy("WOLF")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
        $objActSheet = $objPHPExcel->setActiveSheetIndex(0); //填充表头
        $objActSheet->setCellValue('A1','卡号');
        $objActSheet->setCellValue('B1','密码');
        $objActSheet->setCellValue('C1','面额');
        $objActSheet->setCellValue('D1','过期时间');

        $where[] = array('name' => 'acr_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acr_status', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'acr_deleted', 'oper' => '=', 'value' => 0); 
        $sort = array('acr_create_time' => 'DESC','acr_id'=>'ASC');

        $list = $this->cardpwd_model->getList($where, $start-1, $count, $sort);
        //填充内容
        foreach ($list as $key=>$row){
            $time = $row['acr_expire_time']?date("Y/m/d H:i:s", $row['acr_expire_time']):'长期有效';
            // $objActSheet->setCellValue('A'.($key+2),$row['acr_code']);
            $objActSheet->setCellValueExplicit('A'.($key+2),$row['acr_code'],PHPExcel_Cell_DataType::TYPE_STRING);

            // $objActSheet->setCellValue('B'.($key+2),$row['acr_pwd']);
            $objActSheet->setCellValueExplicit('B'.($key+2),$row['acr_pwd'],PHPExcel_Cell_DataType::TYPE_STRING);
            $objActSheet->setCellValue('C'.($key+2),$row['acr_value']);
            $objActSheet->setCellValue('D'.($key+2),$time);
        }

        //4.输出
        $objPHPExcel->getActiveSheet()->setTitle('卡密充值数据');
        $objPHPExcel->setActiveSheetIndex(0);
        $day      = date("m-d");
        $filename = $day.'卡密充值数据.xls';
        ob_end_clean();//清除缓冲区,避免乱码
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
	}

	private function _card_pwd_list($type = 'noUse'){
	    $where = [];
        $where[] = array('name' => 'acr_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acr_deleted', 'oper' => '=', 'value' => 0);
        $sort = array('acr_create_time' => 'DESC','acr_id'=>'ASC');
        if($type == 'noUse'){
            $start = $this->request->getIntParam('start');
            $end  = $this->request->getIntParam('end');
            if($end<=$start){
                plum_url_location('开始编号不能小于结束编号');
            }
            $count = $end-$start+1;

            if($count >= 10000){
                plum_url_location('数据过多，请缩小范围');
            }
            $list = $this->cardpwd_model->getList($where, $start-1, $count, $sort);

        }else{
            $startDate = $this->request->getStrParam('start_date');
            $endDate  = $this->request->getStrParam('end_date');

            if(!$startDate || !$endDate){
                plum_url_location('请选择完整的日期');
            }

            $startTime = strtotime($startDate);
            $where[] = ['name' => 'acr_use_time', 'oper' => '>=', 'value' => $startTime];
            $endTime = strtotime($endDate);
            $where[] = ['name' => 'acr_use_time', 'oper' => '<=', 'value' => $endTime];
            $start = 1;
            $count = 0;
            $total = $this->cardpwd_model->getCount($where);
            if($total >= 10000){
                plum_url_location('数据过多，请缩小范围');
            }
            $list = $this->cardpwd_model->fetchListMember($where, $start-1, $count, $sort);
        }

        return $list;

    }

    /*
     * 未使用记录导出
     */
    public function excelNoUseAction() {
        $list = $this->_card_pwd_list('noUse');

        if($list){
            $rows = [];
            $rows[] = self::excel_cfg['noUse']['info'];
            $width = array_combine(self::excel_cfg['noUse']['num'],self::excel_cfg['noUse']['width']);
            foreach ($list as $key => $val){
                $rows[] = [
                    $val['acr_code'].' ',
                    $val['acr_pwd'].' ',
                    $val['acr_value'].' ',
                    date('Y/m/d H:i',$val['acr_expire_time']),
                    $val['acr_remark']
                ];
            }

            $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
            $day      = date("m-d");
            $filename = $day.'卡密充值未使用数据.xls';
            $excel->down_common_excel($rows,$filename,$width);

        }else{
            plum_url_location('查询范围内没有数据');
        }
    }

    /*
     * 已使用记录导出
     */
    public function excelUseAction() {
        $list = $this->_card_pwd_list('use');

        if($list){
            $rows = [];
            $rows[] = self::excel_cfg['use']['info'];
            $width = array_combine(self::excel_cfg['use']['num'],self::excel_cfg['use']['width']);
            foreach ($list as $key => $val){
                $rows[] = [
                    $val['acr_code'],
                    $val['acr_pwd'].' ',
                    $val['acr_value'].' ',
                    $val['m_show_id'].'/'.$this->utf8_orderstr_to_unicode($val['m_nickname']),
                    date('Y/m/d H:i',$val['acr_use_time']),
                    $val['acr_remark']
                ];
            }

            $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
            $day      = date("m-d");
            $filename = $day.'卡密充值已使用数据.xls';
            $excel->down_common_excel($rows,$filename,$width);

        }else{
            plum_url_location('查询范围内没有数据');
        }
    }

    /**
     * utf8字符转换成Unicode字符
     */
    private function utf8_orderstr_to_unicode($utf8_str) {
        $unicode_str = '';
        for($i=0;$i<mb_strlen($utf8_str);$i++){
            $val = mb_substr($utf8_str,$i,1,'utf-8');
            if(strlen($val) >= 4){
                $unicode = (ord($val[0]) & 0xF) << 18;
                $unicode |= (ord($val[1]) & 0x3F) << 12;
                $unicode |= (ord($val[2]) & 0x3F) << 6;
                $unicode |= (ord($val[3]) & 0x3F);
                $unicode_str.= '';
            }else{
                $unicode_str.=$val;
            }
        }
        $unicode_str = $this->_filter_character($unicode_str);
        return $unicode_str;
    }

    /*
     * 过滤掉昵称中特殊字符
     */
    private function _filter_character($nickname) {
        $nickname = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $nickname);
        $nickname = preg_replace('/[=]/u', '', $nickname);
        $nickname = str_replace(array('"','\''), '', $nickname);
        $nickname  = addslashes(trim($nickname));
        return $nickname;
    }
}