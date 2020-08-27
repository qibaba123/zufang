<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/14
 * Time: 上午11:47
 */
/*
 * 店铺微信助手
 */
class App_Helper_Menu {

    /**
     * @param $list
     * @param string $pre
     * @return string
     * 根据列表数据，初始化菜单json
     */
    public function dealMenuDataToJson($list,$table){
        $result = array();
        switch($table){
            case 'weixin':
                $pre  = 'wm_';
                $link = 'extra';
                break;
            default:
                $pre  = 'sm_';
                $link = 'link';
                break;
        }
        if(!empty($list) && is_array($list)){
            $data = array();
            $enum = plum_parse_config('click_enum','weixin');
            foreach($list as $val){
                if($val[$pre.'fid'] == 0){ //一级菜单
                    $data[$val[$pre.'index']] = array(
                        'id'    => $val[$pre.'id'], //ID 唯一
                        'index' => $val[$pre.'index'], //位置
                        'text'  => $val[$pre.'name'],  // 内容
                        'link'  => isset($enum[$val[$pre.'extra']]) && $table == 'weixin' ? $enum[$val[$pre.$link]]['text'] : $val[$pre.$link], //链接，文本信息
                        'son_menus' => array(), //子菜单
                    );

                }else{ //二级菜单
                    $data[$list[$val[$pre.'fid']][$pre.'index']]['son_menus'][] = array(
                        'id'    => $val[$pre.'id'], //ID 唯一
                        'index' => $val[$pre.'index'],
                        'text'  => $val[$pre.'name'],
                        'link'  => isset($enum[$val[$pre.'extra']]) && $table == 'weixin'  ? $enum[$val[$pre.$link]]['text'] : $val[$pre.$link],
                    );
                }

            }
            ksort($data);
            foreach($data as $val){
                $result[] = $val;
            }
        }
        return json_encode($result);
    }

    /**
     * @param $name
     * @param $sid
     * @param $index
     * @param $findex
     * @param $table
     * @return array
     * 通用方法，保存微信自定义菜单和商铺导航
     * 公用字段（shopId,name,index,findex,level,fid）
     */
    public function saveMenu($name,$sid,$index,$findex,$table){
        $result = array(
            'ec' => 400,
            'em' => '菜单名字数错误'
        );
        $len     = mb_strlen($name);
        //一级菜单名字小于4，二级菜单名字小于7
        if($name && (($findex == '-1' && $len <= 4) || ($findex != '-1' && $len <= 7))){
            switch($table){
                case 'weixin':
                    $pre = 'wm_';
                    $menu_model = new App_Model_Auth_MysqlWeixinMenuStorage();
                    break;
                default:
                    $pre = 'sm_';
                    $menu_model = new App_Model_Shop_MysqlMenuStorage();
                    break;
            }
            $fid  = 0 ;//父ID
            $data = array();
            $data[$pre.'s_id']    = $sid;
            $data[$pre.'name']    = $name;
            $data[$pre.'index']   = $index;
            $data[$pre.'update_time']   = time();

            //@todo 获取一级菜单ID
            $sear_index = ($findex == '-1') ? $index : $findex;
            $frow       = $menu_model->getOneLevelByIndex($sid,$sear_index);

            if($findex == '-1'){//一级菜单
                $row = $frow;
                if(empty($frow) && $table == 'weixin'){//绑定微信配置ID
                    $weixin_model = new App_Model_Auth_MysqlWeixinStorage();
                    $weixin = $weixin_model->findWeixinBySid($sid);
                    $data[$pre.'wx_id'] = $weixin['wc_id'];
                }
                $data[$pre.'level'] = 1;
                $data[$pre.'fid'] = 0;

            }else{//二级菜单
                $fid  = $frow[$pre.'id'];
                $where[] = array('name' => $pre.'index', 'oper' => '=', 'value' => $index);
                $where[] = array('name' => $pre.'fid', 'oper' => '=', 'value' => $fid);
                $row = $menu_model->getRow($where);
                $data[$pre.'fid']   = $fid;
                if($table == 'weixin'){
                    $data[$pre.'wx_id'] = $frow[$pre.'wx_id'];
                }
                $data[$pre.'level'] = 2;
            }

            if($row){//更新
                $ret = $menu_model->updateById($data,$row[$pre.'id']);
            }else{//新增  判断一级菜单3个，二级菜单5个
                $limit = $menu_model->checkMenuNumber($sid,$data[$pre.'level'],$data[$pre.'fid']);
                if($limit){
                    $data[$pre.'create_time'] = time();
                    $ret = $menu_model->insertCheckExist($data);
                    if($fid && $ret){
                        $menu_model->updateChildNumById($fid);
                    }
                }else{
                    $ret = false;
                }
            }

            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
            }else{
                $result['em'] = '保存失败';
            }
        }
        return $result;
    }

    /**
     * 删除菜单
     * 一级菜单，查出自己ID，并删除改菜单下的子菜单
     * 二级菜单，查出父类ID，确定到单一的二级菜单，进行删除
     * 删除成功后，比该菜单靠后的同级菜单，自动往前提＋1
     * 通用方法，删除微信自定义菜单和商铺导航
     * 公用字段（shopId,index,findex,level,fid）
     */
    public function delMenu($sid,$index,$findex,$table){
        switch($table){
            case 'weixin':
                $pre = 'wm_';
                $menu_model = new App_Model_Auth_MysqlWeixinMenuStorage();
                break;
            default:
                $pre = 'sm_';
                $menu_model = new App_Model_Shop_MysqlMenuStorage();
                break;
        }
        if($findex == '-1'){ //一级菜单,需要同时删除它子菜单
            $level = 1;
            $search_index = $index;
        }else{//二级菜单
            $level = 2;
            $search_index = $findex;
        }
        //查询一级菜单ID
        $where = array();
        $where[] = array('name' => $pre.'s_id',  'oper' => '=', 'value' => $sid);
        $where[] = array('name' => $pre.'level', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => $pre.'index', 'oper' => '=', 'value' => $search_index);
        $row = $menu_model->getRow($where);
        $id = $row[$pre.'id'];
        //进行菜单删除操作
        $del_ret = $menu_model->deleteMenuByLevel($level,$sid,$index,$id);
        if($del_ret){
            //比该菜单靠后的同级菜单，自动往前提＋1
            $up_where = array();
            $up_where[] = array('name' => $pre.'s_id',  'oper' => '=', 'value' => $sid);
            $up_where[] = array('name' => $pre.'level', 'oper' => '=', 'value' => $level);
            $up_where[] = array('name' => $pre.'index', 'oper' => '>', 'value' => $index);
            $menu_model->updateIndex($up_where);
            if($level == 2){
                $menu_model->updateChildNumById($id,'-');
            }
            $result = array(
                'ec' => 200,
                'em' => '保存成功'
            );
        }else{
            $result = array(
                'ec' => 400,
                'em' => '菜单名不能为空'
            );
        }
        return $result;
    }

    public function saveMenuAll($sid,$menu,$table){
        switch($table){
            case 'weixin':
                $pre = 'wm_';
                $menu_model     = new App_Model_Auth_MysqlWeixinMenuStorage();
                $weixin_model   = new App_Model_Auth_MysqlWeixinStorage();
                $weixin         = $weixin_model->findWeixinBySid($sid);
                break;
            default:
                $pre = 'sm_';
                $menu_model = new App_Model_Shop_MysqlMenuStorage();
                break;
        }
        $list       = $menu_model->getListBySid($sid);
        $allIds     = array(); //旧的全部ID
        $firstIds   = array(); //旧的一级ID
        foreach($list as $lal){
            $allIds[] = $lal[$pre.'id'];
            if($lal[$pre.'level'] == 1){
                $firstIds[] = $lal[$pre.'id'];
            }
        }
        //遍历新的菜单对象
        $allNew     = array();
        $insert     = array();
        foreach($menu as $key => $mal){
            //一级菜单
            $data = $this->deal_menu_row_data($mal,$pre,$key,$table,0);
            //更新，或插入一级菜单
            if(intval($mal['id']) > 0){ //编辑
                $menu_model->getRowUpdateByIdSid($mal['id'],$sid,$data);
                $fid = $mal['id'];
            }else{ //新增
                $data[$pre.'s_id']  = $sid;
                if($table == 'weixin') $data[$pre.'wx_id'] = $weixin['wc_id'];
                $fid = $menu_model->insertValue($data);
            }
            $allNew[] = $fid;
            //二级菜单的更新或者插入
            if($data[$pre.'has_child'] > 0){
                foreach($mal['son_menus'] as $sey=>$sal){
                    $sdata = $this->deal_menu_row_data($sal,$pre,$sey,$table,$fid);
                    if(intval($sal['id']) > 0){
                        $menu_model->getRowUpdateByIdSid($sal['id'],$sid,$sdata);
                        $allNew[] = $sal['id'];
                    }else{
                        switch($table){
                            case 'weixin':
                                $insert[]= "(null,{$sid},{$weixin['wc_id']},'{$sdata[$pre.'name']}',{$sdata[$pre.'type']},'{$sdata[$pre.'extra']}',{$sdata[$pre.'level']},{$sdata[$pre.'index']},{$sdata[$pre.'fid']},{$sdata[$pre.'has_child']},{$sdata[$pre.'update_time']},{$sdata[$pre.'create_time']})";
                                break;
                            default:
                                $insert[]= "(null,{$sid},'{$sdata[$pre.'name']}','{$sdata[$pre.'link']}',{$sdata[$pre.'level']},{$sdata[$pre.'index']},{$sdata[$pre.'fid']},{$sdata[$pre.'has_child']},{$sdata[$pre.'update_time']},{$sdata[$pre.'create_time']})";
                                break;
                        }
                    }
                }
            }
        }
        //删除不存在的
        $has_del = array_diff($allIds,$allNew);
        $menu_model->deleteByIds($has_del,$sid);
        //批量保存
        $menu_model->batchInsert($insert);
        return array(
            'ec' => 200,
            'em' => '保存成功'
        );
    }

    private function deal_menu_row_data($mal,$pre,$key,$table,$fid){
        $data = array();
        $data[$pre.'name']      = $mal['text'];
        $data[$pre.'index']     = $key;
        $data[$pre.'level']     = $fid == 0 ? 1 : 2;
        $data[$pre.'fid']       = $fid;
        $data[$pre.'has_child'] = isset($mal['son_menus']) ? count($mal['son_menus']) : 0;
        $data[$pre.'update_time']   = $_SERVER['REQUEST_TIME'];
        $data[$pre.'create_time']   = $_SERVER['REQUEST_TIME'];
        //微信和店铺导航的区别
        switch($table){
            case 'weixin':
                if($data[$pre.'has_child'] > 0){
                    $data[$pre.'extra']     = '';
                    $data[$pre.'type']      = 0 ;
                }else{
                    $temp = $this->checkMenuType($mal['link']);
                    $data[$pre.'extra']     = $temp['value'];
                    $data[$pre.'type']      = $temp['type'];
                }
                break;
            default:
                $data[$pre.'link']      = $mal['link'];
                break;
        }
        return $data;
    }

    private function checkMenuType($link){
        $data = array(
            'type' => 1,
            'value'=> $link
        );
        $urlArr = parse_url($link);
        if(isset($urlArr['scheme'])){
            $data['type'] = 2;
        }
        if($data['type'] == 1){ //汉字单独处理
            $click_enum = plum_parse_config('click_enum','weixin');
            foreach($click_enum as $key=>$val){
                if($val['text'] == $data['value']){
                    $data['value'] = $key;
                }
            }
        }
        return $data;
    }

    /**
     * @param $total
     * @return string
     * 展示：第一页，前一页，当前页，后页面，最后一页
     */
    /**
     * @param $tot_page
     * @param $page
     * @return string
     * 总页数,当前页
     */
    public function ajaxPageLink($tot_page , $page, $type='',$page_method='fetchPageData'){
        $page_html = '';
        if($tot_page > 1){
            //上一页
            if($page > 1){
                $page_html .= '<a href="javascript:;" onclick="'.$page_method.'('.intval($page-1).',\''.$type.'\')" class="prev-page">上一页</a>';
            }
            //前5页
            if($tot_page <= 5){ //总页数小于等于5 全部展示
                for($i=1; $i<= $tot_page; $i++){
                    $act = '';
                    if($page == $i){
                        $act = 'class="active"';
                    }
                    $page_html .= '<a href="javascript:;" onclick="'.$page_method.'('.$i.',\''.$type.'\')" '.$act.' >'.$i.'</a>';
                }
            }else{ //总页数大于5
                $page_array = array();
                if($page-1){
                    $page_array[$page-1] = '<a href="javascript:;" onclick="'.$page_method.'('.($page-1).',\''.$type.'\')" >'.($page-1).'</a>';
                }

                $page_array[$page] = '<a href="javascript:;" class="active" >'.$page.'</a>';
                if($page+1 <= $tot_page){
                    $page_array[$page+1] = '<a href="javascript:;" onclick="'.$page_method.'('.intval($page+1).',\''.$type.'\')" >'.intval($page+1).'</a>';
                }
                $skip = '<span class="skip-page">...</span>';

                if($page <= 3){
                    if($page == 3){
                        $page_html .= '<a href="javascript:;" onclick="'.$page_method.'(1,\''.$type.'\')" >1</a>';
                    }
                    $page_html .= implode('',$page_array);
                    $page_html .= $skip.'<a href="javascript:;" onclick="'.$page_method.'('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                }else{
                    $page_html .= '<a href="javascript:;" onclick="'.$page_method.'(1,\''.$type.'\')" >1</a>';
                    $page_html .= $skip;
                    $page_html .= implode('',$page_array);
                    if($page+1 < $tot_page){
                        $page_html .= $skip.'<a href="javascript:;" onclick="'.$page_method.'('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                    }
                    //$page_html .= implode('',$page_array);
                }

            }

            if($page+1 <= $tot_page){
                $page_html .= '<a href="javascript:;" onclick="'.$page_method.'('.intval($page+1).',\''.$type.'\')"  class="next-page">下一页</a>';
            }
        }
        return $page_html;
    }

    /**
     * @param $total
     * @return string
     * 展示：第一页，前一页，当前页，后页面，最后一页
     */
    /**
     * @param $tot_page
     * @param $page
     * @return string
     * 总页数,当前页
     */
    public function ajaxGoodsPageLink($tot_page , $page, $type=''){
        $page_html = '';
        if($tot_page > 1){
            //上一页
            if($page > 1){
                $page_html .= '<a href="javascript:;" onclick="fetchGoodsPageData('.intval($page-1).',\''.$type.'\')" class="prev-page">上一页</a>';
            }
            //前5页
            if($tot_page <= 5){ //总页数小于等于5 全部展示
                for($i=1; $i<= $tot_page; $i++){
                    $act = '';
                    if($page == $i){
                        $act = 'class="active"';
                    }
                    $page_html .= '<a href="javascript:;" onclick="fetchGoodsPageData('.$i.',\''.$type.'\')" '.$act.' >'.$i.'</a>';
                }
            }else{ //总页数大于5
                $page_array = array();
                if($page-1){
                    $page_array[$page-1] = '<a href="javascript:;" onclick="fetchGoodsPageData('.($page-1).',\''.$type.'\')" >'.($page-1).'</a>';
                }

                $page_array[$page] = '<a href="javascript:;" class="active" >'.$page.'</a>';
                if($page+1 <= $tot_page){
                    $page_array[$page+1] = '<a href="javascript:;" onclick="fetchGoodsPageData('.intval($page+1).',\''.$type.'\')" >'.intval($page+1).'</a>';
                }
                $skip = '<span class="skip-page">...</span>';

                if($page <= 3){
                    if($page == 3){
                        $page_html .= '<a href="javascript:;" onclick="fetchGoodsPageData(1,\''.$type.'\')" >1</a>';
                    }
                    $page_html .= implode('',$page_array);
                    $page_html .= $skip.'<a href="javascript:;" onclick="fetchGoodsPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                }else{
                    $page_html .= '<a href="javascript:;" onclick="fetchGoodsPageData(1,\''.$type.'\')" >1</a>';
                    $page_html .= $skip;
                    $page_html .= implode('',$page_array);
                    if($page+1 < $tot_page){
                        $page_html .= $skip.'<a href="javascript:;" onclick="fetchGoodsPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                    }
                    //$page_html .= implode('',$page_array);
                }

            }

            if($page+1 <= $tot_page){
                $page_html .= '<a href="javascript:;" onclick="fetchGoodsPageData('.intval($page+1).',\''.$type.'\')"  class="next-page">下一页</a>';
            }
        }
        return $page_html;
    }

    /**
     * @param $total
     * @return string
     * 展示：第一页，前一页，当前页，后页面，最后一页
     */
    /**
     * @param $tot_page
     * @param $page
     * @return string
     * 总页数,当前页
     */
    public function ajaxInformationPageLink($tot_page , $page, $type=''){
        $page_html = '';
        if($tot_page > 1){
            //上一页
            if($page > 1){
                $page_html .= '<a href="javascript:;" onclick="fetchInformationPageData('.intval($page-1).',\''.$type.'\')" class="prev-page">上一页</a>';
            }
            //前5页
            if($tot_page <= 5){ //总页数小于等于5 全部展示
                for($i=1; $i<= $tot_page; $i++){
                    $act = '';
                    if($page == $i){
                        $act = 'class="active"';
                    }
                    $page_html .= '<a href="javascript:;" onclick="fetchInformationPageData('.$i.',\''.$type.'\')" '.$act.' >'.$i.'</a>';
                }
            }else{ //总页数大于5
                $page_array = array();
                if($page-1){
                    $page_array[$page-1] = '<a href="javascript:;" onclick="fetchInformationPageData('.($page-1).',\''.$type.'\')" >'.($page-1).'</a>';
                }

                $page_array[$page] = '<a href="javascript:;" class="active" >'.$page.'</a>';
                if($page+1 <= $tot_page){
                    $page_array[$page+1] = '<a href="javascript:;" onclick="fetchInformationPageData('.intval($page+1).',\''.$type.'\')" >'.intval($page+1).'</a>';
                }
                $skip = '<span class="skip-page">...</span>';

                if($page <= 3){
                    if($page == 3){
                        $page_html .= '<a href="javascript:;" onclick="fetchInformationPageData(1,\''.$type.'\')" >1</a>';
                    }
                    $page_html .= implode('',$page_array);
                    $page_html .= $skip.'<a href="javascript:;" onclick="fetchInformationPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                }else{
                    $page_html .= '<a href="javascript:;" onclick="fetchInformationPageData(1,\''.$type.'\')" >1</a>';
                    $page_html .= $skip;
                    $page_html .= implode('',$page_array);
                    if($page+1 < $tot_page){
                        $page_html .= $skip.'<a href="javascript:;" onclick="fetchInformationPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                    }
                    //$page_html .= implode('',$page_array);
                }

            }

            if($page+1 <= $tot_page){
                $page_html .= '<a href="javascript:;" onclick="fetchInformationPageData('.intval($page+1).',\''.$type.'\')"  class="next-page">下一页</a>';
            }
        }
        return $page_html;
    }

    /**
     * @param $total
     * @return string
     * 展示：第一页，前一页，当前页，后页面，最后一页
     */
    /**
     * @param $tot_page
     * @param $page
     * @return string
     * 总页数,当前页
     */
    public function ajaxCouponPageLink($tot_page , $page, $type=''){
        $page_html = '';
        if($tot_page > 1){
            //上一页
            if($page > 1){
                $page_html .= '<a href="javascript:;" onclick="fetchCouponPageData('.intval($page-1).',\''.$type.'\')" class="prev-page">上一页</a>';
            }
            //前5页
            if($tot_page <= 5){ //总页数小于等于5 全部展示
                for($i=1; $i<= $tot_page; $i++){
                    $act = '';
                    if($page == $i){
                        $act = 'class="active"';
                    }
                    $page_html .= '<a href="javascript:;" onclick="fetchCouponPageData('.$i.',\''.$type.'\')" '.$act.' >'.$i.'</a>';
                }
            }else{ //总页数大于5
                $page_array = array();
                if($page-1){
                    $page_array[$page-1] = '<a href="javascript:;" onclick="fetchCouponPageData('.($page-1).',\''.$type.'\')" >'.($page-1).'</a>';
                }

                $page_array[$page] = '<a href="javascript:;" class="active" >'.$page.'</a>';
                if($page+1 <= $tot_page){
                    $page_array[$page+1] = '<a href="javascript:;" onclick="fetchCouponPageData('.intval($page+1).',\''.$type.'\')" >'.intval($page+1).'</a>';
                }
                $skip = '<span class="skip-page">...</span>';

                if($page <= 3){
                    if($page == 3){
                        $page_html .= '<a href="javascript:;" onclick="fetchCouponPageData(1,\''.$type.'\')" >1</a>';
                    }
                    $page_html .= implode('',$page_array);
                    $page_html .= $skip.'<a href="javascript:;" onclick="fetchCouponPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                }else{
                    $page_html .= '<a href="javascript:;" onclick="fetchCouponPageData(1,\''.$type.'\')" >1</a>';
                    $page_html .= $skip;
                    $page_html .= implode('',$page_array);
                    if($page+1 < $tot_page){
                        $page_html .= $skip.'<a href="javascript:;" onclick="fetchCouponPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                    }
                    //$page_html .= implode('',$page_array);
                }

            }

            if($page+1 <= $tot_page){
                $page_html .= '<a href="javascript:;" onclick="fetchCouponPageData('.intval($page+1).',\''.$type.'\')"  class="next-page">下一页</a>';
            }
        }
        return $page_html;
    }


    /**
     * @param $total
     * @return string
     * 展示：第一页，前一页，当前页，后页面，最后一页
     */
    /**
     * @param $tot_page
     * @param $page
     * @return string
     * 总页数,当前页
     */
    public function ajaxGroupPageLink($tot_page , $page, $type=''){
        $page_html = '';
        if($tot_page > 1){
            //上一页
            if($page > 1){
                $page_html .= '<a href="javascript:;" onclick="fetchGroupPageData('.intval($page-1).',\''.$type.'\')" class="prev-page">上一页</a>';
            }
            //前5页
            if($tot_page <= 5){ //总页数小于等于5 全部展示
                for($i=1; $i<= $tot_page; $i++){
                    $act = '';
                    if($page == $i){
                        $act = 'class="active"';
                    }
                    $page_html .= '<a href="javascript:;" onclick="fetchGroupPageData('.$i.',\''.$type.'\')" '.$act.' >'.$i.'</a>';
                }
            }else{ //总页数大于5
                $page_array = array();
                if($page-1){
                    $page_array[$page-1] = '<a href="javascript:;" onclick="fetchGroupPageData('.($page-1).',\''.$type.'\')" >'.($page-1).'</a>';
                }

                $page_array[$page] = '<a href="javascript:;" class="active" >'.$page.'</a>';
                if($page+1 <= $tot_page){
                    $page_array[$page+1] = '<a href="javascript:;" onclick="fetchGroupPageData('.intval($page+1).',\''.$type.'\')" >'.intval($page+1).'</a>';
                }
                $skip = '<span class="skip-page">...</span>';

                if($page <= 3){
                    if($page == 3){
                        $page_html .= '<a href="javascript:;" onclick="fetchGroupPageData(1,\''.$type.'\')" >1</a>';
                    }
                    $page_html .= implode('',$page_array);
                    $page_html .= $skip.'<a href="javascript:;" onclick="fetchGroupPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                }else{
                    $page_html .= '<a href="javascript:;" onclick="fetchGroupPageData(1,\''.$type.'\')" >1</a>';
                    $page_html .= $skip;
                    $page_html .= implode('',$page_array);
                    if($page+1 < $tot_page){
                        $page_html .= $skip.'<a href="javascript:;" onclick="fetchGroupPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                    }
                    //$page_html .= implode('',$page_array);
                }

            }

            if($page+1 <= $tot_page){
                $page_html .= '<a href="javascript:;" onclick="fetchGroupPageData('.intval($page+1).',\''.$type.'\')"  class="next-page">下一页</a>';
            }
        }
        return $page_html;
    }

    /**
     * @param $total
     * @return string
     * 展示：第一页，前一页，当前页，后页面，最后一页
     */
    /**
     * @param $tot_page
     * @param $page
     * @return string
     * 总页数,当前页
     */
    public function ajaxSeckillPageLink($tot_page , $page, $type=''){
        $page_html = '';
        if($tot_page > 1){
            //上一页
            if($page > 1){
                $page_html .= '<a href="javascript:;" onclick="fetchSeckillPageData('.intval($page-1).',\''.$type.'\')" class="prev-page">上一页</a>';
            }
            //前5页
            if($tot_page <= 5){ //总页数小于等于5 全部展示
                for($i=1; $i<= $tot_page; $i++){
                    $act = '';
                    if($page == $i){
                        $act = 'class="active"';
                    }
                    $page_html .= '<a href="javascript:;" onclick="fetchSeckillPageData('.$i.',\''.$type.'\')" '.$act.' >'.$i.'</a>';
                }
            }else{ //总页数大于5
                $page_array = array();
                if($page-1){
                    $page_array[$page-1] = '<a href="javascript:;" onclick="fetchSeckillPageData('.($page-1).',\''.$type.'\')" >'.($page-1).'</a>';
                }

                $page_array[$page] = '<a href="javascript:;" class="active" >'.$page.'</a>';
                if($page+1 <= $tot_page){
                    $page_array[$page+1] = '<a href="javascript:;" onclick="fetchSeckillPageData('.intval($page+1).',\''.$type.'\')" >'.intval($page+1).'</a>';
                }
                $skip = '<span class="skip-page">...</span>';

                if($page <= 3){
                    if($page == 3){
                        $page_html .= '<a href="javascript:;" onclick="fetchSeckillPageData(1,\''.$type.'\')" >1</a>';
                    }
                    $page_html .= implode('',$page_array);
                    $page_html .= $skip.'<a href="javascript:;" onclick="fetchSeckillPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                }else{
                    $page_html .= '<a href="javascript:;" onclick="fetchSeckillPageData(1,\''.$type.'\')" >1</a>';
                    $page_html .= $skip;
                    $page_html .= implode('',$page_array);
                    if($page+1 < $tot_page){
                        $page_html .= $skip.'<a href="javascript:;" onclick="fetchSeckillPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                    }
                    //$page_html .= implode('',$page_array);
                }

            }

            if($page+1 <= $tot_page){
                $page_html .= '<a href="javascript:;" onclick="fetchSeckillPageData('.intval($page+1).',\''.$type.'\')"  class="next-page">下一页</a>';
            }
        }
        return $page_html;
    }

    /**
     * @param $total
     * @return string
     * 展示：第一页，前一页，当前页，后页面，最后一页
     */
    /**
     * @param $tot_page
     * @param $page
     * @return string
     * 总页数,当前页
     */
    public function ajaxBargainPageLink($tot_page , $page, $type=''){
        $page_html = '';
        if($tot_page > 1){
            //上一页
            if($page > 1){
                $page_html .= '<a href="javascript:;" onclick="fetchBargainPageData('.intval($page-1).',\''.$type.'\')" class="prev-page">上一页</a>';
            }
            //前5页
            if($tot_page <= 5){ //总页数小于等于5 全部展示
                for($i=1; $i<= $tot_page; $i++){
                    $act = '';
                    if($page == $i){
                        $act = 'class="active"';
                    }
                    $page_html .= '<a href="javascript:;" onclick="fetchBargainPageData('.$i.',\''.$type.'\')" '.$act.' >'.$i.'</a>';
                }
            }else{ //总页数大于5
                $page_array = array();
                if($page-1){
                    $page_array[$page-1] = '<a href="javascript:;" onclick="fetchBargainPageData('.($page-1).',\''.$type.'\')" >'.($page-1).'</a>';
                }

                $page_array[$page] = '<a href="javascript:;" class="active" >'.$page.'</a>';
                if($page+1 <= $tot_page){
                    $page_array[$page+1] = '<a href="javascript:;" onclick="fetchBargainPageData('.intval($page+1).',\''.$type.'\')" >'.intval($page+1).'</a>';
                }
                $skip = '<span class="skip-page">...</span>';

                if($page <= 3){
                    if($page == 3){
                        $page_html .= '<a href="javascript:;" onclick="fetchBargainPageData(1,\''.$type.'\')" >1</a>';
                    }
                    $page_html .= implode('',$page_array);
                    $page_html .= $skip.'<a href="javascript:;" onclick="fetchBargainPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                }else{
                    $page_html .= '<a href="javascript:;" onclick="fetchBargainPageData(1,\''.$type.'\')" >1</a>';
                    $page_html .= $skip;
                    $page_html .= implode('',$page_array);
                    if($page+1 < $tot_page){
                        $page_html .= $skip.'<a href="javascript:;" onclick="fetchBargainPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                    }
                    //$page_html .= implode('',$page_array);
                }

            }

            if($page+1 <= $tot_page){
                $page_html .= '<a href="javascript:;" onclick="fetchBargainPageData('.intval($page+1).',\''.$type.'\')"  class="next-page">下一页</a>';
            }
        }
        return $page_html;
    }

    /**
     * @param $total
     * @return string
     * 展示：第一页，前一页，当前页，后页面，最后一页
     */
    /**
     * @param $tot_page
     * @param $page
     * @return string
     * 总页数,当前页
     */
    public function ajaxPointsPageLink($tot_page , $page, $type=''){
        $page_html = '';
        if($tot_page > 1){
            //上一页
            if($page > 1){
                $page_html .= '<a href="javascript:;" onclick="fetchPointsPageData('.intval($page-1).',\''.$type.'\')" class="prev-page">上一页</a>';
            }
            //前5页
            if($tot_page <= 5){ //总页数小于等于5 全部展示
                for($i=1; $i<= $tot_page; $i++){
                    $act = '';
                    if($page == $i){
                        $act = 'class="active"';
                    }
                    $page_html .= '<a href="javascript:;" onclick="fetchPointsPageData('.$i.',\''.$type.'\')" '.$act.' >'.$i.'</a>';
                }
            }else{ //总页数大于5
                $page_array = array();
                if($page-1){
                    $page_array[$page-1] = '<a href="javascript:;" onclick="fetchPointsPageData('.($page-1).',\''.$type.'\')" >'.($page-1).'</a>';
                }

                $page_array[$page] = '<a href="javascript:;" class="active" >'.$page.'</a>';
                if($page+1 <= $tot_page){
                    $page_array[$page+1] = '<a href="javascript:;" onclick="fetchPointsPageData('.intval($page+1).',\''.$type.'\')" >'.intval($page+1).'</a>';
                }
                $skip = '<span class="skip-page">...</span>';

                if($page <= 3){
                    if($page == 3){
                        $page_html .= '<a href="javascript:;" onclick="fetchPointsPageData(1,\''.$type.'\')" >1</a>';
                    }
                    $page_html .= implode('',$page_array);
                    $page_html .= $skip.'<a href="javascript:;" onclick="fetchPointsPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                }else{
                    $page_html .= '<a href="javascript:;" onclick="fetchPointsPageData(1,\''.$type.'\')" >1</a>';
                    $page_html .= $skip;
                    $page_html .= implode('',$page_array);
                    if($page+1 < $tot_page){
                        $page_html .= $skip.'<a href="javascript:;" onclick="fetchPointsPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                    }
                    //$page_html .= implode('',$page_array);
                }

            }

            if($page+1 <= $tot_page){
                $page_html .= '<a href="javascript:;" onclick="fetchPointsPageData('.intval($page+1).',\''.$type.'\')"  class="next-page">下一页</a>';
            }
        }
        return $page_html;
    }

    /**
     * @param $tot_page
     * @param $page
     * @return string
     * 总页数,当前页
     */
    public function ajaxMemberPageLink($tot_page , $page, $type=''){
        $page_html = '';
        if($tot_page > 1){
            //上一页
            if($page > 1){
                $page_html .= '<a href="javascript:;" onclick="fetchMemberPageData('.intval($page-1).',\''.$type.'\')" class="prev-page">上一页</a>';
            }
            //前5页
            if($tot_page <= 5){ //总页数小于等于5 全部展示
                for($i=1; $i<= $tot_page; $i++){
                    $act = '';
                    if($page == $i){
                        $act = 'class="active"';
                    }
                    $page_html .= '<a href="javascript:;" onclick="fetchMemberPageData('.$i.',\''.$type.'\')" '.$act.' >'.$i.'</a>';
                }
            }else{ //总页数大于5
                $page_array = array();
                if($page-1){
                    $page_array[$page-1] = '<a href="javascript:;" onclick="fetchMemberPageData('.($page-1).',\''.$type.'\')" >'.($page-1).'</a>';
                }

                $page_array[$page] = '<a href="javascript:;" class="active" >'.$page.'</a>';
                if($page+1 <= $tot_page){
                    $page_array[$page+1] = '<a href="javascript:;" onclick="fetchMemberPageData('.intval($page+1).',\''.$type.'\')" >'.intval($page+1).'</a>';
                }
                $skip = '<span class="skip-page">...</span>';

                if($page <= 3){
                    if($page == 3){
                        $page_html .= '<a href="javascript:;" onclick="fetchMemberPageData(1,\''.$type.'\')" >1</a>';
                    }
                    $page_html .= implode('',$page_array);
                    $page_html .= $skip.'<a href="javascript:;" onclick="fetchMemberPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                }else{
                    $page_html .= '<a href="javascript:;" onclick="fetchMemberPageData(1,\''.$type.'\')" >1</a>';
                    $page_html .= $skip;
                    $page_html .= implode('',$page_array);
                    if($page+1 < $tot_page){
                        $page_html .= $skip.'<a href="javascript:;" onclick="fetchMemberPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                    }
                    //$page_html .= implode('',$page_array);
                }

            }

            if($page+1 <= $tot_page){
                $page_html .= '<a href="javascript:;" onclick="fetchMemberPageData('.intval($page+1).',\''.$type.'\')"  class="next-page">下一页</a>';
            }
        }
        return $page_html;
    }

    /**
     * @param $total
     * @return string
     * 展示：第一页，前一页，当前页，后页面，最后一页
     */
    /**
     * @param $tot_page
     * @param $page
     * @return string
     * 总页数,当前页
     */
    public function ajaxShopPageLink($tot_page , $page, $type=''){
        $page_html = '';
        if($tot_page > 1){
            //上一页
            if($page > 1){
                $page_html .= '<a href="javascript:;" onclick="fetchShopPageData('.intval($page-1).',\''.$type.'\')" class="prev-page">上一页</a>';
            }
            //前5页
            if($tot_page <= 5){ //总页数小于等于5 全部展示
                for($i=1; $i<= $tot_page; $i++){
                    $act = '';
                    if($page == $i){
                        $act = 'class="active"';
                    }
                    $page_html .= '<a href="javascript:;" onclick="fetchShopPageData('.$i.',\''.$type.'\')" '.$act.' >'.$i.'</a>';
                }
            }else{ //总页数大于5
                $page_array = array();
                if($page-1){
                    $page_array[$page-1] = '<a href="javascript:;" onclick="fetchShopPageData('.($page-1).',\''.$type.'\')" >'.($page-1).'</a>';
                }

                $page_array[$page] = '<a href="javascript:;" class="active" >'.$page.'</a>';
                if($page+1 <= $tot_page){
                    $page_array[$page+1] = '<a href="javascript:;" onclick="fetchShopPageData('.intval($page+1).',\''.$type.'\')" >'.intval($page+1).'</a>';
                }
                $skip = '<span class="skip-page">...</span>';

                if($page <= 3){
                    if($page == 3){
                        $page_html .= '<a href="javascript:;" onclick="fetchShopPageData(1,\''.$type.'\')" >1</a>';
                    }
                    $page_html .= implode('',$page_array);
                    $page_html .= $skip.'<a href="javascript:;" onclick="fetchShopPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                }else{
                    $page_html .= '<a href="javascript:;" onclick="fetchShopPageData(1,\''.$type.'\')" >1</a>';
                    $page_html .= $skip;
                    $page_html .= implode('',$page_array);
                    if($page+1 < $tot_page){
                        $page_html .= $skip.'<a href="javascript:;" onclick="fetchShopPageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                    }
                    //$page_html .= implode('',$page_array);
                }

            }

            if($page+1 <= $tot_page){
                $page_html .= '<a href="javascript:;" onclick="fetchShopPageData('.intval($page+1).',\''.$type.'\')"  class="next-page">下一页</a>';
            }
        }
        return $page_html;
    }

    public function ajaxStorePageLink($tot_page , $page, $type=''){
        $page_html = '';
        if($tot_page > 1){
            //上一页
            if($page > 1){
                $page_html .= '<a href="javascript:;" onclick="fetchStorePageData('.intval($page-1).',\''.$type.'\')" class="prev-page">上一页</a>';
            }
            //前5页
            if($tot_page <= 5){ //总页数小于等于5 全部展示
                for($i=1; $i<= $tot_page; $i++){
                    $act = '';
                    if($page == $i){
                        $act = 'class="active"';
                    }
                    $page_html .= '<a href="javascript:;" onclick="fetchStorePageData('.$i.',\''.$type.'\')" '.$act.' >'.$i.'</a>';
                }
            }else{ //总页数大于5
                $page_array = array();
                if($page-1){
                    $page_array[$page-1] = '<a href="javascript:;" onclick="fetchStorePageData('.($page-1).',\''.$type.'\')" >'.($page-1).'</a>';
                }

                $page_array[$page] = '<a href="javascript:;" class="active" >'.$page.'</a>';
                if($page+1 <= $tot_page){
                    $page_array[$page+1] = '<a href="javascript:;" onclick="fetchStorePageData('.intval($page+1).',\''.$type.'\')" >'.intval($page+1).'</a>';
                }
                $skip = '<span class="skip-page">...</span>';

                if($page <= 3){
                    if($page == 3){
                        $page_html .= '<a href="javascript:;" onclick="fetchStorePageData(1,\''.$type.'\')" >1</a>';
                    }
                    $page_html .= implode('',$page_array);
                    $page_html .= $skip.'<a href="javascript:;" onclick="fetchStorePageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                }else{
                    $page_html .= '<a href="javascript:;" onclick="fetchStorePageData(1,\''.$type.'\')" >1</a>';
                    $page_html .= $skip;
                    $page_html .= implode('',$page_array);
                    if($page+1 < $tot_page){
                        $page_html .= $skip.'<a href="javascript:;" onclick="fetchStorePageData('.$tot_page.',\''.$type.'\')" >'.$tot_page.'</a>';
                    }
                    //$page_html .= implode('',$page_array);
                }

            }

            if($page+1 <= $tot_page){
                $page_html .= '<a href="javascript:;" onclick="fetchStorePageData('.intval($page+1).',\''.$type.'\')"  class="next-page">下一页</a>';
            }
        }
        return $page_html;
    }

    /**图片库功能使用
     * @param $total
     * @return string
     * 展示：第一页，前一页，当前页，后页面，最后一页
     */
    /**
     * @param $tot_page
     * @param $page
     * @return string
     * 总页数,当前页
     */
    public function ajaxImgPageLink($tot_page , $page, $type='', $gid){
        $page_html = '';
        if($tot_page > 1){
            //上一页
            if($page > 1){
                $page_html .= '<a href="javascript:;" onclick="fetchPageData('.intval($page-1).',\''.$type.'\', '.$gid.')" class="prev-page">上一页</a>';
            }
            //前5页
            if($tot_page <= 5){ //总页数小于等于5 全部展示
                for($i=1; $i<= $tot_page; $i++){
                    $act = '';
                    if($page == $i){
                        $act = 'class="active"';
                    }
                    $page_html .= '<a href="javascript:;" onclick="fetchPageData('.$i.',\''.$type.'\', '.$gid.')" '.$act.' >'.$i.'</a>';
                }
            }else{ //总页数大于5
                $page_array = array();
                if($page-1){
                    $page_array[$page-1] = '<a href="javascript:;" onclick="fetchPageData('.($page-1).',\''.$type.'\', '.$gid.')" >'.($page-1).'</a>';
                }

                $page_array[$page] = '<a href="javascript:;" class="active" >'.$page.'</a>';
                if($page+1 <= $tot_page){
                    $page_array[$page+1] = '<a href="javascript:;" onclick="fetchPageData('.intval($page+1).',\''.$type.'\', '.$gid.')" >'.intval($page+1).'</a>';
                }
                $skip = '<span class="skip-page">...</span>';

                if($page <= 3){
                    if($page == 3){
                        $page_html .= '<a href="javascript:;" onclick="fetchPageData(1,\''.$type.'\', '.$gid.')" >1</a>';
                    }
                    $page_html .= implode('',$page_array);
                    $page_html .= $skip.'<a href="javascript:;" onclick="fetchPageData('.$tot_page.',\''.$type.'\', '.$gid.')" >'.$tot_page.'</a>';
                }else{
                    $page_html .= '<a href="javascript:;" onclick="fetchPageData(1,\''.$type.'\', '.$gid.')" >1</a>';
                    $page_html .= $skip;
                    $page_html .= implode('',$page_array);
                    if($page+1 < $tot_page){
                        $page_html .= $skip.'<a href="javascript:;" onclick="fetchPageData('.$tot_page.',\''.$type.'\', '.$gid.')" >'.$tot_page.'</a>';
                    }
                    //$page_html .= implode('',$page_array);
                }

            }

            if($page+1 <= $tot_page){
                $page_html .= '<a href="javascript:;" onclick="fetchPageData('.intval($page+1).',\''.$type.'\', '.$gid.')"  class="next-page">下一页</a>';
            }
        }
        return $page_html;
    }
}