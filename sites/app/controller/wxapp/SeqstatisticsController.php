<?php
class App_Controller_Wxapp_SeqstatisticsController extends App_Controller_Wxapp_InitController{
    private $startThisMonth;
    private $endThisMonth;

    public function __construct(){
        parent::__construct();
        $this->count=50;
        // 统计信息model
        $this->seq_model=new App_Model_Seqstatistics_MysqlSeqStatisticsStorage($this->curr_sid);

        //本月时间戳
        $this->startThisMonth = strtotime(date('Y-m'));
        $this->endThisMonth = time();
    }

    /*-----------------------商品数据统计-----------------------*/

    /**
     * 商品转化率
     * @return [type] [description]
     */
    public function goodsTransAction(){
		// 设置面包屑
        $this->buildBreadcrumbs(array(
            array('title' => '商品转化率', 'link' => '#'),
        ));
        $page=$this->request->getStrParam('page');
        $index=$page*$this->count;
		$total=$this->seq_model->getGoodsCount();
        $this->output['showPage'] = $total > $this->count ? 1 : 0;
		// 分页
		$this->pagination($total);

		// 获取商品的排行数据
        $finish_only=$this->request->getIntParam('finish_only',0);   
        $where=$this->getDateGroupArgs('to_create_time');
		$trans_list=$this->seq_model->getGoodsTrans($index,50,$where,$finish_only);
        // if($this->curr_sid==9373){
        //     var_dump($trans_list);
        // }
        // 判断商品访问统计的细粒度设置项是否开启(及按照时间戳等信息进行归类划分)
        $cfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $cfg = $cfg_model->findUpdateBySid();
        $this->output['search_box']=$cfg['asc_goods_view_record'];
        if(isset($cfg['asc_goods_view_record']) && $cfg['asc_goods_view_record']==1){
            $view_time_where=$this->getDateGroupArgs('gvr_time',false);

            if($view_time_where){
                // 如果是选择了有where的数据的话 就循环查一下这个的数据，这样不影响原有的逻辑还是比较好的
                $goodsview_model=new App_Model_Sequence_MysqlSequenceGoodsViewRecordStorage($this->curr_sid);
                foreach ($trans_list as $key => $value) {
                    $view_where=[
                        ['name'=>'gvr_g_id','oper'=>'=','value'=>$value['g_id']],
                        ['name'=>'gvr_s_id','oper'=>'=','value'=>$this->curr_sid]
                    ];
                    $view_where[]=$view_time_where;
                    $views_count=$goodsview_model->getCount($view_where);
                    $trans_list[$key]['g_show_real_num']=$views_count;
                }
            }
        }

		$this->output['trans_list']=$trans_list;
		$this->displaySmarty('wxapp/seqstatistics/goods-trans.tpl');
    }
    /**
     * 商品销售排行
     * @return [type] [description]
     */
    public function goodsRankAction(){
        // 设置面包屑
        $this->buildBreadcrumbs(array(
            array('title' => '商品销售排行', 'link' => '#'),
        ));

        // 获取商品的列表根据销售总额进行排序
        $sort_word=$this->request->getStrParam('sort', 'total');
        $g_name   =$this->request->getStrParam('gname','');

        // 不管如何按时间排查都需要展示出来所有的商品
        $page=$this->request->getIntParam('page');
        $index=$page*$this->count;
        $total=$this->seq_model->getGoodsCount($g_name);
        $this->output['showPage'] = $total > $this->count ? 1 : 0;
        // 分页
        $this->pagination($total);

       

        if ($sort_word=='total') {
            $sort=['toder.total'=>'DESC'];
        } elseif ($sort_word=='num') {
            $sort=['toder.num'=>'DESC'];
        }
        // 按时间维度获取列表统计信息
        $where=$this->getDateGroupArgs('to_create_time');

        //添加按名称搜索
        //zhangzc
        //2019-09-04
        if($g_name){
            $where_name.=" AND goods.g_name like '%{$g_name}%' ";
        }else{
            $where_name='';
        }

        // 添加是否只显示已完成订单数据
        $finish_only=$this->request->getIntParam('finish_only',0);   
        $rank_list=$this->seq_model->getGoodsRank($index, $sort,50,$where,$finish_only,$where_name);
        $this->output['rank_list']=$rank_list;
        $this->displaySmarty('wxapp/seqstatistics/goods-rank.tpl');
        // 获取商品的列表根据销量进行排序
    }


    /**
     * 导出商品销售排行
     */
    public function goodsRankExcelAction(){

        // 不管如何按时间排查都需要展示出来所有的商品
//        $page=$this->request->getIntParam('page');
//        $index=$page*$this->count;
//        $total=$this->seq_model->getGoodsCount();
//        $this->output['showPage'] = $total > $this->count ? 1 : 0;
//        // 分页
//        $this->pagination($total);
        // 获取商品的列表根据销售总额进行排序
        $total_num = $this->request->getIntParam('total_num',50);
        $sort_word=$this->request->getStrParam('sort', 'total');
        $excel_type = $this->request->getIntParam('excel_type',1);

        $num_start = $this->request->getIntParam('num_start',0);
        $num_end = $this->request->getIntParam('num_end',0);

        if($excel_type == 2){
            $index = $num_start-1;
            $count = $num_end-$num_start;
            $start = $index;
        }else{
            $index = 0;
            $count = $total_num;
            $start = 0;
        }

        if ($sort_word=='total') {
            $sort=['toder.total'=>'DESC'];
        } elseif ($sort_word=='num') {
            $sort=['toder.num'=>'DESC'];
        }
        // 按时间维度获取列表统计信息
        $where=$this->getDateGroupArgs('to_create_time');
        // 添加是否只显示已完成订单数据
        $finish_only=$this->request->getIntParam('finish_only',0);
        $rank_list=$this->seq_model->getGoodsRank($index, $sort,$count,$where,$finish_only);
        if(!empty($rank_list)){
            $rows  = array();
            $rows[]  = array('排行','商品名称','销售量','销售额','总成本','订单收入','总利润');
            $width   = array(
                'A' => 10,
                'B' => 45,
                'C' => 15,
                'D' => 15,
                'E' => 15,
                'F' => 15,
                'G' => 15,
            );
            foreach ($rank_list as $key => $val){
                $cost = round($val['cost'],2);
                $total = round($val['total'],2);

                $rows[] = [
                    $key+1+$start,
                    $val['g_name'],
                    $val['num'],
                    $val['total'],
                    $cost,
                    $total,
                    round(($total-$cost),2),
                ];
            }
            $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
            $filename = '商品销售排行.xls';
            $excel->down_common_excel($rows,$filename,$width);
        }else{
            plum_url_location('当前条件内没有数据!');
        }

    }



    /*-----------------------会员数据统计-----------------------*/

    /**
     * 会员增长趋势 --默认计算七日的数据折线
     * 如果day参数不为空则粒度按照日期计算
     * 若只有year参数存在则按照选定的年份-粒度为当年的月份
     * 若year与month参数同时存在则计算当年月份中的所有的日期的粒度
     * @return [type] [description]
     */
    public function memberIncreaseAction(){
		// 设置面包屑
        $this->buildBreadcrumbs(array(
            array('title' => '会员增长趋势', 'link' => '#'),
        ));
		$day=$this->request->getIntParam('day');
		$year=$this->request->getIntParam('year');
		$month=$this->request->getIntParam('month');
		// 时间类型-开始时间-结束时间
		$date_type=10; //10位截取到日期 ;7位截取到月份
		$start_date=strtotime(date('Y-m-d'))-6*24*3600;
		$end_date=time();
		// 时间处理获取查询所需的时间戳
		if(!empty($day)){
			$start_date=strtotime(date('Y-m-d'))-($day-1)*24*3600;
			$end_date=time();
			$date_type=10;
		}else{
			if(!empty($year)&&empty($month)){ //只计算年份下的月份
				$start_date=strtotime($year.'0101000000');
				$end_date=strtotime($year.'1231235959');
				$date_type=7;
			}else if(!empty($year)&&!empty($month)){ //计算指定年份月份中每天的数据统计
				$temp_date=$year.'-'.str_pad($month,2,0,STR_PAD_LEFT);
				$start_date=strtotime($temp_date);
				$end_date=strtotime(date('Y-m-01', strtotime(date($temp_date))) . " +1 month -1 day");
				$date_type=10;
			}
		}
		// 生成一个完整的时间数组作为 时间diff的参照系
		$date_all=[];
		if($date_type==10){
			$index=$start_date;
			for ($index; $index <=$end_date; ) {
				$date_all[]=date('Y-m-d',$index);
				$index+=3600*24;
			}
		}else if($date_type==7){
			$date_all=[$year.'-01',$year.'-02',$year.'-03',$year.'-04',$year.'-05',$year.'-06',$year.'-07',$year.'-08',$year.'-09',$year.'-10',$year.'-11',$year.'-12'];
		}
		// 若传递的时间格式正确执行查询操作
		if($start_date){
			$member_incre=$this->seq_model->getMemberIncre($date_type,$start_date,$end_date);
			// 计算出与参照系的差集，用于补全数据库中为空的日期
			$date_diff=array_diff($date_all,array_column($member_incre,'formate_date'));
			$date_merge=[];
			foreach ($date_diff as $value) {
				$date_merge[]=[
					'm_follow_time'	=>strtotime($value),
					'formate_date' 	=>$value,
					'num'			=>0,
				];
			}
			$member_incre=array_merge($date_merge,$member_incre);
			array_multisort(array_column($member_incre,'m_follow_time'),SORT_ASC,SORT_NUMERIC,$member_incre);
			// 设置横轴
			$xaxis=array_column($member_incre,'formate_date');
			// 设置纵轴
			$yaxis=array_column($member_incre,'num');
		}

		$this->output['member_incre']['xaxis']=json_encode($xaxis);
		$this->output['member_incre']['yaxis']=json_encode($yaxis);
		$this->displaySmarty('wxapp/seqstatistics/member-incre.tpl');
	}
    // 会员消费排行统计 （排序-头像+昵称-姓名-手机号码-分组（等级）-消费金额-订单数）
	public function memberCostAction(){
		// 设置面包屑
        $this->buildBreadcrumbs(array(
            array('title' => '会员消费排名', 'link' => '#'),
        ));

        $page=$this->request->getIntParam('page');
        $index=$page*$this->count;
        $total=$this->seq_model->getMemberCount();
        $user=$this->request->getStrParam('user');
		$order=$this->request->getStrParam('orderby','ordercount');
        $this->output['showPage'] = $total > $this->count ? 1 : 0;
        // 分页
        if(!$user)
       		$this->pagination($total);
		$orderby='total';
		if($order=='ordercount')
			$orderby='num';
		else if($order=='ordermoney')
			$orderby='total';
        // 添加是否只显示已完成订单数据
        $finish_only=$this->request->getIntParam('finish_only',0);
		$cost_list=$this->seq_model->getMemberCost($index,$user,$orderby,50,$finish_only);
		$this->output['cost_list']=$cost_list;
		$this->displaySmarty('wxapp/seqstatistics/cost-rank.tpl');
	}

    /*-----------------------销售统计-----------------------*/

    /**
     * 销售额统计年-月-日
     * @return [type] [description]
     */
    public function saleAction(){
    	// 设置面包屑
        $this->buildBreadcrumbs(array(
            array('title' => '销售统计', 'link' => '#'),
        ));
        $type=$this->request->getStrParam('type');
        $type=in_array($type, ['total','count'])?$type:'total';
        $year=$this->request->getStrParam('year',date('Y',time()));
        $month=$this->request->getStrParam('month');
        $day=$this->request->getStrParam('day');

        // 月份格式显示
        $format_show='%Y-%m';
       	$formate_condition='%Y';						//以月份-默认
       	$date=is_numeric($year)?$year:date('Y',time());
       	if(empty($day)&&$month){   						//以日期
        	$format_show='%Y-%m-%d';
       		$formate_condition='%Y-%m';
       		$date=strtotime($year.'-'.$month)?date('Y-m',strtotime($year.'-'.$month)):0;
        }else if($month&&$day){							//以小时
        	$format_show='%Y-%m-%d %H';
       		$formate_condition='%Y-%m-%d';
       		$date=strtotime($year.'-'.$month.'-'.$day)?date('Y-m-d',strtotime($year.'-'.$month.'-'.$day)):0;
        }

        // 添加是否只显示已完成订单数据
        $finish_only=$this->request->getIntParam('finish_only',0);
        $sales=$this->seq_model->getSale($format_show,$formate_condition,$date?$date:date('Y',time()),$type,$finish_only);
        if($format_show=='%Y-%m'){ //补全月份
        	$date_all=[$year.'-01',$year.'-02',$year.'-03',$year.'-04',$year.'-05',$year.'-06',$year.'-07',$year.'-08',$year.'-09',$year.'-10',$year.'-11',$year.'-12'];
        }else if($format_show=='%Y-%m-%d'){//补全日期
        	$temp_date=$year.'-'.str_pad($month,2,0,STR_PAD_LEFT);
			$start=strtotime($temp_date);
			$end=strtotime(date('Y-m-01', strtotime(date($temp_date))) . " +1 month -1 day");
        	for ($start; $start <=$end; ) {
				$date_all[]=date('Y-m-d',$start);
				$start+=3600*24;
			}
        }else if($format_show=='%Y-%m-%d %H'){ //补全时间
        	$date_all=[];
        	for($i=0;$i<24;$i++){
        		$date_all[]=$year.'-'.str_pad($month,2,0,STR_PAD_LEFT).'-'.str_pad($day,2,0,STR_PAD_LEFT).' '.str_pad($i,2,0,STR_PAD_LEFT);
        	}
        }
        $date_diff=array_diff($date_all,array_column($sales,'dates'));
        $date_merge=[];
        foreach ($date_diff as  $value) {
        	 $date_merge[]=[
        	 	'dates'			=>$value,
        	 	'total'			=>0,
        	 	't_create_time'	=>strtotime(($format_show=='%Y-%m-%d %H')?$value.':00:00':$value)
        	 ];
        }
        $sales=array_merge($date_merge,$sales);
        array_multisort(array_column($sales,'t_create_time'),SORT_ASC,SORT_NUMERIC,$sales);
        $money=array_column($sales,'total');
        $max=max($money);
        $sum=array_sum($money);
        $this->output['sales']=$sales;
        $this->output['max']=$max;
        $this->output['sum']=$sum;
        $this->displaySmarty('wxapp/seqstatistics/sales.tpl');
    }
    /**
     * 销售指标
     * @return [type] [description]
     */
    public function saleAnalysisAction(){
    	// 设置面包屑
        $this->buildBreadcrumbs(array(
            array('title' => '销售指标统计', 'link' => '#'),
        ));
        // 添加是否只显示已完成订单数据
        $finish_only=$this->request->getIntParam('finish_only',0);  
    	$analysis_data=$this->seq_model->getSaleAnalysis($finish_only);
    	$this->output['analysis_data']=$analysis_data;
    	$this->displaySmarty('wxapp/seqstatistics/sales-analysis.tpl');
    }
    /**
     * 订单统计
     * @return [type] [description]
     */
    public function orderAction(){

    }

    /*-----------------------团长信息统计-----------------------*/

    //
    /**
     * 单个团长销售订单统计
     * @return [type] [description]
     */
    public function leaderOrderAction(){
    	// 设置面包屑
        $this->buildBreadcrumbs(array(
            array('title' => '团长销售订单统计', 'link' => '#'),
        ));

        $leader_id =$this->request->getIntParam('id',0);
        $page      =$this->request->getIntParam('page');
        $index     =$page*$this->count;
        // 根据订单类型获取数据
        $status    =$this->request->getStrParam('status','all');
        $order_id  =$this->request->getStrParam('order_id');



        // 社区区域合伙人
        $area_info=$this->get_area_manager();
        if($area_info){
            $leader_model=new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $leader_info=$leader_model->getLeaderRow($leader_id); 
            if($leader_info['asl_region_manager_id']!=$this->uid)
                plum_redirect_with_msg('无查看权限',$_SERVER['HTTP_REFERER'],true);
        }
        

        $where=[
    		['name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid],
    		['name'=>'t_se_leader','oper'=>'=','value'=>$leader_id],
   		// ['name'=>'t_status','oper'=>'=','value'=>6]  //已完成的订单
    	];
        if(!empty($order_id)){
            $where[]=['name'=>'t_tid','oper'=>'=','value'=>$order_id];
        }
        // 订单状态
		switch ($status) {
			case 'pay': //已付款 
				$where[]=['name'=>'t_status','oper'=>'=','value'=>3];
				break;
			case 'finish':  //已完成
				$where[]=['name'=>'t_status','oper'=>'=','value'=>6];
				break;
			case 'nopay': //待付款
				$where[]=['name'=>'t_status','oper'=>'=','value'=>1];
				break;
			case 'all':
				break;
			default:
				break;
		}
    	
    	$sort=['t_create_time'=>'DESC'];
    	$field=['t_tid','t_title','t_pic','t_num','t_total_fee','t_payment','t_pay_type','t_total_fee','t_finish_time','t_status'];

    	$this->seq_model->_table('trade');
    	$order_list=$this->seq_model->getList($where,$index,$this->count,$sort,$field);
    	$total=$this->seq_model->getCount($where);
    	$this->output['order_list']=$order_list;
    	$this->pagination($total);
    	$this->displaySmarty('wxapp/seqstatistics/leader-order.tpl');
    }
    /**
     * 团长所有商品统计--可以查看单个商品的销量-订单
     * @return [type] [description]
     */
    public function leaderGoodsAction(){
    	// 设置面包屑
        $this->buildBreadcrumbs(array(
            array('title' => '团长商品统计', 'link' => '#'),
        ));

        $leader_id=$this->request->getIntParam('id',0);

        // 社区区域合伙人
        $area_info=$this->get_area_manager();
        if($area_info){
            $leader_model=new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $leader_info=$leader_model->getLeaderRow($leader_id); 
            if($leader_info['asl_region_manager_id']!=$this->uid)
                plum_redirect_with_msg('无查看权限',$_SERVER['HTTP_REFERER'],true);
        }



        // 页面加上团长信息
        $leader_info=$this->seq_model->getLeaderInfo($leader_id);
        $this->output['leader_info']=$leader_info;
        $page=$this->request->getIntParam('page');
        $index=$page*20;
        $this->seq_model->_table('goods');
        // 分页
        $total=$this->seq_model->getCount([
        	['name'=>'g_s_id','oper'=>'=','value'=>$this->curr_sid],
        	['name'=>'g_add_bed','oper'=>'=','value'=>0],
        	['name'=>'g_deleted','oper'=>'=','value'=>0]
        ]);
        $this->seq_model->_table('');
        $this->pagination($total,20);

        $limited_goods=$this->seq_model->getLeaderGoods($leader_id);
        $goods_id=array_column($limited_goods,'g_id');
        $goods_id_str=$goods_id?implode(',', $goods_id):'-1';
    	$goods_order=$this->seq_model->getLeaderGoodsLimited($leader_id,$goods_id_str);
    	foreach ($limited_goods as $key => $value) {
    		$limited_goods[$key]['total']=$goods_order[$key]['total']?$goods_order[$key]['total']:0;
    	}
    	$goods_list=$this->seq_model->getLeaderGoodsCommon($leader_id,$index);
    	$this->output['goods_limited']=$limited_goods;
    	$this->output['goods_list']=$goods_list;
    	$this->displaySmarty('wxapp/seqstatistics/leader-goods.tpl');
    }
    //团长月份-年-近三日-周销售额-时间段选择
    /**
     * 团长销售排行-团长订单数量统计
     * @return [type] [description]
     */
    public function leaderRankAction(){
    	// 设置面包屑
        $this->buildBreadcrumbs(array(
            array('title' => '团长销售排行', 'link' => '#'),
        ));

        $page=$this->request->getIntParam('page');
        $index=$page*$this->count;
        $total=$this->seq_model->getLeaderCount();
        $this->output['showPage'] = $total > $this->count ? 1 : 0;
        $orderby=$this->request->getStrParam('orderby');
        $orderby=in_array($orderby,['money','total'])?$orderby:'money';

        $where=$this->getDateGroupArgs('t_create_time');

        $finish_only=$this->request->getIntParam('finish_only',0);
    	$leader_rank=$this->seq_model->getLeaderRank($index,$this->count,$orderby,$where,$finish_only);
    	$this->output['leader_rank']=$leader_rank;
    	$this->pagination($total);
    	$this->displaySmarty('wxapp/seqstatistics/leader-rank.tpl');
    }
    /**
     * 团长销售排行-数据导出
     * zhangzc
     * 2019-11-12
     * @return [type] [description]
     */
    public function leaderRankExportAction(){
        // 时间与订单状态筛选
        $start  =$this->request->getStrParam('start');
        $end    =$this->request->getStrParam('end');
        $finish_only=$this->request->getIntParam('order-status',0);
        $orderby='money';
        $where='';
        if($start && $end){
            $start=strtotime($start);
            $end=strtotime($end);
            if(!$start || !$end)
                $this->displayJsonError('时间格式不正确');
            $where=sprintf(' AND `t_create_time` >= %s AND `t_create_time` <=%s ',$start,$end);
        }
        
        $leader_rank=$this->seq_model->getLeaderRank(0,0,$orderby,$where,$finish_only);
        if(!$leader_rank)
            $this->displayJsonError('当前数据不存在，无法进行导出');
        foreach ($leader_rank as $key => $row) {
            $excel_row['m_nickname']   =$row['m_nickname'];
            $excel_row['asl_name']     =$row['asl_name'];
            $excel_row['asl_mobile']   =$row['asl_mobile'];
            $excel_row['asl_percent']  =$row['asl_percent'].'%';
            $excel_row['money']        =$row['money']?$row['money']:0;
            $excel_row['total']        =$row['total']?$row['total']:0;
            $excel_rows[]              =$excel_row; 
        }
        $filename   = sprintf('团长排行-%s-%s.xlsx',$this->curr_sid,rand());
        $plugin     = new App_Plugin_xlsxwriter_XLSXWriterPlugin($filename);
        $url        = $plugin->sequenceLeaderRankExport($excel_rows);
        if($url)
            $this->displayJsonSuccess(['url'=>substr($url, 1)]);
        else
            $this->displayJsonError('导出数据失败');
    }
    /**
     * 团长单个商品的订单统计信息
     * @return [type] [description]
     */
    public function leaderGoodsOrderAction(){
    	$leader_id=$this->request->getIntParam('l_id',0);
    	$goods_id=$this->request->getIntParam('g_id',0);
    	$status=$this->request->getStrParam('status','all');
    	// 分页
    	$page=$this->request->getIntParam('page');
        $index=$page*20;
        
        // 商品详情
        $goods_info=$this->seq_model->getLeaderGoodsInfo($goods_id);
        $this->output['goods_info']=$goods_info;
    	
    	// 该商品已付款的订单，已完成的订单，待付款的订单 统计加分类
    	$sum=$this->seq_model->getLeaderGoodsOrderCount($goods_id,$leader_id);
    	$this->output['sum']=$sum;
    	// 全部订单,已付款的订单,已完成的订单
    	$order_list=$this->seq_model->getLeaderGoodsOrder($leader_id,$goods_id,$status,$index);
    	$total=$order_list['count']['total'];
        $this->pagination($total,20);
    	$this->output['order_list']=$order_list['res'];
    	$this->displaySmarty('wxapp/seqstatistics/leader-goods-order.tpl');
    }

    /*-----------------------活动销售统计信息-----------------------*/
    // 活动订单销量统计
    // 活动中各个商品的销量统计

    /**
     * 分页
     * @param  integer $total [总页数]
     * @param  integer $count [每页显示的页数]
     * @return [type]         [description]
     */
    private function pagination($total, $count=50){
        $page_model=new Libs_Pagination_Paginator($total, $count, 'jquery', true);
        $this->output['paginator'] = $page_model->render();
    }

    /*
     * 小区排行榜
     */
    public function sequenceCommunityRankAction(){
        $page = $this->request->getIntParam('page');
        $sortType = $this->request->getStrParam('sortType','nums');
        $searchType = $this->request->getStrParam('searchType','all');

        $this->output['sortType'] = $sortType;
        $this->output['searchType'] = $searchType;
        $index = $this->count * $page;
        $start_date=$this->request->getStrParam('start');
        $end_date=$this->request->getStrParam('end');

        if($searchType == 'month'){
            $this->_get_sequence_statistic_month($index,$this->count,$sortType);
        }else{
            $where=[];
            if($start_date && strtotime($start_date)){
                $where[]=['name'=>'t_create_time','oper'=>'>=','value'=>strtotime($start_date)];
            }
            if($end_date && strtotime($end_date)){
                $where[]=['name'=>'t_create_time','oper'=>'<','value'=>strtotime($end_date)];
            }
           
            $this->_get_sequence_statistic_all($index,$this->count,$sortType,$where);
        }
        $this->buildBreadcrumbs(array(
            array('title' => '小区销售排行', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/seqstatistics/community-rank.tpl');

    }

    //社区团购小区排行统计
    private function _get_sequence_statistic_all($index,$count,$sortType='num',$where=[]){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = ['name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid];

        $where_this_month = $where_total = [];
        $where_total[] = $where_this_month[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);

        // 添加是否只显示已完成订单数据
        $finish_only=$this->request->getIntParam('finish_only',0);
        if($finish_only)
            $finish=[6];
        else
            $finish=[3,4,5,6];
        $where_total[] = $where_this_month[] = array('name'=>'t_status','oper'=>'in','value'=>$finish);

        $sort = ['nums' => 'desc'];
        if($sortType == 'num'){
            $sort = ['nums' => 'desc'];
        }elseif($sortType == 'total'){
            $sort = ['total' => 'desc'];
        }
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $total = $trade_model->sequenceCommunityRankStatisticCount($where_total);
        $this->pagination($total,$count);
        $this->output['showPage'] = $total > $this->count ? 1 : 0;
        // 如果传递的自定义查询的时间不为空的话
        if($where){
            $where_total=array_merge($where,$where_total);
        }
        $list = $trade_model->sequenceCommunityRankStatistic($where_total, $index, $count, $sort);

        $this->output['list'] = $list;
    }

    //社区团购统计
    private function _get_sequence_statistic_month($index,$count,$sortType='num'){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = ['name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid];



        // $where_this_month[] = array('name'=>'asc_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        // $where_this_month[] = array('name'=>'asc_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_this_month = $where_total = [];
        $where_total[] = $where_this_month[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);

        // 添加是否只显示已完成订单数据
        $finish_only=$this->request->getIntParam('finish_only',0);
        if($finish_only)
            $finish=[6];
        else
            $finish=[3,4,5,6];

        $where_total[] = $where_this_month[] = array('name'=>'t_status','oper'=>'in','value'=>$finish);
        $where_this_month[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $sort = ['nums' => 'desc'];
        if($sortType == 'num'){
            $sort = ['nums' => 'desc'];
        }elseif($sortType == 'total'){
            $sort = ['total' => 'desc'];
        }

        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $total = $trade_model->sequenceCommunityRankStatisticCount($where_this_month);
        $this->pagination($total,$count);
        $this->output['showPage'] = $total > $this->count ? 1 : 0;

        $list = $trade_model->sequenceCommunityRankStatistic($where_this_month, $index, $count, $sort);
        $this->output['list'] = $list;

    }


    /**
     * 区域合伙人管理者判断与城市信息获取
     * @return [type] [description]
     */
    private function get_area_manager(){
        $manager_model = new App_Model_Member_MysqlManagerStorage();
        $info=$manager_model->getSingleManagerWithArea($this->uid,$this->company['c_id']);
        if($info){
            return [
                'm_area_id'     =>$info['m_area_id'],
                'm_area_type'   =>$info['m_area_type'],
                'region_name'   =>$info['region_name'],
            ];
        }else{
            return null;
        }
    }
    

    /**
     * 通用的按时间维度生成where条件 ：昨日 今日 近7日 30天 以及 按照自定义时间
     * @param  [type] $field_name [字段名称]
     * @return [type]             [description]
     */
    private function getDateGroupArgs($field_name,$is_and=true){
        $start_date=$this->request->getStrParam('start');
        $end_date=$this->request->getStrParam('end');
        $start='';
        $end=time();
        if($start_date=='all'||$start_date=='')
            return '';
        switch ($start_date) {
            // 今日的时间
            case 'today':
                $start=strtotime(date('Ymd',time()));
                break;
            //昨日的时间 
            case 'yesterday':
                $start=strtotime(date('Ymd',time()-3600*24));
                $end=strtotime(date('Ymd',time()));
                break;
            // 一周的时间
            case 'week':
                $start=strtotime(date('Ymd',time()-3600*24*7));
                // $end=strtotime(date('Ymd',time()));
                break;
            // 近30日的时间
            case 'month':
                $start=strtotime(date('Ymd',time()-3600*24*30));
                // $end=strtotime(date('Ymd',time()));
                break;
            // 自定义查询时间
            default: //默认的情况下 直接使用时间值进行查询，传入时判断时间格式是否正确
                if($start_date==''){
                    return '';
                }
                $start=strtotime($start_date)?strtotime($start_date):0;
                //结束时间视为当天23:59:59  dn 2019-08-30
                $end=strtotime($end_date)?strtotime($end_date)+86399:0;
                break;
        }
        if(!$start||!$end){
            plum_redirect_with_msg('时间格式不正确',$_SERVER['HTTP_REFERER'],1);
        }
        if($is_and)
            $where=sprintf(' AND %s >= %d AND %s < %d ',
                $field_name,$start,$field_name,$end);
        else
            $where=sprintf('  %s >= %d AND %s < %d ',
                $field_name,$start,$field_name,$end);
        return $where;
    }
}
