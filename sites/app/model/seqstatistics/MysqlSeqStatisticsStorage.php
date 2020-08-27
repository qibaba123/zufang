<?php
/**
 * [App_Model_Seqstatistics_MysqlSeqStatisticsStorage 社区团购 统计信息]
 * zhangzc
 * 2019-03-06
 */
class App_Model_Seqstatistics_MysqlSeqStatisticsStorage extends Libs_Mvc_Model_BaseModel
{
    public function __construct($sid=null){
        parent::__construct();
        $this->sid      = $sid;
        $this->trade_order_table	='pre_trade_order';
        $this->goods_table			='pre_goods';
        $this->trade_table 			='pre_trade';
		$this->member_table			='pre_member';
		$this->leader_table			='pre_applet_sequence_leader';
		$this->seq_goods_community_table='pre_applet_sequence_goods_community';
		$this->seq_community_table 	='pre_applet_sequence_community';
    }

    // 设置表名
    public function _table($table){
    	$this->_table=$table;
    }

    // 获取商品的销售排名
    // @param index 页码
    // @param sort 排序方式
    // @param count 每页要显示的数量
    // @param where 查询条件
    // @param  bool  $finish_only 只统计已完成的订单
    public function getGoodsRank($index, $sort=[], $count=50,$where='',$finish_only=FALSE,$g_name=''){
    	// 是不是统计不出来payment的值？
    	if($finish_only)
			$finish='6';
		else
			$finish='3,4,5,6';
        $sql=sprintf(
            'SELECT toder.`total`,toder.`num`,goods.`g_s_id`,goods.`g_price`,goods.`g_id`,goods.`g_name`,goods.`g_cover`,toder.`cost`  FROM `%s` AS goods
			LEFT JOIN (	SELECT SUM(`to_total`) as total,SUM(`to_num`) as num ,`to_g_id`,SUM(to_cost * to_num) as `cost` FROM `%s`
						LEFT JOIN `%s` on `to_t_id`=`t_id`
						WHERE `to_s_id`=%s and `t_status` in (%s) %s 
						GROUP BY `to_g_id`) AS toder
			ON goods.`g_id`=toder.`to_g_id`
			WHERE goods.`g_type` in(1,2) AND goods.`g_is_sale` in (1,2) AND goods.`g_deleted`=0 AND goods.`g_s_id`= %s %s ',
            $this->goods_table,
            $this->trade_order_table,
            $this->trade_table,
            $this->sid,
            $finish,
            $where,
            $this->sid,
            $g_name
        );

        $sql.=$this->getSqlSort($sort);
        $sql.=$this->formatLimitSql($index, $count);

        $res=DB::fetch_all($sql);
        if ($res===false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return;
        }
        return $res;
    }
	/**
	 * 商品转换率排行-浏览量与购买量
	 * @param  integer  $index 页码
	 * @param  integer $count 每页显示的数量
	 * @param  string $extra_where 额外的查询条件
	 * @param  bool  $finish_only 只统计已完成的订单
	 * @return array          数据集合
	 */
	public function getGoodsTrans($index,$count=50,$extra_where='',$finish_only=FALSE){
		if($finish_only)
			$finish='6';
		else
			$finish='3,4,5,6';
		$sql=sprintf('SELECT `g_id`,`g_name`,`g_cover`,torder.`num` AS num,`g_show_real_num`, num/`g_show_real_num` AS per FROM `pre_goods` AS goods
					LEFT JOIN (SELECT SUM(`to_num`) AS num,`to_g_id` FROM `pre_trade_order`
								LEFT JOIN `pre_trade` ON `to_t_id`=`t_id`
								WHERE `to_s_id`= %s AND `t_status` in (%s) %s 
								GROUP BY `to_g_id`) AS torder
					ON torder.`to_g_id`=goods.`g_id`
					WHERE goods.`g_type` IN(1,2) AND goods.`g_is_sale` IN(1,2) AND goods.`g_deleted`=0 AND goods.`g_s_id`=%d',
					$this->sid,
					$finish,
					$extra_where,
					$this->sid);
		$sql.=$this->getSqlSort(['per'=>'DESC']);
		$sql.=$this->formatLimitSql($index,$count);

		$res=DB::fetch_all($sql);
		if($res===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		return $res;
	}

    // 获取在售商品的总数量
    public function getGoodsCount($gname=''){
        $where=[
            ['name'=>'g_s_id','oper'=>'=','value'=>$this->sid],	//店铺id
            ['name'=>'g_type','oper'=>'in','value'=>[1,2]], 	//商品类型 1事物，2虚拟
            ['name'=>'g_is_sale','oper'=>'in','value'=>[1,2]],	//是否在售 1，在售，2未出售
            ['name'=>'g_deleted','oper'=>'=','value'=>0],		//未删除的商品
        ];
        if($gname)
        	$where[]=['name'=>'g_name','oper'=>'like','value'=>"'%{$gname}%'"];
        $this->_table='goods';
        $count=$this->getCount($where);
        $this->_table='';
        return $count;
    }
	/**
	 * 获取用户增长趋势
	 * @param  integer $date_type  时间粒度
	 * @param  integer $start_date 开始时间
	 * @param  integer $end_date  结束时间
	 * @return array             [description]
	 */
	public function getMemberIncre($date_type,$start_date,$end_date){
		$sql=sprintf('SELECT UNIX_TIMESTAMP(`m_follow_time`) AS m_follow_time,LEFT(`m_follow_time`,%s) AS formate_date,COUNT(*) AS num FROM %s
					WHERE `m_s_id`=%s AND UNIX_TIMESTAMP(`m_follow_time`) BETWEEN %s AND %s
					GROUP BY formate_date
					ORDER BY m_follow_time',
					$date_type,
					$this->member_table,
					$this->sid,
					$start_date,
					$end_date);
		$res=DB::fetch_all($sql);
		if($res===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		return $res;
	}

	/**
	 * 用户消费排行
	 * @param  integer $index 	页码
	 * @param  array $user 		用户信息查询数组 可以为用户名或手机号
	 * @param  string $orderby 	排序规则
	 * @param  integer $count 	每页显示的数量
	 * @param  bool $finish_only仅显示已完成订单
	 * @return [type]          [description]
	 */
	public function getMemberCost($index,$user,$orderby='total',$count=50,$finish_only=FALSE){
		if($finish_only)
			$finish=6;
		else
			$finish='3,4,5,6';
		$extra_where='';
		if($user){
			$extra_where=sprintf(' AND (`m_mobile` ="%s" OR `m_nickname` LIKE "%%%s%%") ',$user,$user);
			$index=0;
		}
		$sql=sprintf('SELECT `total`,`num`,`m_nickname`,`m_mobile`,`m_avatar`,`m_realname` FROM `%s` AS member
					LEFT JOIN (SELECT SUM(`t_payment`) AS total,COUNT(*) AS num,`t_m_id` FROM `%s`
								WHERE `t_s_id`=%s AND `t_status` IN (%s) GROUP BY `t_m_id`) AS trade
					ON `m_id`=trade.`t_m_id`
					WHERE `m_s_id`=%d %s
					ORDER BY `%s` DESC',
					$this->member_table,
					$this->trade_table,
					$this->sid,
					$finish,
					$this->sid,
					$extra_where,
					$orderby
				);
		$sql.=$this->formatLimitSql($index,$count);
		$res=DB::fetch_all($sql);
		if($res===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		return $res;
	}
	/**
	 * 获取店铺用户的数量
	 * @return [type] [description]
	 */
	public function getMemberCount(){
		$this->_table='member';
		$count=$this->getCount([
			['name'=>'m_s_id','oper'=>'=','value'=>$this->sid]
		]);
		$this->_table='';
		return $count;
	}
	/**
	 * 获取销售统计信息-年-月-日
	 * @param  	$format_date_show 		要显示的时间格式
	 * @param   $format_date_condition 	查询时使用的时间格式
	 * @param   $type 					查询类型销售额-销售量
	 * @param   $finish_only 			仅统计已完成订单
	 * @return
	 */
	public function getSale($format_date_show,$format_date_condition,$date,$type='total',$finish_only=FALSE){
		if($type=='total')
			$total=' SUM(`t_payment`) AS total ';
		else if($type=='count')
			$total=' COUNT(`t_payment`) AS total ';

		if($finish_only)
			$finish=6;
		else
			$finish='3,4,5,6';
		$sql=sprintf('SELECT `t_create_time`,FROM_UNIXTIME(`t_create_time`,"%s") AS dates, %s FROM `%s`
					WHERE `t_s_id`=%s AND FROM_UNIXTIME(`t_create_time`,"%s")="%s" AND `t_status` IN (%s) 
					GROUP BY dates',
				$format_date_show,
				$total,
				$this->trade_table,
				$this->sid,
				$format_date_condition,
				$date,
				$finish
			);
		$res=DB::fetch_all($sql);
		if($res===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		return $res;
	}

	/**
	 * [getSaleAnalysis 销售指标统计信息]
	 * @param  boolean $finish_only [仅统计已完成订单]
	 * @return [type]               [description]
	 */
	public function getSaleAnalysis($finish_only=FALSE){
		if($finish_only)
			$finish=[6];
		else
			$finish=[3,4,5,6];
		// 订单总金额
		$sql_money=sprintf('SELECT SUM(`t_payment`) AS total FROM %s
							WHERE `t_s_id`=%s  AND `t_status`  IN (%s)',
					$this->trade_table,
					$this->sid,
					implode(',',$finish));
		$money=DB::fetch_first($sql_money);
		if($money===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		// 总会员数
		$this->_table='member';
		$member_total=$this->getCount([
			['name'=>'m_s_id','oper'=>'=','value'=>$this->sid]
		]);
		$this->_table='';
		// 总访问次数
		$vist_sql=sprintf('SELECT SUM(`g_show_real_num`) AS total FROM %s
						WHERE `g_s_id`= %d',
			$this->goods_table,
			$this->sid);
		$vist=DB::fetch_first($vist_sql);
		if($vist===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		// 总订单量
		$this->_table='trade';
		$trade_total=$trade=$this->getCount([
			['name'=>'t_s_id','oper'=>'=','value'=>$this->sid],
			['name'=>'t_status','oper'=>'in','value'=>$finish] //已完成的订单
		]);
		$this->_table='';
		// 消费会员数
		$sql_consume_member=sprintf('SELECT COUNT(*) AS count FROM (
										SELECT sum(`t_payment`) FROM %s
										WHERE `t_s_id`=%d
										GROUP BY `t_m_id`
									) AS cm',
							$this->trade_table,
							$this->sid);
		$consume_member=DB::fetch_first($sql_consume_member);
		if($consume_member===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}

		return [
			'money'			=>$money['total'], 			//消费总金额
			'member_total'	=>$member_total,	//会员总数
			'vist'			=>$vist['total'],			//商品总访问次数
			'trade_total'	=>$trade_total,		//总订单数
			'consume_member'=>$consume_member['count'] 	//消费会员总数
		];
	}
	/**
	 * 团长销售排行
	 * @param  integer  $index   [description]
	 * @param  integer $count   [description]
	 * @param  string  $orderby [description]
	 * @param  bool  $finish_only [description]
	 * @return [type]           [description]
	 */
	public function getLeaderRank($index,$count=50,$orderby='money',$where='',$finish_only=FALSE){
		if($finish_only)
			$finish=6;
		else
			$finish='3,4,5,6';
		// 包含已被删除的团长
		$sql=sprintf('
			SELECT 	`asl_id`,
					`m_nickname`,
					`m_avatar`,`asl_name`,
					`asl_mobile`,
					`asl_percent`,
					`asl_deleted`,
					`total`,
					`money`
			FROM %s AS asl 
			LEFT JOIN (	SELECT t_se_leader,COUNT(*) as `total` ,SUM(t_payment) AS `money` FROM %s 
						WHERE `t_s_id`=%d and `t_status`IN (%s)  %s
						GROUP BY `t_se_leader`) AS trade 
			ON asl.`asl_id`=trade.`t_se_leader` 
			LEFT JOIN %s ON `m_id`=asl.`asl_m_id`
			WHERE `asl_status`=2 AND `asl_s_id`=%d 
			ORDER BY `asl_deleted`, %s DESC',
			$this->leader_table,
			$this->trade_table,
			$this->sid,
			$finish,
			$where,
			$this->member_table,
			$this->sid,
			$orderby);
		$sql.=$this->formatLimitSql($index,$count);
		$res=DB::fetch_all($sql);
		if($res===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		return $res;
	}
	/**
	 * 获取团长人数
	 * @return [type] [description]
	 */
	public function getLeaderCount(){
		$this->_table='applet_sequence_leader';
		$count=$this->getCount([
			['name'=>'asl_status','oper'=>'=','value'=>2],
			['name'=>'asl_s_id','oper'=>'=','value'=>$this->sid]
		]);
		$this->_table='';
		return $count;
	}
	/**
	 * * 获取团长共有商品的销售量
	 * @param  integer $leader_id 团长id
	 * @param  integer  $index    页码
	 * @param  integer $count     分页数默认50
	 * @return [type]             [description]
	 */
	public function getLeaderGoodsCommon($leader_id,$index,$count=20){
		$sql=sprintf('SELECT `g_id`,`g_name`,`g_cover`,`g_is_sale`,`g_deleted`,`g_stock`,`total` FROM %s 
					LEFT JOIN (SELECT `to_g_id`,SUM(`to_num`) AS total,`to_t_id` FROM %s 
								LEFT JOIN %s ON `t_id`=`to_t_id`
								WHERE `to_s_id`=%d AND `to_se_leader`=%d AND `t_status` in (3, 4, 5, 6)
								GROUP BY `to_g_id`) AS torder 
					ON `g_id`=`to_g_id` 
					WHERE `g_s_id`=%d AND `g_add_bed`=0 AND `g_deleted`=0
					ORDER BY `g_deleted`,`total` DESC,`g_stock` desc',
			$this->goods_table,
			$this->trade_order_table,
			$this->trade_table,
			$this->sid,
			$leader_id,
			$this->sid);
		$sql.=$this->formatLimitSql($index,$count);
		$res=DB::fetch_all($sql);
		if($res===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		return $res;
	}
	/**
	 * 获取团长的店铺下的限购商品的id
	 * @return [type] [description]
	 */
	public function getLeaderGoods($leader_id){
		$sql=sprintf('SELECT  `g_id`,`g_name`,`g_cover`,`g_is_sale`,`g_deleted`,
							 `g_stock` FROM `%s` 
					INNER JOIN (SELECT `asgc_g_id`
								FROM `%s`
								WHERE `asgc_c_id` IN(
									SELECT `asc_id`
								 	FROM `%s`
								 	WHERE `asc_s_id`= %d
								   	AND `asc_leader`= %d))  as a 
					ON `g_id` =asgc_g_id
					ORDER BY g_id ',
				$this->goods_table,
				$this->seq_goods_community_table,
				$this->seq_community_table,
				$this->sid,
				$leader_id);
		$res=DB::fetch_all($sql,[],g_id);
		if($res===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		return $res;

	}
	/**
	 * 获取指定团长才能限购的商品
	 * @param  [type] $leader_id 团长id
	 * @param  [type] $goods_id  商品ids
	 * @return [type]            [description]
	 */
	public function getLeaderGoodsLimited($leader_id,$goods_id){
		$sql=sprintf('SELECT `to_g_id`,SUM(to_num) AS total
				  	FROM `%s`
				  	LEFT JOIN `%s` on `t_id`= to_t_id
				 	WHERE `to_s_id`= %d
				   	AND `to_se_leader`= %d
				   	AND `to_g_id` in (%s)
				  	AND `t_status` in (3, 4, 5, 6)
				 	GROUP BY `to_g_id`',
				 $this->trade_order_table,
				 $this->trade_table,
				 $this->sid,
				 $leader_id,
				 $goods_id);
		$res=DB::fetch_all($sql,[],'to_g_id');
		if($res===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		return $res;
	}
	/**
	 * 获取团长基本信息
	 * @param  [type] $leader_id [description]
	 * @return [type]            [description]
	 */
	public function getLeaderInfo($leader_id){
		$sql=sprintf('SELECT  `asl_name`,`asl_mobile`, `m_nickname`,`m_avatar` FROM %s 
					LEFT JOIN %s ON `m_id` =`asl_m_id`
					WHERE `asl_id`=%d',
				$this->leader_table,
				$this->member_table,
				$leader_id);
		$res=DB::fetch_first($sql);
		if($res===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		return $res;
	}
	/**
	 * 获取团长商品订单列表
	 * @return [type] [description]
	 */
	public function getLeaderGoodsOrder($leader_id,$goods_id,$status='all',$index,$count=20){
		// 订单状态
		switch ($status) {
			case 'pay': //已付款 
				$where='and t_status=3';
				break;
			case 'finish':  //已完成
				$where='and t_status=6';
				break;
			case 'nopay': //待付款
				$where='and t_status=1';
				break;
			case 'all':
				$where='';
				break;
			default:
				$where='';
				break;
		}


		$sql=sprintf('SELECT `to_title` ,`to_pic` ,`t_tid` ,`t_total_fee`,
					`t_payment`,`t_status`,`t_create_time` FROM `%s`
					LEFT JOIN `%s`  on `to_t_id` =`t_id`
					WHERE `t_s_id` =%d AND `t_se_leader` =%d  AND `to_g_id` =%d %s ',
					$this->trade_table,
					$this->trade_order_table,
					$this->sid,
					$leader_id,
					$goods_id,
					$where);
		$sql.=$this->formatLimitSql($index,$count);
		$res=DB::fetch_all($sql);
		if($res===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		//计算总数量	
		$sql_count=$sql=sprintf('SELECT COUNT(*) AS total FROM `%s`
					LEFT JOIN `%s`  on `to_t_id` =`t_id`
					WHERE `t_s_id` =%d AND `t_se_leader` =%d  AND `to_g_id` =%d %s ',
					$this->trade_table,
					$this->trade_order_table,
					$this->sid,
					$leader_id,
					$goods_id,
					$where);
		$count=DB::fetch_first($sql_count);
		if($count===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		return ['res'=>$res,'count'=>$count];
	}
	/**
	 * 获取单个商品的详情信息
	 * @param  [type] $goods_id  商品id
	 * @return [type]            [description]
	 */
	public function getLeaderGoodsInfo($goods_id){
		$this->_table='goods';
		$res=$this->getRow([
			['name'=>'g_id','oper'=>'=','value'=>$goods_id],
			['name'=>'g_s_id','oper'=>'=','value'=>$this->sid]
		]);
		$this->_table='';
		return $res;
	}
	/**
	 * 获取团长单个商品 已完成数量，已付款数量，未付款数量
	 * @param  [type] $goods_id  [description]
	 * @param  [type] $leader_id [description]
	 * @return [type]            [description]
	 */
	public function getLeaderGoodsOrderCount($goods_id,$leader_id){
		$sql=sprintf('SELECT  `t_status`,count(*) as total FROM `%s`
					LEFT JOIN `%s`  ON `t_id`=`to_t_id`
					WHERE `t_s_id` =%d  AND  `t_se_leader` =%d   AND  `to_g_id` =%d 
					GROUP BY  t_status',
					$this->trade_table,
					$this->trade_order_table,
					$this->sid,
					$leader_id,
					$goods_id);
		$res=DB::fetch_all($sql);
		if($res===false){
			trigger_error("query mysql failed.", E_USER_ERROR);
			return;
		}
		foreach ($res as  $value) {
			$res['c_'.$value['t_status']]=$value;
		}
		return $res;
	}
}
