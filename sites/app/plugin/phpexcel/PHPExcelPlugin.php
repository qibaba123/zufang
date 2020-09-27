<?php
require_once PLUM_DIR_APP . '/plugin/phpexcel/PHPExcel.php';
require_once PLUM_DIR_APP . '/plugin/phpexcel/PHPExcel/IOFactory.php';
require_once PLUM_DIR_APP . '/plugin/phpexcel/PHPExcel/Writer/Excel5.php';

class App_Plugin_PHPExcel_PHPExcelPlugin{

    private $objPHPExcel;
    public function __construct(){
        $this->objPHPExcel = new PHPExcel();
    }
/*
* @param $filename
* @throws PHPExcel_Reader_Exception
* 导出excel
*/
    public  function set_excel($filename){
        Libs_Log_Logger::outputLog('104','z.log');
        // 设置excel文档的属性
//        $this->objPHPExcel->getProperties()->setCreator("Ikinvin")
//            ->setLastModifiedBy("Maarten Balliauw")
//            ->setTitle("Office 2007 XLSX Test Document")
//            ->setSubject("Office 2007 XLSX Test Document")
//            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
//            ->setKeywords("office 2007 openxml php")
//            ->setCategory("Test result file");

        $this->objPHPExcel->getProperties()->setCreator("Sam.c")
            ->setLastModifiedBy("Sam.c Test")
            ->setTitle("Microsoft Office Excel Document")
            ->setSubject("Mine")
            ->setDescription("desc")
            ->setKeywords("key word")
            ->setCategory("Test result file");
        // 开始操作excel表
        // 操作第一个工作表
        $this->objPHPExcel->setActiveSheetIndex(0);
        // 设置工作薄名称
        $this->objPHPExcel->getActiveSheet()->setTitle(@iconv('gbk', 'utf-8//ignore', 'phpExcel'));
        // 设置默认字体和大小
        $this->objPHPExcel->getDefaultStyle()->getFont()->setName(@iconv('utf-8', 'gbk//ignore', '宋体'));
        $this->objPHPExcel->getDefaultStyle()->getFont()->setSize(10);


        $filename = iconv("utf-8", "GBK", $filename);

        // 修复 Macintosh 无法打开 GBK编码的Excel 文件问题
        // zhangzc
        // 2019-03-29
        $Agent=$_SERVER['HTTP_USER_AGENT'];
        if(strpos($Agent, 'Macintosh')){
            $filename = iconv("GBK", "utf-8", $filename);
            $this->objPHPExcel->getActiveSheet()->setTitle(@iconv('gbk', 'utf-8//ignore', 'phpExcel'));
            // 设置默认字体和大小
            $this->objPHPExcel->getDefaultStyle()->getFont()->setName(@iconv('gbk//ignore', 'utf-8', '宋体'));
        }

        ob_end_clean();
        ob_start();

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type: application/vnd.ms-excel;charset=utf-8;name='".$filename."'");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Disposition:attachment;filename=".$filename);
        header("Content-Transfer-Encoding:binary");


        // 从浏览器直接输出$filename
        Libs_Log_Logger::outputLog('105','z.log');
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
        $objWriter->save("php://output");exit;
    }

    /**
     * @param $filename
     * @param string $encode
     * @return array
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     * 读入会员信息表excel
     */
    public function readMemberInfo($filename,$license=1,$encode='utf-8'){
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $readerExcel = $objReader->load($filename);

        $objWorksheet = $readerExcel->getActiveSheet();

        // 取得总行数,5,6,7
        $highestRow = $objWorksheet->getHighestRow();
        // 取得总列数,ABCDF
        $highestColumn = $objWorksheet->getHighestColumn();
        //字母列转换为数字列 如:AA变为27
        $highestColumnIndex= PHPExcel_Cell::columnIndexFromString($highestColumn);
        //定义自定义字段
        $keys = array();
        for($col=0; $col<$highestColumnIndex; $col++){
            $value =  (string)$objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
            $keys[$col] =$this->_get_array_key_by_value($value);
        }
        $mobile = array();
        /** 循环读取每个单元格的数据 */
        $data = array();
        for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始
            $temp = array();
            for ($column = 0; $column < $highestColumnIndex; $column++) {//列数是以第0列开始
                $value = (string)$objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                $temp[$keys[$column]] = "'".$value."'";
                if($keys[$column] == 'm_mobile'){
                    $mobile[] = $value;
                }
            }
            $temp['m_create_time'] = time();
            $data[] =  $temp;
        }
        $info = array(
            'mobile' => $mobile,
            'data'   => $data
        );
        plum_msg_dump($info,1);
        return $info;
    }

    private function _get_array_key_by_value($value,$type){
        $key='';
        switch($type){
            case 'express':
                switch($value){
                    case '名称':
                        $key = 'e_name';
                        break;
                    case '编码':
                        $key = 'e_code';
                        break;
                }
                break;
            case 'subject':
                switch ($value){
                    case '题目':
                        $key = 'as_question';
                        break;
                    case '答案':
                        $key = 'as_answer';
                        break;
                    case '选项一':
                        $key = 'as_item1';
                        break;
                    case '选项二':
                        $key = 'as_item2';
                        break;
                    case '选项三':
                        $key = 'as_item3';
                        break;
                    case '选项四':
                        $key = 'as_item4';
                        break;
                    case '难度':
                        $key = 'as_degree';
                        break;
                }
            break;
        }

        return $key;
    }

    /**
     * @param $data
     * @param $filename
     * 导出订单表
     */
    public function down_orders($data,$filename, $columNums = array()){
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $info  = '订单号、购买人昵称、收货人姓名、手机、收货人省份、收货人城市、收货人地区、收货地址、邮编、快递单号/取货人手机号、运费、订单金额、商品名称、规格、单价、数量、优惠金额、促销减免金额、下单时间、付款时间、发货时间、买家备注、物流公司/取货人、自提门店、订单状态、购买方式、配送方式、完成时间';
        $width = '30、20、20、20、10、10、10、10、30、10、20、10、10、30、10、10、10、10、10、10、20、20、20、20、20、20、20、20';
        $num   = 'A、B、C、D、E、F、G、H、I、J、K、L、M、N、O、P、Q、R、S、T、U、V、W、X、Y、Z、AA、AB';
        $infos = explode('、',$info);
        $wids  = explode('、',$width);
        $nums  = explode('、',$num);
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
        foreach($nums as $nkey => $nval){
            $this->objPHPExcel->getActiveSheet()->setCellValue($nval.'1', $infos[$nkey]);
        }
        $i = 2;
        foreach($data as $item){
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['t_tid']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $this->utf8_str_to_unicode($item['t_buyer_nick']));
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item['s_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['s_phone']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item['s_province']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $item['s_city']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $item['s_zone']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $item['s_province'].' '.$item['s_city'].' '.$item['s_zone'].' '.$item['s_detail']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $item['s_post']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $item['o_exp_code']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $item['o_post_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $item['o_total_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $item['g_title']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $item['g_gg']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $item['g_tp']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $item['g_num']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $item['o_discount_fee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $item['o_promotion_fee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $item['o_createtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $item['o_paytime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $item['o_sendtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $item['o_sale_note']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $item['o_exp_company']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $item['o_store_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $item['o_status']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $item['o_paytype']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $item['o_express_method']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $item['o_finishtime']);
            $i ++;
        }
        if(!empty($columNums)){
            $i = 2;
            foreach ($columNums as $val){
                if($val > 1){
                    $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':A'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':B'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':C'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('D'.$i.':D'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('E'.$i.':E'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('F'.$i.':F'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':G'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('H'.$i.':H'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':I'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':J'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('K'.$i.':K'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('L'.$i.':L'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('Q'.$i.':Q'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('R'.$i.':R'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('S'.$i.':S'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('T'.$i.':T'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('U'.$i.':U'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('V'.$i.':V'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('W'.$i.':W'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('X'.$i.':X'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('Y'.$i.':Y'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('Z'.$i.':Z'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('AA'.$i.':AA'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('AB'.$i.':AB'.($i + $val - 1));


                    $this->objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('R'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('T'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('V'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('X'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('Z'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('AA'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('AB'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $i += $val;
                }elseif($val != 0){
                    $i += 1;
                }
            }
        }
        $this->set_excel($filename);
    }

    /**
     * @param $data
     * @param $filename
     * 导出订单表(按商品排序)
     */
    public function down_goods_sort_orders($data,$filename, $gidsNum = array(), $gfidsNum = array()){
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $info  = '订单号、购买人昵称、收货人姓名、手机、收货人省份、收货人城市、收货人地区、收货地址、邮编、快递单号/取货人手机号、运费、订单金额、商品名称、商品数量、规格、规格数量、单价、数量、优惠金额、促销减免金额、下单时间、付款时间、发货时间、买家备注、物流公司/取货人、自提门店、订单状态、购买方式、配送方式、完成时间';
        $width = '30、20、20、20、10、10、10、10、30、10、20、10、10、30、10、10、10、10、10、10、20、20、20、20、20、20、20、20、20、20';
        $num   = 'A、B、C、D、E、F、G、H、I、J、K、L、M、N、O、P、Q、R、S、T、U、V、W、X、Y、Z、AA、AB、AC、AD';
        $infos = explode('、',$info);
        $wids  = explode('、',$width);
        $nums  = explode('、',$num);
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
        foreach($nums as $nkey => $nval){
            $this->objPHPExcel->getActiveSheet()->setCellValue($nval.'1', $infos[$nkey]);
        }
        $i = 2;
        foreach($data as $item){
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['t_tid']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $this->utf8_str_to_unicode($item['t_buyer_nick']));
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item['s_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['s_phone']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item['s_province']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $item['s_city']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $item['s_zone']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $item['s_province'].' '.$item['s_city'].' '.$item['s_zone'].' '.$item['s_detail']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $item['s_post']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $item['o_exp_code']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $item['o_post_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $item['o_total_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $item['g_title']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $item['goodsnums']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $item['g_gg']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $item['formatnums']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $item['g_tp']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $item['g_num']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $item['o_discount_fee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $item['o_promotion_fee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $item['o_createtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $item['o_paytime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $item['o_sendtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $item['o_sale_note']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $item['o_exp_company']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $item['o_store_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $item['o_status']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $item['o_paytype']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $item['o_express_method']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $item['o_finishtime']);
            $i ++;
        }
        if(!empty($gidsNum)){
            $i = 2;
            foreach ($gidsNum as $val){
                if($val > 1){
                    $this->objPHPExcel->getActiveSheet()->mergeCells('N'.$i.':N'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $i += $val;
                }elseif($val != 0){
                    $i += 1;
                }
            }
        }
        if(!empty($gfidsNum)){
            $i = 2;
            foreach ($gfidsNum as $val){
                if($val > 1){
                    $this->objPHPExcel->getActiveSheet()->mergeCells('P'.$i.':P'.($i + $val - 1));

                    $this->objPHPExcel->getActiveSheet()->getStyle('P'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $i += $val;
                }elseif($val != 0){
                    $i += 1;
                }
            }
        }
        $this->set_excel($filename);
    }


    /**
     * @param $data
     * @param $filename
     * 导出订单表
     */
    public function down_community_orders($data,$filename, $columNums = array()){
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $info  = '订单号、商家名称、购买人昵称、收货人姓名、手机、收货人省份、收货人城市、收货人地区、收货地址、邮编、快递单号/取货人手机号、运费、订单金额、商品名称、规格、单价、数量、优惠金额、促销减免金额、下单时间、付款时间、发货时间、买家备注、物流公司/取货人、自提门店、订单状态、购买方式、配送方式、完成时间';
        $width = '30、20、20、20、10、10、10、10、30、10、20、10、10、30、10、10、10、10、10、10、20、20、20、20、20、20、20、20、20';
        $num   = 'A、B、C、D、E、F、G、H、I、J、K、L、M、N、O、P、Q、R、S、T、U、V、W、X、Y、Z、AA、AB、AC';
        $infos = explode('、',$info);
        $wids  = explode('、',$width);
        $nums  = explode('、',$num);
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
        foreach($nums as $nkey => $nval){
            $this->objPHPExcel->getActiveSheet()->setCellValue($nval.'1', $infos[$nkey]);
        }
        $i = 2;
        foreach($data as $item){
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['t_tid']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item['es_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $this->utf8_str_to_unicode($item['t_buyer_nick']));
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['s_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item['s_phone']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $item['s_province']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $item['s_city']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $item['s_zone']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $item['s_province'].' '.$item['s_city'].' '.$item['s_zone'].' '.$item['s_detail']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $item['s_post']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $item['o_exp_code']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $item['o_post_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $item['o_total_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $item['g_title']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $item['g_gg']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $item['g_tp']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $item['g_num']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $item['o_discount_fee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $item['o_promotion_fee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $item['o_createtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $item['o_paytime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $item['o_sendtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $item['o_sale_note']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $item['o_exp_company']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $item['o_store_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $item['o_status']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $item['o_paytype']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $item['o_express_method']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $item['o_finishtime']);
            $i ++;
        }
        if(!empty($columNums)){
            $i = 2;
            foreach ($columNums as $val){
                if($val > 1){
                    $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':A'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':B'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':C'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('D'.$i.':D'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('E'.$i.':E'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('F'.$i.':F'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':G'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('H'.$i.':H'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':I'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':J'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('K'.$i.':K'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('L'.$i.':L'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('M'.$i.':M'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('R'.$i.':R'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('S'.$i.':S'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('T'.$i.':T'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('U'.$i.':U'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('V'.$i.':V'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('W'.$i.':W'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('X'.$i.':X'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('Y'.$i.':Y'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('Z'.$i.':Z'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('AA'.$i.':AA'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('AB'.$i.':AB'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('AC'.$i.':AC'.($i + $val - 1));

                    $this->objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('R'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('T'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('V'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('X'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('Z'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('AA'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('AB'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('AC'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $i += $val;
                }elseif($val != 0){
                    $i += 1;
                }
            }
        }
        $this->set_excel($filename);
    }

    /**
     * @param $data
     * @param $filename
     * 导出订单表(按商品排序)
     */
    public function down_community_goods_sort_orders($data,$filename, $gidsNum = array(), $gfidsNum = array()){
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $info  = '订单号、商家名称、购买人昵称、收货人姓名、手机、收货人省份、收货人城市、收货人地区、收货地址、邮编、快递单号/取货人手机号、运费、订单金额、商品名称、商品数量、规格、规格数量、单价、数量、优惠金额、促销减免金额、下单时间、付款时间、发货时间、买家备注、物流公司/取货人、自提门店、订单状态、购买方式、配送方式、完成时间';
        $width = '30、20、20、20、10、10、10、10、30、10、20、10、10、30、10、10、10、10、10、10、20、20、20、20、20、20、20、20、20、20、20';
        $num   = 'A、B、C、D、E、F、G、H、I、J、K、L、M、N、O、P、Q、R、S、T、U、V、W、X、Y、Z、AA、AB、AC、AD、AE';
        $infos = explode('、',$info);
        $wids  = explode('、',$width);
        $nums  = explode('、',$num);
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
        foreach($nums as $nkey => $nval){
            $this->objPHPExcel->getActiveSheet()->setCellValue($nval.'1', $infos[$nkey]);
        }
        $i = 2;
        foreach($data as $item){
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['t_tid']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item['es_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $this->utf8_str_to_unicode($item['t_buyer_nick']));
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['s_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item['s_phone']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $item['s_province']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $item['s_city']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $item['s_zone']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $item['s_province'].' '.$item['s_city'].' '.$item['s_zone'].' '.$item['s_detail']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $item['s_post']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $item['o_exp_code']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $item['o_post_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $item['o_total_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $item['g_title']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $item['goodsnums']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $item['g_gg']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $item['formatnums']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $item['g_tp']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $item['g_num']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $item['o_discount_fee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $item['o_promotion_fee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $item['o_createtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $item['o_paytime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $item['o_sendtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $item['o_sale_note']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $item['o_exp_company']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $item['o_store_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $item['o_status']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $item['o_paytype']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $item['o_express_method']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, $item['o_finishtime']);
            $i ++;
        }
        if(!empty($gidsNum)){
            $i = 2;
            foreach ($gidsNum as $val){
                if($val > 1){
                    $this->objPHPExcel->getActiveSheet()->mergeCells('N'.$i.':N'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $i += $val;
                }elseif($val != 0){
                    $i += 1;
                }
            }
        }
        if(!empty($gfidsNum)){
            $i = 2;
            foreach ($gfidsNum as $val){
                if($val > 1){
                    $this->objPHPExcel->getActiveSheet()->mergeCells('P'.$i.':P'.($i + $val - 1));

                    $this->objPHPExcel->getActiveSheet()->getStyle('P'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $i += $val;
                }elseif($val != 0){
                    $i += 1;
                }
            }
        }
        $this->set_excel($filename);
    }


    /**
     * @param $data
     * @param $filename
     * 社区团购导出订单表
     */
    public function down_orders_sequence($data,$filename, $columNums = array()){
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $info  = '订单号、购买人昵称、活动名称、商品名称、单价、数量、运费、优惠金额、订单金额、订单状态、所属小区、团长姓名、团长电话、配送方式、取货人、取货人手机号、收货人姓名、收货人手机、收货人省份、收货人城市、收货人地区、收货地址、买家备注、下单时间、付款时间、完成时间、成本、利润(未除去团长佣金)';
        $width = '30、20、40、40、10、10、10、10、10、10、20、20、20、20、20、20、20、10、10、10、30、30、20、20、20、20、20、10、40';
        $num   = 'A、B、C、D、E、F、G、H、I、J、K、L、M、N、O、P、Q、R、S、T、U、V、W、X、Y、Z、AA、AB';
        $infos = explode('、',$info);
        $wids  = explode('、',$width);
        $nums  = explode('、',$num);
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
        foreach($nums as $nkey => $nval){
            $this->objPHPExcel->getActiveSheet()->setCellValue($nval.'1', $infos[$nkey]);
        }
        $i = 2;
        foreach($data as $item){
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['t_tid']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $this->utf8_str_to_unicode($item['t_buyer_nick']));
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item['o_activity']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['g_title']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item['g_tp']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $item['g_num']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $item['o_post_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $item['o_discount_fee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $item['o_total_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $item['o_status']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $item['o_community']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $item['o_leader_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $item['o_leader_mobile']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $item['o_express_method']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $item['o_exp_company']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $item['o_exp_code']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $item['s_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $item['s_phone']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $item['s_province']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $item['s_city']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $item['s_zone']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $item['s_province'].' '.$item['s_city'].' '.$item['s_zone'].' '.$item['s_detail']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $item['o_sale_note']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $item['o_createtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $item['o_paytime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $item['o_finishtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $item['cost']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, floatval($item['o_total_price']-$item['cost']));

//            $this->objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $item['o_se_send_time']);
            $i ++;
        }
        if(!empty($columNums)){
            $i = 2;
            foreach ($columNums as $val){
                if($val > 1){
                    $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':A'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':B'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':C'.($i + $val - 1));
                    //$this->objPHPExcel->getActiveSheet()->mergeCells('D'.$i.':D'.($i + $val - 1));
                    //$this->objPHPExcel->getActiveSheet()->mergeCells('E'.$i.':E'.($i + $val - 1));
                    //$this->objPHPExcel->getActiveSheet()->mergeCells('F'.$i.':F'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':G'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('H'.$i.':H'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':I'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':J'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('K'.$i.':K'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('L'.$i.':L'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('M'.$i.':M'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('N'.$i.':N'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('O'.$i.':O'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('P'.$i.':P'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('Q'.$i.':Q'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('R'.$i.':R'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('S'.$i.':S'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('T'.$i.':T'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('U'.$i.':U'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('V'.$i.':V'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('W'.$i.':W'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('X'.$i.':X'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('Y'.$i.':Y'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('Z'.$i.':Z'.($i + $val - 1));
//                    $this->objPHPExcel->getActiveSheet()->mergeCells('Y'.$i.':Y'.($i + $val - 1));


                    $this->objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    //$this->objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    //$this->objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    //$this->objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('O'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('P'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('R'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('T'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('V'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('X'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('Z'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//                    $this->objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $i += $val;
                }elseif($val != 0){
                    $i += 1;
                }
            }
        }
        $this->set_excel($filename);
    }


    public function down_orders_sequence_new($data,$filename, $columNums = array()){
        // Libs_Log_Logger::outputLog($data,'test.log');
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $info  = '订单号、购买人昵称、商品名称、规格、单价、数量、运费、优惠金额、订单金额、订单状态、所属小区、团长姓名、团长电话、配送方式、取货人、取货人手机号、收货人姓名、收货人手机、收货人省份、收货人城市、收货人地区、收货地址、买家备注、下单时间、付款时间、完成时间、自提/配送时间、成本、利润(未除去团长佣金)、供应商名称、供应商联系人、供应商电话';
        $width = '30、20、40、20、10、10、10、10、10、10、20、20、20、20、20、20、20、20、20、30、30、20、20、20、20、20、20、10、40、15、15、15';
        $num   = 'A、B、C、D、E、F、G、H、I、J、K、L、M、N、O、P、Q、R、S、T、U、V、W、X、Y、Z、AA、AB、AC、AD、AE、AF';
        $infos = explode('、',$info);
        $wids  = explode('、',$width);
        $nums  = explode('、',$num);
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
        foreach($nums as $nkey => $nval){
            $this->objPHPExcel->getActiveSheet()->setCellValue($nval.'1', $infos[$nkey]);
        }
        $i = 2;
        foreach($data as $item){
            $address = $item['o_express_method_id'] == 6 ? $item['o_address'] : $item['s_province'].' '.$item['s_city'].' '.$item['s_zone'].' '.$item['s_detail'];


            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['t_tid']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $this->utf8_str_to_unicode($item['t_buyer_nick']));
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item['g_title']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['g_gg']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item['g_tp']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $item['g_num']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $item['o_post_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $item['o_discount_fee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $item['o_total_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $item['o_status']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $item['o_community']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $item['o_leader_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $item['o_leader_mobile']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $item['o_express_method']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $item['o_exp_company']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $item['o_exp_code']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $item['s_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $item['s_phone']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $item['s_province']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $item['s_city']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $item['s_zone']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $address);
            $this->objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $item['o_sale_note']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $item['o_createtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $item['o_paytime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $item['o_finishtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $item['o_se_send_time']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $item['cost']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, floatval($item['o_total_price']-$item['cost']));
            $this->objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $item['assi_name'].' ');
            $this->objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, $item['assi_contact'].' ');
            $this->objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, $item['assi_mobile'].' ');
            $i ++;
        }
        if(!empty($columNums)){
            $i = 2;
            foreach ($columNums as $val){
                if($val > 1){
                    $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':A'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':B'.($i + $val - 1));
                    // $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':C'.($i + $val - 1));
                    //  $this->objPHPExcel->getActiveSheet()->mergeCells('D'.$i.':D'.($i + $val - 1));
                    //  $this->objPHPExcel->getActiveSheet()->mergeCells('E'.$i.':E'.($i + $val - 1));
                    // $this->objPHPExcel->getActiveSheet()->mergeCells('F'.$i.':F'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':G'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('H'.$i.':H'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':I'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':J'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('K'.$i.':K'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('L'.$i.':L'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('M'.$i.':M'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('N'.$i.':N'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('O'.$i.':O'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('P'.$i.':P'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('Q'.$i.':Q'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('R'.$i.':R'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('S'.$i.':S'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('T'.$i.':T'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('U'.$i.':U'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('V'.$i.':V'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('W'.$i.':W'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('X'.$i.':X'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('Y'.$i.':Y'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('Z'.$i.':Z'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('AA'.$i.':AA'.($i + $val - 1));


                    $this->objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//                    $this->objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    //$this->objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    //$this->objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//                    $this->objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('O'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('P'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('R'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('T'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('V'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('X'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('Z'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('AA'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('AB'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('AC'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $i += $val;
                }elseif($val != 0){
                    $i += 1;
                }
            }
        }
        $this->set_excel($filename);
    }

    public function down_goods_sort_sequence_orders($data,$filename, $gidsNum = array(), $gfidsNum = array()){
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        //供应商第九个开始
        $info  = '订单号、购买人昵称、商品名称、商品数量、规格、规格数量、单价、数量、运费、优惠金额、订单金额、订单状态、所属小区、团长姓名、团长电话、配送方式、取货人、取货人手机号、收货人姓名、收货人手机、收货人省份、收货人城市、收货人地区、收货地址、买家备注、下单时间、付款时间、完成时间、自提/配送时间、成本、利润(未除去团长佣金)、供应商名称、供应商联系人、供应商电话';
        $width = '30、20、40、20、10、10、10、10、10、10、20、20、20、20、20、20、20、20、20、30、30、20、20、20、20、20、20、20、20、10、40、15、15、15';
        $num   = 'A、B、C、D、E、F、G、H、I、J、K、L、M、N、O、P、Q、R、S、T、U、V、W、X、Y、Z、AA、AB、AC、AD、AE、AF、AG、AH';
        $infos = explode('、',$info);
        $wids  = explode('、',$width);
        $nums  = explode('、',$num);
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
        foreach($nums as $nkey => $nval){
            $this->objPHPExcel->getActiveSheet()->setCellValue($nval.'1', $infos[$nkey]);
        }
        $i = 2;
        foreach($data as $item){
            $address = $item['o_express_method_id'] == 6 ? $item['o_address'] : $item['s_province'].' '.$item['s_city'].' '.$item['s_zone'].' '.$item['s_detail'];

            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['t_tid']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $this->utf8_str_to_unicode($item['t_buyer_nick']));
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item['g_title']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['goodsnums']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item['g_gg']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $item['formatnums']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $item['g_tp']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $item['g_num']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $item['o_post_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $item['o_discount_fee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $item['o_total_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $item['o_status']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $item['o_community']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $item['o_leader_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $item['o_leader_mobile']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $item['o_express_method']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $item['o_exp_company']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $item['o_exp_code']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $item['s_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $item['s_phone']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $item['s_province']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $item['s_city']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $item['s_zone']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $address);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $item['o_sale_note']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $item['o_createtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $item['o_paytime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $item['o_finishtime']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $item['o_se_send_time']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $item['cost']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, floatval($item['o_total_price']-$item['cost']));
            $this->objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, $item['assi_name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, $item['assi_contact']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('AH' . $i, $item['assi_mobile']);
            $i ++;
        }

        if(!empty($gidsNum)){
            $i = 2;
            foreach ($gidsNum as $val){
                if($val > 1){
                    $this->objPHPExcel->getActiveSheet()->mergeCells('D'.$i.':D'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $i += $val;
                }elseif($val != 0){
                    $i += 1;
                }
            }
        }
        if(!empty($gfidsNum)){
            $i = 2;
            foreach ($gfidsNum as $val){
                if($val > 1){
                    $this->objPHPExcel->getActiveSheet()->mergeCells('F'.$i.':F'.($i + $val - 1));

                    $this->objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $i += $val;
                }elseif($val != 0){
                    $i += 1;
                }
            }
        }

        $this->set_excel($filename);
    }
    /**
     * utf8字符转换成Unicode字符
     */
    private function utf8_str_to_unicode($utf8_str) {
        $unicode_str = '';
        for($i=0;$i<mb_strlen($utf8_str);$i++){
            $val = mb_substr($utf8_str,$i,1,'utf-8');
            if(strlen($val) >= 4){
                $unicode_str.= '?';
            }else{
                $unicode_str.=$val;
            }
        }
        return $unicode_str;
    }

    /**
     * @param $data 数据
     * @param $filename 文件名
     * @param array $set_width array('A'=>20);
     * 通用导出EXCEL
     */
    public function down_common_excel($data,$filename,$set_width=array()){
        $this->objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        //设置每一列的宽度
        if(!empty($set_width) && is_array($set_width)){
            foreach($set_width as $key => $val){
                $this->objPHPExcel->getActiveSheet()->getColumnDimension($key)->setWidth($val);

            }
        }
        //填充每一列每一行的数据
        for($i=0;$i<count($data);$i++){
            $temp = $data[$i];
            for($j=0;$j<count($temp);$j++){
                $str = chr($j+65);
                $num = $i + 1;
                $this->objPHPExcel->getActiveSheet()->setCellValue($str . $num, $temp[$j]);
            }
        }
        //导出数据
        if(empty($filename)) $filename = 'test.xls';
        $this->set_excel($filename);
    }

    /**
     * @param $data 数据
     * @param $filename 文件名
     * @param array $set_width array('A'=>20);
     * 通用导出EXCEL(带图片的)
     */
    public function down_common_image_excel($data,$filename,$set_width=array()){

        $this->objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        //设置每一列的宽度
        if(!empty($set_width) && is_array($set_width)){
            foreach($set_width as $key => $val){
                $this->objPHPExcel->getActiveSheet()->getColumnDimension($key)->setWidth($val);
            }
        }
        //填充每一列每一行的数据
        for($i=0;$i<count($data);$i++){
            $temp = $data[$i];
            for($j=0;$j<count($temp);$j++){
                $str = chr($j+65);
                $num = $i + 1;
                if ($temp[$j]['type'] == 1) {
                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setPath(PLUM_DIR_ROOT.$temp[$j]['value']);
                    $objDrawing->setHeight(20);
                    $objDrawing->setCoordinates($str . $num);
                    $objDrawing->setOffsetX(10);
                    $objDrawing->setRotation(0);
                    $objDrawing->getShadow()->setVisible(true);
                    $objDrawing->getShadow()->setDirection(50);
                    $objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
                    continue;
                }
                $this->objPHPExcel->getActiveSheet()->setCellValue($str . $num, $temp[$j]['value']);
            }
        }
        //导出数据
        if(empty($filename)) $filename = 'test.xls';
        $this->set_excel($filename);
    }


    /**
     * @param $filename
     * @param int $license
     * @return array
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     * 获取导入excel数据信息
     */
    public function get_excel_info($filename,$type,$license=1){
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');//use excel2003 和  2007 format
        $PHPLoad = PHPExcel_IOFactory::load($filename);

        $objWorksheet = $PHPLoad->getActiveSheet();

        // 取得总行数,5,6,7
        $highestRow = $objWorksheet->getHighestRow();
        // 取得总列数,ABCDF
        $highestColumn = $objWorksheet->getHighestColumn();
        //字母列转换为数字列 如:AA变为27
        $highestColumnIndex= PHPExcel_Cell::columnIndexFromString($highestColumn);

        //定义自定义字段
        $keys = array();
        for($col=0; $col<$highestColumnIndex; $col++){
            $value =  (string)$objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
            $keys[$col] =$this->_get_array_key_by_value($value,$type);
        }
        /** 循环读取每个单元格的数据 */
        $data = array();
        for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始
            $temp = array();
            for ($column = 0; $column < $highestColumnIndex; $column++) { //列数是以第0列开始
                if($keys[$column]){
                    $value = (string)$objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                    $temp[$keys[$column]] = "'".$value."'";
                }
            }
            $data[] =  $temp;
        }
        $info = array(
            'data'   => $data
        );

        return $info;
    }

    /**
     * @param $filename
     * @param int $license
     * @return array
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     * 获取导入excel数据信息
     */
    public function get_excel_subject_info($filename,$type,$license=1){
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');//use excel2003 和  2007 format
        $PHPLoad = PHPExcel_IOFactory::load($filename);

        $objWorksheet = $PHPLoad->getActiveSheet();

        // 取得总行数,5,6,7
        $highestRow = $objWorksheet->getHighestRow();
        // 取得总列数,ABCDF
        $highestColumn = $objWorksheet->getHighestColumn();
        //字母列转换为数字列 如:AA变为27
        $highestColumnIndex= PHPExcel_Cell::columnIndexFromString($highestColumn);
        //定义自定义字段
        $keys = array();
        for($col=0; $col<$highestColumnIndex; $col++){
            $value =  (string)$objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
            $keys[$col] =$this->_get_array_key_by_value($value,$type);
        }
        /** 循环读取每个单元格的数据 */
        $data = array();
        for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始
            $temp = array();
            for ($column = 0; $column < $highestColumnIndex; $column++) { //列数是以第0列开始
                if($keys[$column]){
                    $value = (string)$objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                    $temp[$keys[$column]] = "'".$value."'";
                }
            }
            $data[] =  $temp;
        }
        $info = array(
            'data'   => $data
        );

        return $info;
    }


    /**
     * @param $data
     * @param $filename
     * 导出二维码红包红包码
     */
    public function down_qrcode_code($data,$filename){
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $info  = '红包码';
        $width = '30';
        $num   = 'A';
        $infos = array('红包码');
        $wids  = array('30');
        $nums  = array('A');
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
//        foreach($nums as $nkey => $nval){
//            $this->objPHPExcel->getActiveSheet()->setCellValue($nval.'1', $infos[$nkey]);
//        }
        $i = 1;
        foreach($data as $item){
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item);
            $i ++;
        }
        $this->set_excel($filename);
    }

    /**
     * @param $data
     * @param $filename
     * 导出订单表
     */
    public function down_sequence_group_goods($data,$listData,$filename){
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $info  = '商品名称、数量、总金额、 、 ' ;
        $width = '30、30、30、30、30';
        $num   = 'A、B、C、D、E';
        $infos = explode('、',$info);
        $wids  = explode('、',$width);
        $nums  = explode('、',$num);
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
//        //活动信息部分
        $this->objPHPExcel->getActiveSheet()->setCellValue('A' . 1, '群组编号:');
        $this->objPHPExcel->getActiveSheet()->setCellValue('B' . 1, $data['id']);
        $this->objPHPExcel->getActiveSheet()->setCellValue('C' . 1, ' ');
        $this->objPHPExcel->getActiveSheet()->setCellValue('D' . 1, '活动名称:');
        $this->objPHPExcel->getActiveSheet()->setCellValue('E' . 1, $data['activity']);
        $this->objPHPExcel->getActiveSheet()->setCellValue('A' . 2, '团长姓名:');
        $this->objPHPExcel->getActiveSheet()->setCellValue('B' . 2, $data['name']);
        $this->objPHPExcel->getActiveSheet()->setCellValue('C' . 2, ' ');
        $this->objPHPExcel->getActiveSheet()->setCellValue('D' . 2, '团长昵称:');
        $this->objPHPExcel->getActiveSheet()->setCellValue('E' . 2, $data['nickname']);
        $this->objPHPExcel->getActiveSheet()->setCellValue('A' . 3, '团长电话:');
        $this->objPHPExcel->getActiveSheet()->setCellValue('B' . 3, $data['mobile']);
        $this->objPHPExcel->getActiveSheet()->setCellValue('C' . 3, ' ');
        $this->objPHPExcel->getActiveSheet()->setCellValue('D' . 3, '小区名称:');
        $this->objPHPExcel->getActiveSheet()->setCellValue('E' . 3, $data['community']);

        //列表信息部分
        foreach($nums as $nkey => $nval){
            $this->objPHPExcel->getActiveSheet()->setCellValue($nval.'5', $infos[$nkey]);
        }
        $i = 6;
        foreach($listData as $item){
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item['num']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item['money']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $i, ' ');
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $i, ' ');
            $i ++;
        }

        $this->set_excel($filename);
    }

    public function down_community_leader_goods($data,$listData,$filename){
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $info  = '商品名称、规格、数量、总金额、 、 ' ;
        $width = '40、30、30、30、30、30、30';
        $num   = 'A、B、C、D、E、F';
        $infos = explode('、',$info);
        $wids  = explode('、',$width);
        $nums  = explode('、',$num);
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
//        //活动信息部分

        $this->objPHPExcel->getActiveSheet()->setCellValue('A' . 1, '团长姓名:');
        $this->objPHPExcel->getActiveSheet()->setCellValue('B' . 1, $data['name']);
        $this->objPHPExcel->getActiveSheet()->setCellValue('C' . 1, ' ');
        $this->objPHPExcel->getActiveSheet()->setCellValue('D' . 1, '团长昵称:');
        $this->objPHPExcel->getActiveSheet()->setCellValue('E' . 1, $data['nickname']);
        $this->objPHPExcel->getActiveSheet()->setCellValue('A' . 2, '团长电话:');
        $this->objPHPExcel->getActiveSheet()->setCellValue('B' . 2, $data['mobile']);
        $this->objPHPExcel->getActiveSheet()->setCellValue('C' . 2, ' ');
        $this->objPHPExcel->getActiveSheet()->setCellValue('D' . 2, '小区名称:');
        $this->objPHPExcel->getActiveSheet()->setCellValue('E' . 2, $data['community']);

        //列表信息部分
        foreach($nums as $nkey => $nval){
            $this->objPHPExcel->getActiveSheet()->setCellValue($nval.'4', $infos[$nkey]);
        }
        $i = 5;
        foreach($listData as $item){
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item['format']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item['num']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['money']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $i, ' ');
            $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $i, ' ');
            $i ++;
        }

        $this->set_excel($filename);
    }

    public function down_community_leader_goods_new($infoData,$filename){
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $info  = '商品名称、规格、数量、总金额、 、 ' ;
        $width = '40、30、30、30、30、30、30';
        $num   = 'A、B、C、D、E、F';
        $infos = explode('、',$info);
        $wids  = explode('、',$width);
        $nums  = explode('、',$num);
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
        $total_line = 0;
//        //活动信息部分
        foreach ($infoData as $k => $v){
            $total_line = $k == 0 ? 1 : $total_line + 2;
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $total_line, '团长姓名: '.$v['groupData']['name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $total_line, '团长昵称: '.$v['groupData']['nickname']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $total_line, '团长电话: '.$v['groupData']['mobile']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $total_line, '小区名称: '.$v['groupData']['community']);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$total_line.':D'.$total_line)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->objPHPExcel->getActiveSheet()->getStyle('A'.$total_line.':D'.$total_line)->getFill()->getStartColor()->setARGB('FFD0CECE');

            //列表信息部分
            foreach($nums as $nkey => $nval){
                $this->objPHPExcel->getActiveSheet()->setCellValue($nval.($total_line + 2), $infos[$nkey]);
            }
            $i = $total_line + 3;
            foreach($v['data'] as $item){
                $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['name']);
                $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item['format']);
                $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item['num']);
                $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['money']);
                $i ++;
            }
            $total_line = $i;
        }


        $this->set_excel($filename);
    }

    public function down_supplier_goods($data,$listData,$filename){
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $info  = '商品名称、规格、数量、总金额、 、 ' ;
        $width = '40、30、30、30、30、30、30';
        $num   = 'A、B、C、D、E、F';
        $infos = explode('、',$info);
        $wids  = explode('、',$width);
        $nums  = explode('、',$num);
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
//        //活动信息部分

        $this->objPHPExcel->getActiveSheet()->setCellValue('A' . 1, '供应商:');
        $this->objPHPExcel->getActiveSheet()->setCellValue('B' . 1, $data['name']);
        $this->objPHPExcel->getActiveSheet()->setCellValue('C' . 1, ' ');
        $this->objPHPExcel->getActiveSheet()->setCellValue('A' . 2, '联系人:');
        $this->objPHPExcel->getActiveSheet()->setCellValue('B' . 2, $data['contact']);
        $this->objPHPExcel->getActiveSheet()->setCellValue('C' . 2, ' ');
        $this->objPHPExcel->getActiveSheet()->setCellValue('D' . 2, '电话:');
        $this->objPHPExcel->getActiveSheet()->setCellValue('E' . 2, $data['mobile']);

        //列表信息部分
        foreach($nums as $nkey => $nval){
            $this->objPHPExcel->getActiveSheet()->setCellValue($nval.'4', $infos[$nkey]);
        }
        $i = 5;
        foreach($listData as $item){
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['name']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item['format']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item['num']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['money']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $i, ' ');
            $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $i, ' ');
            $i ++;
        }

        $this->set_excel($filename);
    }

    /**
     * @param $data
     * @param $filename
     * 导出订单表
     */
    public function down_deduct($data,$filename, $columNums = array()){
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $info  = '核销日期、购买人、订单号、商品名称、规格、单价、数量、下单时间、商品金额、配送费、订单金额、佣金';
        $width = '20、30、30、20、20、10、10、20、20、20、20、10';
        $num   = 'A、B、C、D、E、F、G、H、I、J、K、L';
        $infos = explode('、',$info);
        $wids  = explode('、',$width);
        $nums  = explode('、',$num);
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
        foreach($nums as $nkey => $nval){
            $this->objPHPExcel->getActiveSheet()->setCellValue($nval.'1', $infos[$nkey]);
        }
        $i = 2;
        foreach($data as $item){
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['o_verify_time']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $this->utf8_str_to_unicode($item['t_buyer_nick']));
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item['t_tid']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['g_title']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item['g_gg']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $item['g_tp']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $item['g_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $item['o_create_time']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $item['o_goods_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $item['o_post_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $item['o_total_price']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $item['o_deduct_money']);
            $i ++;
        }
        if(!empty($columNums)){
            $i = 2;
            foreach ($columNums as $val){
                if($val > 1){
                    $this->objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':A'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':B'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':C'.($i + $val - 1));

                    $this->objPHPExcel->getActiveSheet()->mergeCells('H'.$i.':H'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':I'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':J'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('K'.$i.':K'.($i + $val - 1));
                    $this->objPHPExcel->getActiveSheet()->mergeCells('L'.$i.':L'.($i + $val - 1));


                    $this->objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $i += $val;
                }elseif($val != 0){
                    $i += 1;
                }
            }
        }
        $this->set_excel($filename);
    }

    /**
     * 导出csv(适合大数据量)
     */
    public function csv_export($data = array(), $headlist = array(), $fileName){
        $info  = '订单号、购买人昵称、商品名称、商品数量、规格、规格数量、单价、数量、运费、优惠金额、订单金额、订单状态、所属小区、团长姓名、团长电话、配送方式、取货人、取货人手机号、收货人姓名、收货人手机、收货人省份、收货人城市、收货人地区、收货地址、买家备注、下单时间、付款时间、完成时间、自提/配送时间';
        $headlist = explode('、',$info);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
        header('Cache-Control: max-age=0');

        //打开PHP文件句柄,php://output 表示直接输出到浏览器
        $fp = fopen('php://output', 'a');

        //输出Excel列名信息
        foreach ($headlist as $key => $value) {
            //CSV的Excel支持GBK编码，一定要转换，否则乱码
            $headlist[$key] = iconv('utf-8', 'gbk', $value);
        }

        //将数据通过fputcsv写到文件句柄
        fputcsv($fp, $headlist);

        //计数器
        $num = 0;

        //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 100000;

        //逐行取出数据，不浪费内存
        $count = count($data);
        for ($i = 0; $i < $count; $i++) {

            $num++;

            //刷新一下输出buffer，防止由于数据过多造成问题
            if ($limit == $num) {
                ob_flush();
                flush();
                $num = 0;
            }

            $row = $data[$i];
            foreach ($row as $key => $value) {
                $row[$key] = iconv('utf-8', 'gbk', $value);
            }

            fputcsv($fp, $row);
        }
    }


    /**
     * @param $data
     * @param $filename
     * 导出订单表
     */
    public function down_legwork_order($data,$filename, $columNums = array()){
        $this->objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $info  = '购买人、订单号、订单状态、下单时间、取货/买货地址、取货联系人、取货联系方式、收货地址、收货联系人、收货联系方式、骑手名称、骑手电话、骑手佣金、备注信息、配送费、商品费用、小费、重量附加费、时间附加费、总费用、实付款';
        $width = '30、30、10、10、30、20、20、30、20、20、20、20、10、30、10、10、10、15、15、10、10';
        $num   = 'A、B、C、D、E、F、G、H、I、J、K、L、M、N、O、P、Q、R、S、T、U';
        $infos = explode('、',$info);
        $wids  = explode('、',$width);
        $nums  = explode('、',$num);
        foreach($nums as $key => $val){
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth($wids[$key]);
        }
        foreach($nums as $nkey => $nval){
            $this->objPHPExcel->getActiveSheet()->setCellValue($nval.'1', $infos[$nkey]);
        }
        $i = 2;
//        Libs_Log_Logger::outputLog($data[0],'test.log');
//        die;
        foreach($data as $item){
            $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['nickname']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item['tid'].' ');
            $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item['statusNote']." ");
            $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['createTime']);
            if($item['type'] == 1){
                //取货、买货
                $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item['toAddr']);
                $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $i, ' ');
                $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $i, ' ');
                //收货
                $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $item['fromAddr']);
                $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $item['addrName']);
                $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $item['addrPhone'].' ');
            }else{
                //取货、买货
                $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item['fromAddr']);
                $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $item['addrName']);
                $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $item['addrPhone'].' ');
                //收货
                $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $item['toAddr']);
                $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $item['terminiName']);
                $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $item['terminiPhone'].' ');
            }
            $this->objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $item['riderName']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $item['riderMobile'].' ');
            $this->objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $item['totalRiderFee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $item['remarkExtra']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $item['totalPostFee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $item['goodsFee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $item['tipFee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $item['weightFee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $item['timeFee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $item['totalFee']);
            $this->objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $item['payment']);
            $i ++;
        }

        $this->set_excel($filename);
    }

}

