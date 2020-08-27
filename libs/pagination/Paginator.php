<?php
/**
 * @author thomas<thomas@ikinvin.com>
 * @since 2014-05-02
 */
class Libs_Pagination_Paginator {
    const COMMON_CSS_PATH   = '/public/common/css';
    const COMMON_JS_PATH    = '/public/common/js';

    public $index = 0;  //查询索引
    public $total = 0;  //数据总数
    public $count = 10; //每页数量
    public $page  = 0;  //当前页码，第一页为0
    public $pages = 0;  //总页数

    private $pre_type_ = array('jquery', 'bootstrap');
    private $html_;

    private $base_url_      = '/';
    private $base_param_    = array();

    /**
     * @param $total
     * @param int $count
     * @param string $type | array('jquery', 'bootstrap')
     */
    public function __construct($total, $count = 10, $type = 'jquery', $hasJq = false) {
        $this->_parse_request_uri();//解析URL
        $this->total    = intval($total);
        $this->count    = intval($count);

        $this->page     = abs(plum_get_int_param('page', 0));//不小于0的数字
        $this->index    = $this->page * $this->count;
        $this->pages    = ceil($this->total / $this->count);

        $type = in_array($type, $this->pre_type_) ? $type : current($this->pre_type_);
        if ($type == 'jquery') {
            $this->setupPagerHTML($hasJq);
        } else if ($type == 'bootstrap') {
            $this->bootstrapACE();
        }
    }

    /*
     * 判断是否还有数据
     */
    public function hasMore() {
        return $this->total > ($this->page + 1)*$this->count ? true : false;
    }

    /*
     * 是否还有下一页数据
     */
    public function hasNext() {
        return $this->page < $this->pages ? true : false;
    }

    private function setupPagerHTML($hasJq) {
        if (!$this->total) {
            $html = array('<div></div>');
        } else {
            $html = array();
            if($hasJq == false){ //未引入jquery
                $html[] = '<script type="text/javascript" src="'.self::COMMON_JS_PATH.'/jquery-1.11.1.min.js"></script>';
            }
            $html[] = '<link rel="stylesheet" type="text/css" href="'.self::COMMON_CSS_PATH.'/pagination.css" />';
            $html[] = '<script type="text/javascript" src="'.self::COMMON_JS_PATH.'/jquery.pagination.js"></script>';
            $html[] = '<script type="text/javascript" src="'.self::COMMON_JS_PATH.'/pager.js"></script>';
            $html[] = '<div id="pager-tpl" class="pagination" style="display: none;"><!-- 这里显示分页 --></div>';
            $html[] = '<div class="pager-setting" style="display: none;">';
            $html[] = '<input type="hidden" id="pager-count-num" value="'.$this->count.'"/>';
            $html[] = '<input type="hidden" id="pager-total-num" value="'.$this->total.'"/>';
            $html[] = '</div>';
        }
        $this->html_ = implode('', $html);
    }

    public function render() {
        return $this->html_;
    }

    public function bootstrapACE(){
        //上一页关系处理
        if ($this->page == 0) {
            $pre = ' disabled ';
            $prePage = 0;
        } else {
            $pre  = '';
            $prePage = $this->page - 1;
        }
        //下一页关系处理
        if ($this->page == $this->pages - 1) {
            $next = ' disabled ';
            $nextPage = $this->pages - 1;
        } else {
            $next = '';
            $nextPage = $this->page + 1;
        }

        $html = array(
            '<ul class="pagination pull-right no-margin">',
            '<li class="prev'.$pre.'">',
            '<a href="'.$this->_render_url_with_page($prePage).'"><i class="icon-double-angle-left"></i></a></li>',
        );
        for($i = 0; $i < $this->pages; $i++){
            $active = '';
            if($i == $this->page){
                $active = ' class="active" ';
            }
            $html[] = '<li'.$active.'><a href="'.$this->_render_url_with_page($i).'">'.($i+1).'</a></li>';
        }
        $html[] = '<li class="next'.$next.'">';
        $html[] = '<a href="'.$this->_render_url_with_page($nextPage).'"><i class="icon-double-angle-right"></i></li>';
        $html[] = '</ul>';

        $this->html_ = implode('', $html);
    }

    /*
     * 解析获取URL
     */
    private function _parse_request_uri() {
        $request_uri = plum_get_server('REQUEST_URI', '/');
        $tmp = explode('?', $request_uri);
        $this->base_url_ = array_shift($tmp);

        $param = array();
        foreach ($tmp as $val) {
            $ttmp = explode('&', $val);
            foreach ($ttmp as $tval) {
                $tttmp = explode('=', $tval);
                $param[$tttmp[0]] = $tttmp[1];
            }
        }
        $this->base_param_ = $param;
    }
    /*
     * 生成对应URL
     */
    private function _render_url_with_page($page = 0) {
        $param = $this->base_param_;
        unset($param['page']);

        $param['page'] = $page;

        return $this->base_url_ . '?' . http_build_query($param);
    }
}