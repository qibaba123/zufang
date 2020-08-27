<?php
/**
 * 平台商品库存变动记录
 * zhangzc
 * 2019-09-03
 */
class App_Model_Trade_MysqlTradeRecordStorage extends Libs_Mvc_Model_BaseModel{
	public function __construct($sid=0){
		$this->_table 	= 'trade_stock_record';
        $this->_pk 		= 'tsr_id';
        $this->_df 	    = 'e_deleted';
        parent::__construct();
	}
}