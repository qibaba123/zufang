<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/27
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletArticleStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $shop_table;
    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'applet_article';
        $this->_pk      = 'aa_id';
        $this->_shopId  = 'aa_s_id';
        $this->_df      = 'aa_deleted';

        $this->sid      = $sid;
        $this->shop_table = DB::table('shop');
    }


}