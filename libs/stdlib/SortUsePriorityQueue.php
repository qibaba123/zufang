<?php

class Libs_Stdlib_SortUsePriorityQueue extends SplPriorityQueue{
    
    private $order;

    public function __construct($order = 'DESC') {
        $this->order = strtoupper($order);
    }

    public function compare($priority1, $priority2) {
        if ($priority1 === $priority2) 
            return 0;
        if ('DESC' == $this->order) {
            return $priority1 < $priority2 ? -1 : 1;
        } else {
            return $priority1 > $priority2 ? -1 : 1;
        }
    }
}