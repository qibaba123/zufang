<?php

class App_Controller_Wxapp_SeqregionController extends App_Controller_Wxapp_GoodsController{
	private $manager_model;
	 const POWER='a:17:{i:0;s:11:"index-index";i:1;s:14:"sequence-trade";i:2;s:10:"trade-list";i:3;s:11:"refund-list";i:4;s:11:"verify-list";i:5;s:14:"sequence-goods";i:6;s:10:"goods-list";i:7;s:9:"goods-add";i:8;s:13:"sequence-area";i:9;s:9:"area-list";i:10;s:14:"community-list";i:11;s:18:"sequence-community";i:12;s:11:"leader-list";i:13;s:20:"sequence-prepareList";i:14;s:11:"refund-list";i:15;s:10:"plugin-cfg";i:16;s:15:"mall-sendMethod";}';
	 
	 const POWER_NO_LEADER = 'a:11:{i:0;s:11:"index-index";i:1;s:14:"sequence-trade";i:2;s:10:"trade-list";i:3;s:11:"refund-list";i:4;s:11:"verify-list";i:5;s:14:"sequence-goods";i:6;s:10:"goods-list";i:7;s:9:"goods-add";i:8;s:13:"sequence-area";i:9;s:9:"area-list";i:10;s:14:"community-list";}';

	const PROMOTION_TOOL_KEY = 'qyhhr';
	public function __construct(){
		parent::__construct();
		
		$this->manager_model=new App_Model_Member_MysqlManagerStorage();

		$this->output['seqregion'] = 1;


	}

    
    public function secondLink($type='list',$page_type=''){
        $link = array(
            array(
                'label' => '合伙人管理',
                'link'  => '/wxapp/seqregion/areaManager',
                'active'=> 'list'
            ),
            array(
                'label' => '商品审核',
                'link'  => '/wxapp/seqregion/goodsVerify',
                'active'=> 'goods'
            ),
            array(
                'label' => '小区审核',
                'link'  => '/wxapp/seqregion/communityVerify',
                'active'=> 'community'
            ),
        );

        $this->output['link'] = $link;
        $this->output['linkType'] = $type;
        $this->output['snTitle']  = '区域合伙人';
    }

    
    public function goodsVerifyAction(){
        $region_id = $this->request->getIntParam('region_id',0);//合伙人id  代表查看
        $this->secondLink('list');
        $table_menu = new App_Helper_TableMenu();
        $choseLink = $table_menu->showTableLink('sequenceGoodsVerify');
        if($region_id){
            $this->_show_goods_list_data(0,[],0,$region_id);
            $str = '合伙人商品';
        }else{
            $this->_show_goods_list_data(0,[],1);
            unset($choseLink[0]);unset($choseLink[1]);unset($choseLink[2]);unset($choseLink[3]);unset($choseLink[4]);
            $str = '商品审核';
        }
        $this->output['choseLink'] = $choseLink;
        $this->_show_category_type(0);

        $this->buildBreadcrumbs(array(
            array('title' => '区域合伙人', 'link' => '#'),
            array('title' => $str, 'link' => '#'),
        ));

        $this->displaySmarty("wxapp/goods/seq-goods-list-ajax.tpl");
    }


    
    public function communityVerifyAction(){
        $this->secondLink('community');
        $page = $this->request->getIntParam('page');
        $index = $page*$this->count;
        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        $where[] = array('name'=>'asc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $sort = array('asc_update_time'=>'DESC');

        $this->output['name'] = $this->request->getStrParam('name');
        if($this->output['name']){
            $where[] = array('name'=>'asc_name','oper'=>'like','value'=>"%{$this->output['name']}%");
        }
        $this->output['area'] = $this->request->getIntParam('area',0);
        if($this->output['area']){
            $where[] = array('name'=>'asc_area','oper'=>'=','value'=>$this->output['area']);
        }
        $this->output['leader'] = $this->request->getStrParam('leader');
        if($this->output['leader']){
            $where[] = array('name'=>'asl_name','oper'=>'like','value'=>"%{$this->output['leader']}%");
        }
        $this->output['verify_status'] = $this->request->getIntParam('verify_status',1);
        $where[] = ['name'=>'asc_status','oper'=>'=','value'=>$this->output['verify_status']];


        $total = $community_model->getCommunityLeaderCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pagination']   = $pageCfg->render();
        $list = $community_model->getCommunityLeaderList($where,$index,$this->count,$sort);
        $this->output['list'] = $list;
        $this->output['verify_list'] = 1;


        $this->_get_area_list();
        $this->buildBreadcrumbs(array(
            array('title' => '社区管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/community-list.tpl');
    }

    
    private function _get_area_list($return = false,$is_area=false,$area_type='C'){
        $data = array();
        $area_model = new App_Model_Sequence_MysqlSequenceAreaStorage($this->curr_sid);
        $where[] = array('name'=>'asa_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($is_area){
            if($area_type=='C')
                $where[]=['name'=>'asa_city','oper'=>'=','value'=>$is_area];
            else if($area_type=='D')
                $where[]=['name'=>'asa_zone','oper'=>'=','value'=>$is_area];
        }
        $sort = array('asa_create_time'=>'DESC');
        $list = $area_model->getListWithArea($where,0,0,$sort);
        if($list){
            foreach ($list as $val){
                $data[$val['asa_id']] = array(
                    'id' => $val['asa_id'],
                    'name' => $val['asa_name'],
                    'area'  =>$val['area'],
                );
            }
        }
        if($return){
            return $data;
        }else{
            $this->output['areaList'] = json_encode($data);
            $this->output['areaSelect'] = $data;
        }
    }

	
	public function areaManagerAction(){
        $this->secondLink('list');
		$area_info=$this->get_area_manager();
		if($area_info){
			plum_redirect_with_msg('无访问权限',$_SERVER['HTTP_REFERER'],true);
		}
        $this->buildBreadcrumbs(array(
            array('title' => '区域合伙人', 'link' => '#'),
            array('title' => '区域合伙人列表', 'link' => '#'),
        ));
		$page=$this->request->getIntParam('page');
		$index=$page*$this->count;

		$where=[
			['name'=>'m_c_id','oper'=>'=','value'=>$this->company['c_id']],
			['name'=>'m_area_status','oper'=>'=','value'=>1],
		];

		$mobile=$this->request->getIntParam('mobile');
		if($mobile){
			$where[]=['name'=>'m_mobile','oper'=>'=','value'=>$mobile];
		}

		$sort=['m_fid'=>'ASC'];
		$total=$this->manager_model->getCount($where);
		$this->output['host']=$_SERVER['HTTP_HOST'];
		$this->pagination($total);
		$manager_list=$this->manager_model->getListWithArea($where, $index, $this->count, $sort);
		$this->output['manager_list']=$manager_list;

		$cfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
		$seq_cfg = $cfg_model->findUpdateBySid();
		$this->output['seq_cfg'] = $seq_cfg;

		$this->displaySmarty('wxapp/seqregion/area-manager.tpl');
	}
	
	public function managerDisaledAction(){
        $area_info=$this->get_area_manager();
        if($area_info){
            plum_redirect_with_msg('无访问权限',$_SERVER['HTTP_REFERER'],true);
        }
		$result=[
		 	'ec' => 400,
            'em' => '参数请求错误'
        ];
		$mid=$this->request->getIntParam('mid');
		$status=$this->request->getStrParam('status');
		switch ($status) {
			case 'enable':
				$status_code=0;
				break;
			case 'disable':
				$status_code=2;
				break;
			default:
				$this->displayJson($result,1);
				break;
		}
		$set=['m_status' =>	$status_code];
		$where=[
			['name'=>'m_c_id','oper'=>'=','value'=>$this->company['c_id']],
			['name'=>'m_area_status','oper'=>'=','value'=>1],
			['name'=>'m_id','oper'=>'=','value'=>$mid]
		];
		$res=$this->manager_model->updateValue($set,$where);
		if($res){
			$result=[
				'ec'	=>200,
				'em'	=>'设置成功'
			];
		}else{
			$result=['em'=>'设置失败'];
		}
		$this->displayJson($result);
	}
	
	public function editSeqAreaManagerAction(){
        $area_info=$this->get_area_manager();
        if($area_info){
            plum_redirect_with_msg('无访问权限',$_SERVER['HTTP_REFERER'],true);
        }
		$post=$_POST;
		if($post){
			$mid=		$this->request->getIntParam('mid');
			$name=		$this->request->getStrParam('name');
			$city=		$this->request->getIntParam('city');
			$area=		$this->request->getIntParam('zone');
			$pass=		$this->request->getStrParam('pass');
			$memberId=  $this->request->getIntParam('memberId');
			$brokerage=	$this->request->getStrParam('brokerage',0);
			$c_brokerage=$this->request->getIntParam('c_brokerage',0);
            $area_type = 'D';
			$set=[
				'm_nickname'		=>$name,
				'm_area_type'		=>$area_type,
				'm_area_id'			=>$area && $area>0 ? $area : $city,
				'm_update_time'		=>time(),
				'm_area_brokerage'	=>$brokerage,
				'm_area_region_goods_brokerage'=>$c_brokerage,
			];
			$awhere=[
	            ['name'=>'m_area_status','oper'=>'=','value'=>1],
	            ['name'=>'m_c_id','oper'=>'=','value'=>$this->company['c_id']],
	            ['name'=>'m_area_id','oper'=>'=','value'=>$area]
			];
			if($mid){
				$awhere[]=['name'=>'m_id','oper'=>'!=','value'=>$mid];
			}
			$hasArea=$this->manager_model->getCount($awhere);
			if($hasArea){
				$result['em'] = '当前区域已被使用';
				$this->displayJson($result,1);
			}
			if($pass&&strlen($pass)<6){
				$result['em'] = '密码长度不能少于6位';
				$this->displayJson($result,1);
			}
			if(!is_numeric($brokerage)||$brokerage<0||$brokerage>100){
				$result['em'] = '平台商品佣金比例必须为非负数字,且比例不能大于100';
				$this->displayJson($result,1);
			}
			if(!is_numeric($c_brokerage)||$c_brokerage<0||$c_brokerage>100){
				$result['em'] = '自定义商品抽成比例必须为非负数字,且比例不能大于100';
				$this->displayJson($result,1);
			}
			if(!$area || !$city){
				$result['em'] = '未选择开通区域';
				$this->displayJson($result,1);
			}
			if($pass){
				$set['m_password']=plum_salt_password($pass);
			}
			$where=[
				['name'=>'m_c_id','oper'=>'=','value'=>$this->company['c_id']],
				['name'=>'m_area_status','oper'=>'=','value'=>1],
			];
			if($mid){
				$where[]=['name'=>'m_id','oper'=>'=','value'=>$mid];	
				$res=$this->manager_model->updateValue($set,$where);
			}else{//插入
                if(!$memberId){
                    $this->displayJsonError('请选择用户');
                }
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member_row = $member_model->getRowById($memberId);
			    $set['m_wx_openid'] = $member_row['m_openid'];

				$mobile=$this->request->getStrParam('mobile');//手机号码作为登录账号不允许修改
				if(!plum_is_phone($mobile)){
					$result['em'] = '请输入有效的手机号';
					$this->displayJson($result,1);
				}
				$hasMobile = $this->manager_model->checkMobile($mobile);
				if($hasMobile){
					$result['em'] = '手机号已存在';
					$this->displayJson($result,1);
				}
				if(!$pass){
                    $set['m_password']=plum_salt_password($mobile);
                }

				$set['m_mobile']=$mobile;
				$set['m_power'] = self::POWER;
                $set['m_c_id'] = $this->company['c_id'];
                $set['m_createtime'] = time();
                $set['m_fid'] = $this->uid;
                $set['m_area_status']=1;
				$res=$this->manager_model->insertValue($set);
			}
			if($res){
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
            }else{
                $result['em'] = '操作失败';
            }
            $this->displayJson($result);
		}else{
	        $this->buildBreadcrumbs(array(
	            array('title' => '区域合伙人添加/修改', 'link' => '#'),
	        ));  
			$mid=$this->request->getIntParam('mid');
	        $area_model=new App_Model_Member_MysqlRegionStorage();
	        $province=$area_model->get_province();
	        $this->output['province']=$province;
			if($mid){
				$manager_info=$this->manager_model->getSingleManagerWithArea($mid,$this->company['c_id']);
				$this->output['manager_info']=$manager_info;

				$member = [];
				if($manager_info['m_wx_openid']){
				    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
				    $member = $member_model->findUpdateMemberByWeixinOpenid($manager_info['m_wx_openid'],$this->curr_sid);
                }
				$this->output['member'] = $member;
                if($manager_info['m_area_id'] && $manager_info['m_area_type']=='D'){
                    $city_id=$area_model->getProvinceByCityId($manager_info['m_area_id']);
                    $this->output['city_id']=$city_id['parent_id'];
                }elseif($manager_info['m_area_id'] && $manager_info['m_area_type']=='C'){
                    $city_id=$manager_info['m_area_id'];
                    $this->output['city_id']=$manager_info['m_area_id'];
                }
                if($city_id){
                    $province_id=$area_model->getProvinceByCityId($this->output['city_id']);
                    $this->output['province_id']=$province_id['parent_id'];
                    $citys=$area_model->get_city_by_parent($province_id['parent_id']);
                    $this->output['citys']=$citys;
                    $zones=$area_model->get_area_by_parent( $this->output['city_id']);
                    $this->output['zones']=$zones;
                }
			}
		
			$this->displaySmarty('wxapp/seqregion/edit-area-manager.tpl');
		}
	}

	
	public function regionBrokerageAction(){
		$user_id=0;
		$where=[];
		$area_info=$this->get_area_manager();
        if($area_info){
        	if($area_info['region_child']==1)
        		plum_redirect_with_msg('无访问权限',$_SERVER['HTTP_REFERER'],true);
            if($area_info['m_area_type']=='C')
                $where[]=['name'=>'asa.asa_city','oper'=>'=','value'=>$area_info['m_area_id']];
            else if($area_info['m_area_type']=='D')
                $where[]=['name'=>'asa.asa_zone','oper'=>'=','value'=>$area_info['m_area_id']];
            $user_id=$this->uid;
            $this->output['area_info']=1;
        }else{
        	$user_id=$this->request->getIntParam('region_manager_id');
        	 $this->output['area_info']=0;
        }
        $region_brokerage_model=new App_Model_Sequence_MysqlSequenceRegionBrokerageStorage($this->curr_sid);
        $brokerage_sum=$region_brokerage_model->getRegionBrokerageSum($user_id);
        $this->output['brokerage_sum']=(sprintf('%.2f',$brokerage_sum/100));
        $brokerage_already_model=new App_Model_Sequence_MysqlSequenceRegionWithDrawStorage($this->curr_sid);
        $already_money=$brokerage_already_model->getAlreadySum($user_id);
        $all_money=$brokerage_already_model->getAlreadySum($user_id,1);

        $this->output['already_money']=(sprintf('%.2f',$already_money/100));
        $this->output['review_money']=(sprintf('%.2f',($all_money-$already_money)/100));
        $this->buildBreadcrumbs(array(
            array('title' => '区域合伙人佣金管理', 'link' => '#'),
        ));  
       
       	$type=$this->request->getStrParam('type','brokerage');
       	$page         = $this->request->getIntParam('page');
	    $index        = $page*$this->count;
       if($type=='brokerage'){
	       	$brokerage_model=new App_Model_Sequence_MysqlSequenceRegionBrokerageStorage($this->curr_sid);
	        $where_brokerage=[
	        	['name'=>'armb_s_id','oper'=>'=','value'=>$this->curr_sid],
	        	['name'=>'armb_manager_id','oper'=>'=','value'=>$user_id]
	        ];
	       
	        $total=$brokerage_model->getCount($where_brokerage);
	        $this->pagination($total,$this->count);
	        $sort=['armb_status'=>'DESC','armb_create_at'=>'DESC'];
	        $field=['armb_tid','armb_create_at','armb_status','armb_money'];
	        $brokerage_list=$brokerage_model->getList($where_brokerage,$index,$this->count,$sort,$field);
	        $this->output['brokerage_list']=$brokerage_list;
       }else if($type=='withdraw'){
       		$withdraw_model=new App_Model_Sequence_MysqlSequenceRegionWithDrawStorage($this->curr_sid);
			$total=$withdraw_model->getCount([
				['name'=>'arwr_s_id','oper'=>'=','value'=>$this->curr_sid],
				['name'=>'arwr_manager_id','oper'=>'=','value'=>$user_id],
			]);
			if($user_id)
				$list=$withdraw_model->getWithdrawList($index,$this->count,$user_id);
			else 
				$list=null;
			$this->output['withdraw_list']=$list;
			$this->pagination($total,$this->count);
       }
        $this->displaySmarty('wxapp/seqregion/region-brokerage.tpl');

	}
	public function getRegionManagerLessAction(){
		$mobile=$this->request->getStrParam('mobile');
		$leaderManager = $this->request->getIntParam('leaderManager',0);
		$page     = $this->request->getIntParam('page',1);
		$province     = $this->request->getIntParam('province');
        $page     = $page >=1 ? $page : 1;
        $index    = ($page - 1)* $this->count;
        $where=[
			['name'=>'m_c_id','oper'=>'=','value'=>$this->company['c_id']],
			['name'=>'m_area_status','oper'=>'=','value'=>1],
			['name'=>'m_status','oper'=>'=','value'=>0]
		];
		if($mobile){
			$where[]=['name'=>'m_mobile','oper'=>'=','value'=>$mobile];
		}
		$list=$this->manager_model->getListWithArea($where,$index,$this->count,[]);
		foreach ($list as &$v){
		    if($leaderManager > 0 && $v['m_id'] == $leaderManager ){
		        $v['selected'] = 1;
            }else{
		        $v['selected'] = 0;
            }
        }

		$total=$this->manager_model->getCount($where);
		$tot_page    = ceil($total/$this->count);
        $menu_helper = new App_Helper_Menu();
        $menu        = $menu_helper->ajaxPageLink($tot_page , $page,'','getMangerList');
        $data = array(
            'ec'        => 200,
            'list'      => $list,
            'pageHtml'  => $menu
        );
        $this->displayJson($data);
	}
	
	public function withdrawListAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '区域合伙人提现申请', 'link' => '#'),
        ));  
		$page         = $this->request->getIntParam('page');
        $index        = $page*$this->count;

		$withdraw_model=new App_Model_Sequence_MysqlSequenceRegionWithDrawStorage($this->curr_sid);
		$total=$withdraw_model->getCount([
			['name'=>'arwr_s_id','oper'=>'=','value'=>$this->curr_sid]
		]);
		$list=$withdraw_model->getWithdrawList($index,$this->count);
		$this->output['list']=$list;
		$this->pagination($total,$this->count);
		$this->displaySmarty('wxapp/seqregion/withdraw-list.tpl');
	}

	
	public function  editRegionChildManagerAction(){
		$mobile=$this->request->getIntParam('mobile');
		$pwd=$this->request->getStrParam('pwd');	
		
		if(!plum_is_phone($mobile)){
			$this->displayJson(['em'=>'请输入有效的手机号码'],1);
		}
		$manager_row=$this->manager_model->getRowById($this->uid);
		if($manager_row['region_child']==1)
			$this->displayJson(['em'=>'当前账号无访问权限'],1);
		if($manager_row['m_area_id']){
			$set=[
				'm_mobile'						=>$mobile,
				'm_area_type'					=>'D',
				'm_area_id'						=>$manager_row['m_area_id'],
				'm_area_region_child'			=>1,
				'm_password'					=>plum_salt_password($mobile),
				'm_update_time'					=>time(),
			];
			$hasMobile=$this->manager_model->checkMobile($mobile);
			if($pwd)
				$set['m_password']=plum_salt_password($pwd);

			$where=[
				['name'=>'m_area_id','oper'=>'=','value'=>$manager_row['m_area_id']],
				['name'=>'m_c_id','oper'=>'=','value'=>$this->company['c_id']],
				['name'=>'m_area_region_child','oper'=>'=','value'=>1],
				['name'=>'m_area_status','oper'=>'=','value'=>1],
			];
			$child_row=$this->manager_model->getRow($where);
			if($child_row){
				if($hasMobile&&($mobile!=$child_row['m_mobile']))
					$this->displayJson(['em'=>'当前手机号已存在'],1);
				$res=$this->manager_model->updateValue($set,[
					['name'=>'m_id','oper'=>'=','value'=>$child_row['m_id']]
				]);
			}else{
				if($hasMobile){
					$this->displayJson(['em'=>'当前手机号已存在'],1);
				}
				$set['m_power'] = self::POWER;
                $set['m_c_id'] = $this->company['c_id'];
                $set['m_createtime'] = time();
                $set['m_fid'] = $this->uid;
                $set['m_area_status']=1;
				$res=$this->manager_model->insertValue($set);
			}
			if($res){
                $result=[
                    'ec'	=>200,
                    'em'	=>'操作成功'
                ];
                App_Helper_OperateLog::saveOperateLog("区域合伙人子管理账号【{$mobile}】保存成功");
            }else{
                $result=[
                    'ec'	=>400,
                    'em'	=>'操作失败'
                ];
            }

			$this->displayJson($result);
		}else{
			$this->displayJson(['em'=>'当前账号非区域合伙人账号'],1);
		}

	}
	
	public function getRegionChildManagerAction(){
		$manager_row=$this->manager_model->getRowById($this->uid);
		if($manager_row['region_child']==1)
			$this->displayJson(['em'=>'当前账号无访问权限'],1);
		if($manager_row['m_area_id']){
			$res=$this->manager_model->getRow([
				['name'=>'m_c_id','oper'=>'=','value'=>$this->company['c_id']],
				['name'=>'m_area_status','oper'=>'=','value'=>1],
				['name'=>'m_area_region_child','oper'=>'=','value'=>1],
				['name'=>'m_area_id','oper'=>'=','value'=>$manager_row['m_area_id']],
			]);
			if($res){
				$res=[
					'm_id'		=>$res['m_id'],
					'm_mobile'	=>$res['m_mobile'],
				];
				$this->displayJsonSuccess($res);
			}else
				$this->displayJson(['ec'=>400,'em'=>'未获取到操作员信息'],1);
		}else{
			$this->displayJson(['em'=>'当前账号非区域合伙人账号'],1);
		}
		
	}




	
    private function pagination($total, $count=50){
        $page_model=new Libs_Pagination_Paginator($total, $count, 'jquery', true);
        $this->output['paginator'] = $page_model->render();
    }
    
    private function check_has_permission(){
    	if($this->uid!=$this->company['c_founder_id'])
            plum_url_location('当前用户无操作权限');
    }
     

    
    public function _applet_weixin_auto_deal(array $record) {
        $pay_storage    = new App_Model_Auth_MysqlPayTypeStorage($this->curr_sid);
        $payCfg = $pay_storage->findRowPay();
        if(!$payCfg || !$payCfg['pt_wxpay_applet']){
            return array('errno' => false, 'errmsg' => '请在支付配置中开启微信支付');
        }
        if ($payCfg && $payCfg['pt_wxpay_applet']) {
            $wxpay_plugin   = new App_Plugin_Weixin_NewPay($this->curr_sid);
            $money          = sprintf('%.2f',$record['arwr_money']/100);
            $ret    = $wxpay_plugin->appletPayTransfer($record['m_wx_openid'], $money, $record['m_nickname']);
        }
        if ($ret && !$ret['code']) {
            return array('errno' => true, 'errmsg' => '微信转账成功');
        } else {
            return array('errno' => false, 'errmsg' => $ret['errmsg']);
        }
    }



    

    

    
    public function changeVerifyCfgAction(){
        $type = $this->request->getStrParam('type');
        $value = $this->request->getStrParam('value');

        if(!in_array($type,['goods','community','leader_open'])){
            $this->displayJsonError('操作失败');
        }

        $status = $value == 'on' ? 1 : 0;
        $status_note = $status == 1 ? '开启' : '关闭';
        $type_note = '';
        switch ($type){
            case 'goods':
                $type_note = '合伙人添加商品审核';
                $field = 'asc_region_'.$type.'_verify';
                break;
            case 'community':
                $type_note = '合伙人添加小区审核';
                $field = 'asc_region_'.$type.'_verify';
                break;
            case 'leader_open':
                $type_note = '合伙人团长管理';
                $field = 'asc_region_leader_open';
                break;
        }


        $set = [
            $field => $status,
            'asc_update_time' => time()
        ];
        $cfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $exist = $cfg_model->findUpdateBySid();
        if($exist){
            $res = $cfg_model->findUpdateBySid($set);
        }else{
            $set['asc_s_id'] = $this->curr_sid;
            $set['asc_create_time'] = time();
            $res = $cfg_model->insertValue($set);
        }

        if($res && $status_note && $type_note){
            App_Helper_OperateLog::saveOperateLog("{$status_note}{$type_note}成功");
        }

        $this->showAjaxResult($res,'操作');

    }

    
    public function handleGoodsVerifyAction(){
        $id = $this->request->getIntParam('id');
        $remark = $this->request->getStrParam('remark');
        $status = $this->request->getStrParam('status');
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $goods = $goods_model->getRowById($id);
        if($goods){
            $set = [
                'g_update_time' => time(),
                'g_is_sale' => $status == 2 ? 1 : 5,
                'g_discuss_info' => $remark
            ];
            $res = $goods_model->updateById($set,$id);

            if($res){
                $status_content = $status == 2 ? '已通过审核' : '未通过审核';

                App_Helper_OperateLog::saveOperateLog("合伙人上传商品【{$goods['g_name']}】审核成功，审核结果：{$status_content}");

                $content = '您的商品'.$goods['g_name'].$status_content;
                $message_helper = new App_Helper_ShopMessage($this->curr_sid);
                $message_helper->messageRecord($message_helper::SEQUENCE_REGION_GOODS_VERIFY,'',$content,$goods['g_region_add_by']);
            }

            $this->showAjaxResult($res,'操作');

        }else{
            $this->displayJsonError('信息不存在');
        }
    }

    
    public function handleCommunityVerifyAction(){
        $id = $this->request->getIntParam('id');
        $remark = $this->request->getStrParam('remark');
        $status = $this->request->getStrParam('status');
        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        $community = $community_model->getRowById($id);
        if($community){
            $set = [
                'asc_handle_time' => time(),
                'asc_status' => $status,
                'asc_handle_remark' => $remark
            ];
            $res = $community_model->updateById($set,$id);

            $status_content = $status == 2 ? '已通过审核' : '未通过审核';

            App_Helper_OperateLog::saveOperateLog("合伙人上传小区【{$community['asc_name']}】审核成功，审核结果：{$status_content}");

            $content = '您的小区'.$community['asc_name'].$status_content;
            $message_helper = new App_Helper_ShopMessage($this->curr_sid);
            $message_helper->messageRecord($message_helper::SEQUENCE_REGION_COMMUNITY_VERIFY,'',$content,$community['asc_region_add_by']);

            $this->showAjaxResult($res,'操作');

        }else{
            $this->displayJsonError('信息不存在');
        }
    }
}