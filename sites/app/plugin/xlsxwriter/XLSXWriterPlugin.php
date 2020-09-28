<?php
/**
 * 导出excel文件格式优化内存占用与速度
 * 注意： 传递过来的数组排序必须按照要导出的数据格式进行排序
 *          导出的文件的后缀格式为xlsx
 *
 * 首行冻结的话只需要设置freezen_rows 就可以了
 * suppress_row 不加 样式就错乱了
 * zhangzc
 * 2019-10-08
 */
set_time_limit(0);
require_once PLUM_DIR_APP . '/plugin/xlsxwriter/xlsxwriter.class.php';
class App_Plugin_xlsxwriter_XLSXWriterPlugin
{
    const PATH_ROOT = './upload/xlsxexport/';
    private $writer;
    private $filename;
    private $applet_type;
    private $sheet;
    private $merge_order_nums; //需要进行合并的行 [4,5,1,2] 例：从第二行起 ，合并4行，合并5行，合并1行，合并2行
    private $merge_columns; //需要合并的列
    public function __construct($filename = '', $sheet = 'sheet1')
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . "..");
        $this->writer   = new XLSXWriter();
        $this->filename = $filename;
        $this->sheet    = $sheet;
        $this->setBasicInfo($filename);
    }
    /**
     * 设置excel的基本信息
     * @param [type] $filename [description]
     */
    private function setBasicInfo($filename)
    {
        $this->writer->setTitle($filename);
        $this->writer->setSubject('天点科技');
        $this->writer->setAuthor('天点科技');
        $this->writer->setCompany('天点科技');
        $this->writer->setKeywords('天点科技');
        $this->writer->setDescription('天点科技');
        $this->writer->setTempDir(sys_get_temp_dir());
    }

    /**
     * 小程序通用订单导出（非商品合并选项）
     * 首行标题因都是string类型的，需要单独设置一下，否则因为数据类型问题在Excel中会造成不能对列信息进行基本的数据统计
     * @param  [type] $rows             [description]
     * @param  [type] $merge_order_nums [要合并的行数的数组]
     * @param  int    $applet_type      [小程序类型，默认通用，8为多店]
     * @return [type]                   [description]
     */
    public function tradeExport($rows, $merge_order_nums, $applet_type = 0)
    {
        $this->applet_type = $applet_type;
        // 多店类型
        if ($applet_type == 8) {
            $header_first  = array_pad([], 30, 'string');
            $header        = ['string', 'string','string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'price', 'price', 'string', 'string', 'price', 'integer', 'price', 'price', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string'];
            $widths        = [24, 20, 11.5, 11.5, 11.5, 11.5, 11.5, 11.5, 11.5, 44, 11.5, 11.5, 11.5, 11.5, 32, 17, 11.5, 11.5, 11.5, 11.5, 19, 19, 19, 33, 11.5, 11.5, 11.5, 17, 11.5, 19];
            $first_row     = ['订单号', '商家名称', '购买人编号','购买人昵称', '收货人姓名', '手机', '收货人省份', '收货人城市', '收货人地区', '收货地址', '邮编', '快递单号/取货人手机号', '运费', '订单金额', '商品名称', '规格', '单价', '数量', '优惠金额', '促销减免金额', '下单时间', '付款时间', '发货时间', '买家备注', '物流公司/取货人', '自提门店', '订单状态', '购买方式', '配送方式', '完成时间'];
            $merge_columns = [[0, 13], [18, 29]];
        } else if ($applet_type == 12) {
            //教育培训
            $header_first = array_pad([], 15, 'string');

            $header        = ['string', 'string', 'price', 'string', 'price', 'integer', 'price', 'price', 'string', 'string', 'string', 'string', 'string', 'string', 'string'];
            $widths        = [24, 20, 11.5, 32, 11.5, 11.5, 11.5, 11.5, 19, 19, 33, 11.5, 11.5, 11.5, 19];
            $first_row     = ['订单号', '购买人昵称', '订单金额', '商品名称', '单价', '数量', '优惠金额', '促销减免金额', '下单时间', '付款时间', '买家备注', '订单状态', '购买方式', '配送方式', '完成时间'];
            $merge_columns = [];
        } else {
            $header_first = array_pad([], 29, 'string');

            $header        = ['string', 'string','string', 'string', 'string', 'string', 'string', 'string'];
            $widths        = [30, 20,20, 30, 50, 30, 30, 20];
            $first_row     = array('商品名称','类型','预约人名称','预约人电话','备注','开始时间','到期时间','订单状态');
            $merge_columns = [];
        }
        $first_rows[] = $first_row;

        // 设置样式
        for ($r = 0; $r < count($header); $r++) {
            $styles[] = ['valign' => 'center', 'wrap_text' => true];
        }

        // 写入首行
        $this->writer->writeSheetHeader($this->sheet, $header_first, $col_options = ['suppress_row' => true, 'widths' => $widths]);
        $this->writeToRow($first_rows, $styles, true);
        // 添加首行标题
        // array_unshift($rows, $first_row);
        //
        $this->writer->writeSheetHeader($this->sheet, $header, $col_options = ['suppress_row' => true, 'widths' => $widths]);
        // 写入数据单元格
        $this->writeToRow($rows, $styles);
        // 合并单元格
        $this->mergeCells($merge_order_nums, $merge_columns);
        // 保存文件
        $this->writer->writeToFile(self::PATH_ROOT . $this->filename);
        return self::PATH_ROOT . $this->filename;
    }
    /**
     * 订单按照商品合并进行导出
     * @param  [type]  $rows        [description]
     * @param  [type]  $merge_gids  [description]
     * @param  [type]  $merge_gfids [description]
     * @param  integer $applet_type [description]
     * @return [type]               [description]
     */
    public function tradeExportWithGoodsSort($rows, $merge_gids, $merge_gfids, $applet_type = 0)
    {
        $this->applet_type = $applet_type;
        //多店的
        if ($applet_type == 8) {
            $header_first = array_pad([], 32, 'string');
            $header       = ['string', 'string','string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'price', 'price', 'string', 'integer', 'string', 'integer', 'price', 'integer', 'price', 'price', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string'];
            $widths       = [24, 11.5,11.5, 11.5, 11.5, 11.5, 11.5, 11.5, 11.5, 44, 11.5, 11.5, 11.5, 11.5, 32, 11.5, 17, 11.5, 11.5, 11.5, 11.5, 11.5, 19, 19, 19, 33, 11.5, 11.5, 11.5, 17, 11.5, 19];

            $first_row          = ['订单号', '商家名称','购买人编号', '购买人昵称', '收货人姓名', '手机', '收货人省份', '收货人城市', '收货人地区', '收货地址', '邮编', '快递单号/取货人手机号', '运费', '订单金额', '商品名称', '商品数量', '规格', '规格数量', '单价', '数量', '优惠金额', '促销减免金额', '下单时间', '付款时间', '发货时间', '买家备注', '物流公司/取货人', '自提门店', '订单状态', '购买方式', '配送方式', '完成时间'];
            $merge_columns_gid  = [[15, 15]];
            $merge_columns_gfid = [[16, 16]];
        } else {
            $header_first = array_pad([], 31, 'string');
            $header       = ['string','string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'price', 'price', 'string', 'integer', 'string', 'integer', 'price', 'integer', 'price', 'price', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string'];
            $widths       = [24, 11.5, 11.5, 11.5, 11.5, 11.5, 11.5, 11.5, 44, 11.5, 11.5, 11.5, 11.5, 32, 11.5, 17, 11.5, 11.5, 11.5, 11.5, 11.5, 19, 19, 19, 33, 11.5, 11.5, 11.5, 17, 11.5, 19];

            $first_row          = ['订单号', '购买人编号', '购买人昵称', '收货人姓名', '手机', '收货人省份', '收货人城市', '收货人地区', '收货地址', '邮编', '快递单号/取货人手机号', '运费', '订单金额', '商品名称', '商品数量', '规格', '规格数量', '单价', '数量', '优惠金额', '促销减免金额', '下单时间', '付款时间', '发货时间', '买家备注', '物流公司/取货人', '自提门店', '订单状态', '购买方式', '配送方式', '完成时间'];
            $merge_columns_gid  = [[14, 14]];
            $merge_columns_gfid = [[16, 16]];
        }
        $first_rows[] = $first_row;
        // 设置行列格式
        for ($r = 0; $r < count($header); $r++) {
            $styles[] = ['valign' => 'center', 'wrap_text' => true];
        }

        // 写入首行标题
        $this->writer->writeSheetHeader($this->sheet, $header_first, $col_options = ['suppress_row' => true, 'widths' => $widths]);
        $this->writeToRow($first_rows, $styles, true);

        // 写入数据单元格
        $this->writer->writeSheetHeader($this->sheet, $header, $col_options = ['suppress_row' => true, 'widths' => $widths]);

        $this->writeToRow($rows, $styles);
        // 合并单元格-按照商品id合并
        $this->mergeCells($merge_gids, $merge_columns_gid);
        // 合并单元格按照商品规格合并
        $this->mergeCells($merge_gfids, $merge_columns_gfid);
        // 保存文件
        $this->writer->writeToFile(self::PATH_ROOT . $this->filename);
        return self::PATH_ROOT . $this->filename;
    }

    /**
     * 社区团购数据中心团长排行数据导出
     * @param  [type] $rows [description]
     * @return [type]       [description]
     */
    public function sequenceLeaderRankExport($rows)
    {
        $header_first = array_pad([], 6, 'string');
        $header       = ['string', 'string', 'string', 'string', 'price', 'integer'];
        $widths       = [24, 11.5, 11.5, 11.5, 11.5, 11.5];
        $first_row    = ['团长昵称', '团长姓名', '手机号码', '团长分成比例', '团长销售总额', '团长总订单数'];
        $first_rows[] = $first_row;

        // 设置样式
        for ($r = 0; $r < count($header); $r++) {
            $styles[] = ['valign' => 'center', 'wrap_text' => true];
        }

        // 写入首行
        $this->writer->writeSheetHeader($this->sheet, $header_first, $col_options = ['suppress_row' => true, 'widths' => $widths]);
        $this->writeToRow($first_rows, $styles, true);

        $this->writer->writeSheetHeader($this->sheet, $header, $col_options = ['suppress_row' => true, 'widths' => $widths]);
        // 写入数据单元格
        $this->writeToRow($rows, $styles);

        // 保存文件
        $this->writer->writeToFile(self::PATH_ROOT . $this->filename);
        return self::PATH_ROOT . $this->filename;
    }

    /**
     * 社区团购按照商品排序方式进行导出
     * zhangzc
     * 2019-11-14
     * @param  [type] $rows        [description]
     * @param  [type] $merge_gids  [description]
     * @param  [type] $merge_gfids [description]
     * @return [type]              [description]
     */
    public function sequenceTradeExportWithGoodsSort($rows, $merge_gids, $merge_gfids)
    {
        $header_first = array_pad([], 35, 'string');
        $header       = ['string', 'string', 'string', 'integer', 'string', 'price', 'integer', 'price', 'price', 'price', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'price', 'string', 'string', 'string'];
        $widths       = [24, 14, 44, 11.5, 19, 11.5, 11.5, 11.5, 11.5, 11.5, 11.5, 30, 44, 11.5, 12, 11.5, 11.5, 12, 11.5, 12, 11.5, 11.5, 11.5, 44, 33, 13, 19, 19, 19, 12, 11.5, 11.5, 11.5, 12];

        $first_row          = ['订单号', '购买人昵称', '商品名称', '数量', '规格', '单价', '规格数量', '运费', '优惠金额', '订单金额', '订单状态', '所属小区', '小区地址', '团长姓名', '团长电话', '配送方式', '取货人', '取货人手机号', '收货人姓名', '收货人手机', '收货人省份', '收货人城市', '收货人地区', '收货地址', '买家备注', '支付方式', '下单时间', '付款时间', '完成时间', '自提/配送时间', '成本', '供应商名称', '供应商联系人', '供应商电话'];
        $merge_columns_gid  = [[3, 3]];
        $merge_columns_gfid = [[6, 6]];
        $first_rows[]       = $first_row;
        // 设置行列格式
        for ($r = 0; $r < count($header); $r++) {
            $styles[] = ['valign' => 'center', 'wrap_text' => true];
        }

        // 写入首行标题
        $this->writer->writeSheetHeader($this->sheet, $header_first, $col_options = ['suppress_row' => true, 'widths' => $widths]);
        $this->writeToRow($first_rows, $styles, true);

        // 写入数据单元格
        $this->writer->writeSheetHeader($this->sheet, $header, $col_options = ['suppress_row' => true, 'widths' => $widths]);

        $this->writeToRow($rows, $styles);
        // 合并单元格-按照商品id合并
        $this->mergeCells($merge_gids, $merge_columns_gid);
        // 合并单元格按照商品规格合并
        $this->mergeCells($merge_gfids, $merge_columns_gfid);
        // 保存文件
        $this->writer->writeToFile(self::PATH_ROOT . $this->filename);
        return self::PATH_ROOT . $this->filename;
    }

    /**
     * 社区团购订单导出
     * zhangzc
     * 2019-11-13
     * @param  [type] $rows             [description]
     * @param  [type] $merge_order_nums [description]
     * @param  [type] $mergeOrder         [是否合并同订单]
     * @return [type]                   [description]
     */
    public function sequenceTradeExport($rows, $merge_order_nums, $mergeOrder)
    {
        // 需要合并的行
        $this->merge_order_nums = $merge_order_nums;
        $first_row              = ['订单号', '购买人昵称', '商品名称', '规格', '单价', '数量', '运费', '优惠金额', '订单金额', '订单状态', '所属小区', '小区地址', '团长姓名', '团长电话', '配送方式', '取货人', '取货人手机号', '收货人姓名', '收货人手机', '收货人省份', '收货人城市', '收货人地区', '收货地址', '买家备注', '支付方式', '下单时间', '付款时间', '完成时间', '自提/配送时间', '成本', '利润(未除去团长佣金)', '供应商名称', '供应商联系人', '供应商电话'];

        $header_first = array_pad([], 34, 'string');
        $header       = ['string', 'string', 'string', 'string', 'price', 'integer', 'price', 'price', 'price', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'string', 'price', 'price', 'string', 'string', 'string'];
        $widths       = [24, 14, 44, 19, 11.5, 11.5, 11.5, 11.5, 11.5, 11.5, 30, 44, 11.5, 12, 11.5, 11.5, 12, 11.5, 12, 11.5, 11.5, 11.5, 44, 33, 13, 19, 19, 19, 12, 11.5, 17, 11.5, 11.5, 12];
        if ($mergeOrder) {
            $merge_columns = [[0, 1], [6, 28], [30, 30]];
        } else {
            $merge_columns = [[30, 30]];
        }

        $this->merge_columns = $merge_columns;
        $first_rows[]        = $first_row;

        // 设置样式
        for ($r = 0; $r < count($header); $r++) {
            $styles[] = ['valign' => 'center', 'wrap_text' => true];
        }

        // 写入首行
        $this->writer->writeSheetHeader($this->sheet, $header_first, $col_options = ['suppress_row' => true, 'widths' => $widths, 'freeze_rows' => 1]);
        $this->writeToRow($first_rows, $styles, true);

        // 写入数据单元格
        $this->writer->writeSheetHeader($this->sheet, $header, $col_options = ['suppress_row' => true, 'widths' => $widths]);
        $this->writeToRow($rows, $styles);
        // 合并单元格
        $this->mergeCells($merge_order_nums, $merge_columns);
        // 保存文件
        $this->writer->writeToFile(self::PATH_ROOT . $this->filename);

        return self::PATH_ROOT . $this->filename;
    }

    /**
     * 提现
     * 丁宁
     * @param $rows
     * @return string
     */
    public function withdrawExport($rows)
    {
        $first_row    = ['姓名', '手机号', '提现方式', '提现账户', '实际提现方式', '返佣总额', '可提现', '本次提现金额', '手续费', '实际到账金额', '已经提现', '状态', '申请时间', '处理结果'];
        $header_first = array_pad([], 15, 'string');
        $header       = ['string', 'string', 'string', 'string', 'string', 'price', 'price', 'price', 'price', 'price', 'price', 'string', 'string', 'string'];
        $widths       = [15, 15, 15, 25, 15, 15, 15, 15, 15, 15, 15, 15, 20, 25];

        $first_rows[] = $first_row;

        // 设置样式
        for ($r = 0; $r < count($header); $r++) {
            $styles[] = ['valign' => 'center', 'wrap_text' => true];
        }

        // 写入首行
        $this->writer->writeSheetHeader($this->sheet, $header_first, $col_options = ['suppress_row' => true, 'widths' => $widths, 'freeze_rows' => 1]);
        $this->writeToRow($first_rows, $styles, true);
        // 写入数据单元格
        $this->writer->writeSheetHeader($this->sheet, $header, $col_options = ['suppress_row' => true, 'widths' => $widths]);
        $this->writeToRow($rows, $styles);
        // 保存文件
        $this->writer->writeToFile(self::PATH_ROOT . $this->filename);
        return self::PATH_ROOT . $this->filename;
    }

    /**
     * 报名小程序导出已付费数据
     * 刘锦荣
     * @param array $rows
     * @return string
     */
    public function enrollPaidExport($rows)
    {
        $first_rows[] = ['序号', '活动名称', '报名姓名', '报名电话', '报名时间'];
        $header_first = array_pad([], 5, 'string');
        $header       = ['integer', 'string', 'string', 'string', 'string'];
        $widths       = [15, 20, 15, 15, 20];

        // 设置样式
        $styles = [];
        for ($i = 0; $i < count($header); $i++) {
            $styles[] = ['valign' => 'center', 'wrap_text' => true];
        }
        // 写入首行
        $this->writer->writeSheetHeader($this->sheet, $header_first, $col_options = ['suppress_row' => true, 'widths' => $widths, 'freeze_rows' => 1]);
        $this->writeToRow($first_rows, $styles, true);
        // 写入数据单元格
        $this->writer->writeSheetHeader($this->sheet, $header, $col_options = ['suppress_row' => true, 'widths' => $widths]);
        $this->writeToRow($rows, $styles);
        // 保存文件
        $this->writer->writeToFile(self::PATH_ROOT . $this->filename);
        return self::PATH_ROOT . $this->filename;
    }

    /**
     * 社区团购配送路线分拣单-不带小区信息的导出
     * zhangzc
     * 2019-12-20
     * @param  [type] $rows        [数据]
     * @param  [type] $post_mobile [配送人手机号码]
     * @param  [type] $post_id     [配送单号]
     * @param  [type] $post_nums   [配送商品总数量]
     * @return [type]              [description]
     */
    public function exportRouterSortouWithoutComm($rows,$post_mobile,$post_id,$post_nums,$merge_rows)
    {
    	$widths       = [8,35,16,14,8,20,18];

        $styles			= ['halign' => 'center','valign' => 'center','wrap_text' => true,'border'=>'left,right,top,bottom','border-style'=>'thin','height'=>20];
		$style_title	= ['halign' => 'center','valign' => 'center','border'=>'left,right,top,bottom','border-style'=>'thin','height'=>40];
		$style_intro	= ['halign' => 'left','valign' => 'center','border'=>'left,right,top,bottom','border-style'=>'thin','height'=>30];
    	//  写入标题栏
    	$header_title = array_pad([], 7, 'string');
    	$this->writer->writeSheetHeader($this->sheet, $header_title ,['suppress_row' => true, 'widths' => $widths]);
        $this->writer->writeSheetRow($this->sheet, array_pad([], 7, '分拣配货单'),$row_options = $style_title);
        $this->writer->markMergedCell($this->sheet, 0, 0, 0, 6);

        //写入简介信息
        $this->writer->writeSheetHeader($this->sheet, $header_title,['suppress_row' => true, 'widths' => $widths]);
        $r1='配送时间：'.date('Y-m-d H:i:s',time());
        $r2='公司电话：'.$post_mobile;
        $r3='配送单号：'.$post_id;
        $r4='商品总数：'.$post_nums;

        $this->writer->writeSheetRow($this->sheet, [$r1,$r1,$r1,$r2,$r2,$r2,$r2], $style_intro);
        $this->writer->writeSheetRow($this->sheet, [$r3,$r3,$r3,$r4,$r4,$r4,$r4], $style_intro);
        $this->writer->markMergedCell($this->sheet, 1, 0, 1, 2);
        $this->writer->markMergedCell($this->sheet, 1, 3, 1, 6);
        $this->writer->markMergedCell($this->sheet, 2, 0, 2, 2);
        $this->writer->markMergedCell($this->sheet, 2, 3, 2, 6);

    	// 写入表头
		$first_row				= ['序号', '商品名称','商品规格', '商品分类', '商品数量', '路线名称', '备注信息'];
		$header					= array_pad([], 7, 'string');
		$header_style			= $styles;
		$header_style['fill']	= '#D3D3D3';
        $this->writer->writeSheetHeader($this->sheet, $header, ['suppress_row' => true,'widths' => $widths]);
        $this->writer->writeSheetRow($this->sheet,$first_row, $header_style);

        // 写数据
        $this->writer->writeSheetHeader($this->sheet, $header, $col_options = ['suppress_row' => true,'widths' => $widths]);
        // 写入数据单元格
        $this->writeToRow($rows, $styles);
        $this->mergeCells($merge_rows,[[5,5]],4);

        // 签名栏
		$sign_1							='分拣员签字：';
		$sign_2							='日期：';
		$sign_3							='分拣主管签字：';
		// $style_intro['border-style']	='hair';
        $this->writer->writeSheetRow($this->sheet, [$sign_1,$sign_1,$sign_1,$sign_1,$sign_1,$sign_1,$sign_1], $style_intro);
        $this->writer->writeSheetRow($this->sheet, [$sign_2,$sign_2,$sign_2,$sign_2,$sign_2,$sign_2,$sign_2], $style_intro);
        $this->writer->writeSheetRow($this->sheet, [$sign_3,$sign_3,$sign_3,$sign_3,$sign_3,$sign_3,$sign_3], $style_intro);
        $this->writer->writeSheetRow($this->sheet, [$sign_2,$sign_2,$sign_2,$sign_2,$sign_2,$sign_2,$sign_2], $style_intro);
        $count=count($rows)+4;
        $this->writer->markMergedCell($this->sheet,  $count, 0,  $count, 6);
        $this->writer->markMergedCell($this->sheet,  $count+1, 0,  $count+1, 6);
        $this->writer->markMergedCell($this->sheet,  $count+2, 0,  $count+2, 6);
        $this->writer->markMergedCell($this->sheet,  $count+3, 0,  $count+3, 6);


        // 保存文件
        header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($this->filename).'"');
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
        $this->writer->writeToStdOut();
    }

    /**
     * 写入单元格信息
     * zhangzc
     * 2019-11-09
     * @param  [type]  $rows         [description]
     * @param  [type]  $styles       [description]
     * @param  boolean $header       [description]
     * @return [type]                [description]
     */
    private function writeToRow($rows, $styles, $header = false)
    {
        if (!$header) {
            $unremove_column = $this->clearRowsForMerge($rows);
        }

        foreach ($rows as $key => $row) {
            $row = array_values($row);
            // 设置首行的标题底色
            if ($key == 0 && $header) {
                $first_style = [];
                foreach ($styles as $style) {
                    $style['fill']         = '#D3D3D3';
                    $style['border']       = 'left,right,top,bottom';
                    $style['font-style']   = 'bold';
                    $style['border-style'] = 'thin';
                    $first_style[]         = $style;
                }
                $this->writer->writeSheetRow($this->sheet, $row, $first_style);
            } else {
                // 如果有 合并的需求清除要合并的单元格中除第一行外的其他数据（处理行合并）
                if (!in_array($key, $unremove_column)) {
                    foreach ($this->merge_columns as $key => $val) {
                        for ($i = $val[0]; $i <= $val[1]; $i++) {
                            if (is_string($row[$i])) {
                                $row[$i] = '';
                            } else if (is_numeric($row[$i])) {
                                $row[$i] = 0;
                            }
                        }
                    }
                }
                // 设置某一个单元格的特殊样式(处理列样式)
                $row_style = $this->setSingleCellStyle($row, $styles);
                $this->writer->writeSheetRow($this->sheet, $row, $row_style);
            }
        }
    }
    /**
     * 合并单元格
     * @param  [type] $merge_rows [description]
     * @param  array  $mer_column       [需要合并的单元格的区间，左开右开]
    *  @param  int    $start_row        [从第几行开始合并，0行起]
     * @return [type]                   [description]
     */
    private function mergeCells($merge_rows, $merge_column = [],$start_row=1)
    {
        // 从第二行开始计算需要合并的内容 数组里面也就是下标1
        // $start_row = 1;
        foreach ($merge_rows as $merge_val) {
            // 一行的不进行合并操作
            if ($merge_val == 1) {
                $start_row++;
            } else {
                $end_row = ($start_row + ($merge_val - 1));
                // sheet,开始行号，开始列号，结束行号，结束列号
                foreach ($merge_column as $column) {
                    for ($i = $column[0]; $i <= $column[1]; $i++) {
                        $this->writer->markMergedCell($this->sheet, $start_row, $i, $end_row, $i);
                    }
                }
                // 更新下一次要合并的行列坐标
                $start_row = ($end_row + 1);
            }
        }
    }
    /**
     * 因合并单元格执行的是假合并-即合并后在显示的时候没问题，但是在进行求和等数学运算的时候计算出来的值是错误的所以在写入每行的数据的时候如果有相关合并剔除掉除去第一行外其他的要合并的行的数据
     * 计算出每次合并时要保留的首行的坐标
     * zhangzc
     * 2019-11-27
     * @param  [type] $rows [description]
     * @return [type]       [description]
     */
    private function clearRowsForMerge($rows)
    {
        $unremove_column = [];
        // 如果要合并的行数存在
        if ($this->merge_order_nums) {
            $merge_rows = array_values($this->merge_order_nums);

            foreach ($merge_rows as $key => $value) {
                if ($key == 0) {
                    $index = 0;
                } else {
                    // 妈蛋 真蠢写了个这 (留此注释以作警示)
                    // zhangzc
                    // 2019-11-27
                    // $slice = array_slice($merge_rows,0,$key);
                    // $nums  = array_sum($slice);
                    $index = $nums;
                }
                $nums += $value;
                array_push($unremove_column, $index);
            }
        }
        return $unremove_column;
    }

    /**
     * 设置一行中某些特殊的单元格样式
     * @param [type] $row    [一行数据]
     * @param [type] $styles [原有的样式]
     */
    private function setSingleCellStyle(&$row, $styles)
    {
        $index     = 0;
        $row_style = $styles;
        foreach ($row as $k => $val) {
            if (is_array($val)) {
                $row[$k]           = $val['value'];
                $row_style[$index] = array_merge($row_style[$index], $val['style']);
            }
            $index++;
        }
        return $row_style;
    }

    /*    这里是私有函数的区域，有新的导出需求的公开方法 往上面加，谢谢     */

}
