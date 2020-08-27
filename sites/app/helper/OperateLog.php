<?php

class App_Helper_OperateLog {

    /**
     * 保存操作日志
     */
    public static function saveOperateLog($message){
        $uid    = plum_app_user_islogin();
        $redis_shop = new App_Model_Shop_RedisShopQueueStorage();
        $curr_sid   = $redis_shop->getSidByUid($uid);

        $data = array(
            'mol_s_id'        => $curr_sid,
            'mol_type'        => '',
            'mol_url'         => $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
            'mol_mid'         => $uid,
            'mol_message'     => $message,
            'mol_change_data' => '',
            'mol_ip'          => plum_get_client_ip(),
            'mol_create_time' => time()
        );

        $operate_model = new App_Model_Member_MysqlManagerOperateLogStorage();
        return $operate_model->insertValue($data);
    }


    public static function savelog($sql){
        $uid    = plum_app_user_islogin();

        if(!$uid || !strstr($_REQUEST['q'], 'wxapp')){
            return false;
        }

        $cmd = trim(strtoupper(substr($sql, 0, strpos($sql, ' '))));
        switch ($cmd){
            case 'UPDATE':
                $ret = self::deal_update_sql($sql);
                break;
            case 'INSERT':
                $ret = self::deal_insert_sql($sql);
                break;
            case 'DELETE':
                $ret = self::deal_delete_sql($sql);
                break;
            default:
                return false;
        }

        return $ret;
    }

    protected static function deal_update_sql($sql){
        $pattern = '/update[\s]+`(.*?)`[\s]+/i';//匹配单引号或双引号
        preg_match($pattern, $sql, $tableNameMatches);
        $tableName = $tableNameMatches[1];
        if(!$tableName){
            return false;
        }

        $pattern = '/set (.*?) where/i';//匹配单引号或双引号
        preg_match($pattern, $sql, $setMatches);
        $setstr = $setMatches[1];
        if(!$setstr){
            return false;
        }
        $setArr = array();
        foreach (explode(',', $setstr) as $val){
            $field = trim(str_replace('`', '', explode('=', $val)[0]));
            $value = trim(str_replace("'", '', explode('=', $val)[1]));
            $setArr[$field] = $value;
        }

        if(empty($setArr)){
            return false;
        }

        $pattern = '/where (.*)/i';//匹配单引号或双引号
        preg_match($pattern, $sql, $whereMatches);
        $where = $whereMatches[0];
        if(!$where){
            return false;
        }

        $operatemap = plum_parse_config($tableName, 'operatemap');

        if(array_key_exists($operatemap['delete_tpl']['field'], $setArr)){
            return self::crate_deleted_operate_message($tableName, $where);
        }else{
            return self::crate_update_operate_message($tableName, $setArr, $where);
        }
    }

    protected static function crate_update_operate_message($tableName, $setArr, $where){
        $operatemap = plum_parse_config($tableName, 'operatemap');
        if(!$operatemap){
            return false;
        }

        $record_field = array_intersect_key($operatemap['update_tpl']['field'], $setArr);
        $record_field = array_keys($record_field);

        if(!$record_field){
            $old_sql = "select * from ".$tableName." ".$where;
            $oldArr = DB::fetch_first($old_sql, array(), true);
        }else{
            $old_sql = "select ".implode(',', $record_field)." from ".$tableName." ".$where;
            $oldArr = DB::fetch_first($old_sql, array(), true);
        }

        if(!$oldArr){
            return false;
        }

        $changeData = [];
        foreach ($record_field as $field){
            if($oldArr[$field] != $setArr[$field]){
                $changeData[] = array(
                    'title'    => $operatemap['update_tpl']['field'][$field],
                    'filed'    => $field,
                    'oldValue' => $oldArr[$field],
                    'newValue' => $setArr[$field]
                );
            }
        }

        if(!$changeData){
            return false;
        }

        $pattern = '/\{(.*?)\}/i';
        $message = $operatemap['update_tpl']['tpl'];
        preg_match_all($pattern, $message, $replaceMatches);
        foreach ($replaceMatches[1] as $val){
            $message = str_replace('{'.$val.'}', $oldArr[$val], $message);
        }
        $uid    = plum_app_user_islogin();
        $redis_shop = new App_Model_Shop_RedisShopQueueStorage();
        $curr_sid   = $redis_shop->getSidByUid($uid);

        $data = array(
            'mol_s_id'        => $curr_sid,
            'mol_type'        => 'update',
            'mol_url'         => $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
            'mol_mid'         => $uid,
            'mol_message'     => $message,
            'mol_change_data' => json_encode($changeData),
            'mol_ip'          => plum_get_client_ip(),
            'mol_create_time' => time()
        );

        $operate_model = new App_Model_Member_MysqlManagerOperateLogStorage();
        return $operate_model->insertValue($data);
    }

    protected static function deal_insert_sql($sql){
        $pattern = '/insert[\s]+into[\s]+`(.*?)`[\s]+/i';//匹配单引号或双引号
        preg_match($pattern, $sql, $tableNameMatches);
        $tableName = $tableNameMatches[1];
        if(!$tableName){
            return false;
        }

        $pattern = '/[\s]+(set|values) (.*)/i';//匹配单引号或双引号
        preg_match($pattern, $sql, $setMatches);
        $setstr = $setMatches[2];
        if(!$setstr){
            return false;
        }
        $setArr = array();
        foreach (explode(',', $setstr) as $val){
            $field = trim(str_replace('`', '', explode('=', $val)[0]));
            $value = trim(str_replace("'", '', explode('=', $val)[1]));
            $setArr[$field] = $value;
        }

        if(empty($setArr)){
            return false;
        }

        return self::crate_insert_operate_message($tableName, $setArr);
    }

    protected static function crate_insert_operate_message($tableName, $setArr){
        $operatemap = plum_parse_config($tableName, 'operatemap');
        $message = $operatemap['insert_tpl']['tpl'];

        foreach ($setArr as $key => $val){
            $message = str_replace('{'.$key.'}', $val, $message);
        }

        $uid    = plum_app_user_islogin();
        $redis_shop = new App_Model_Shop_RedisShopQueueStorage();
        $curr_sid   = $redis_shop->getSidByUid($uid);

        $data = array(
            'mol_s_id'        => $curr_sid,
            'mol_type'        => 'insert',
            'mol_url'         => $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
            'mol_mid'         => $uid,
            'mol_message'     => $message,
            'mol_change_data' => '',
            'mol_ip'          => plum_get_client_ip(),
            'mol_create_time' => time()
        );

        $operate_model = new App_Model_Member_MysqlManagerOperateLogStorage();
        return $operate_model->insertValue($data);
    }


    //TODO 一般用不到，等需要再完善
    protected static function deal_delete_sql($sql){
        return false;
    }

    protected static function crate_deleted_operate_message($tableName, $where){
        $operatemap = plum_parse_config($tableName, 'operatemap');
        if(!$operatemap){
            return false;
        }

        $old_sql = "select * from ".$tableName." ".$where;
        $oldArr = DB::fetch_first($old_sql, array(), true);

        if(!$oldArr){
            return false;
        }

        $pattern = '/\{(.*?)\}/i';
        $message = $operatemap['delete_tpl']['tpl'];
        preg_match_all($pattern, $message, $replaceMatches);
        foreach ($replaceMatches[1] as $val){
            $message = str_replace('{'.$val.'}', $oldArr[$val], $message);
        }
        $uid    = plum_app_user_islogin();
        $redis_shop = new App_Model_Shop_RedisShopQueueStorage();
        $curr_sid   = $redis_shop->getSidByUid($uid);

        $data = array(
            'mol_s_id'        => $curr_sid,
            'mol_type'        => 'delete',
            'mol_url'         => $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
            'mol_mid'         => $uid,
            'mol_message'     => $message,
            'mol_change_data' => '',
            'mol_ip'          => plum_get_client_ip(),
            'mol_create_time' => time()
        );

        $operate_model = new App_Model_Member_MysqlManagerOperateLogStorage();
        return $operate_model->insertValue($data);
    }
}
