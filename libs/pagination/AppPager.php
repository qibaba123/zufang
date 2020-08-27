<?php
/**
 * APP应用分页管理器
 * @author thomas<thomas@ikinvin.com>
 * @since 2014-05-02
 */
class Libs_Pagination_AppPager {

    public $index = 0;  //查询索引
    public $total = 0;  //数据总数
    public $count = 10; //每页数量
    public $page  = 0;  //当前页码，第一页为0
    public $pages = 0;  //总页数

    /**
     * @param $total
     * @param int $count
     */
    public function __construct($total, $count = 10) {
        $this->total    = intval($total);
        $this->count    = intval($count);

        $this->page     = abs(plum_get_int_param('page', 0));//不小于0的数字
        $this->index    = $this->page * $this->count;
        $this->pages    = ceil($this->total / $this->count);
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

    /*
     * 以数组的形式数组当前分页器数据
     */
    public function output() {
        return array(
            'index'     => $this->index,
            'total'     => $this->total,
            'count'     => $this->count,
            'page'      => $this->page,
            'allPages'  => $this->pages,
            'hasMore'   => $this->total > ($this->page + 1)*$this->count ? true : false
        );
    }
}