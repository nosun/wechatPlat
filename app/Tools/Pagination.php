<?php

namespace Share\Tools;

use Symfony\Component\Finder\Tests\Iterator\Iterator;

class Pagination{
    private $path = '/';
    private $step = 3;
    private $list;
    private $pageNum;
    private $page = 1;

    public function __construct($list, $pageNum, $page)
    {
        $this->pageNum = $pageNum;
        $this->list = $list;
        $this->page =  max(min($page, $pageNum), 1);
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function setStep($step){
        $this->step = $step;
    }

    public function getPageContent(){
        return isset($this->list[$this->page]) ? $this->list[$this->page] : null;
    }

    public function getItems(){
        return $this->list;
    }


    public function render(){
        if($this->pageNum <= 1){
            return null;
        }
        $pagination = '<div class="pagination-box">';
        $pagination .= '<ul class="pagination">';
        if($this->page != 1){
            //prev page
            $prePage = max(1, $this->page-1);
            $prevUrl =  str_replace('{page}', $prePage, $this->path);
            $pagination .= '<li class="prev" ><a class="icon-sprites" href="' . $prevUrl . '" ></a ></li >';
        }

        //first page
        if($this->page > 1){
            $pageUrl = str_replace('{page}', 1, $this->path);
            $pagination .= ' <li><a href="'.$pageUrl.'" >1</a ></li >';
        }

        //前省略号
        if($this->page-$this->step>  2){
            $pagination .= '<li ><span>...</span></li>';
        }

        //before page
        for($i = max($this->page - $this->step, 2); $i<$this->page; $i++){
            $pageUrl = str_replace('{page}', $i, $this->path);
            $pagination .= ' <li><a href="'.$pageUrl.'" >'.$i.'</a ></li >';
        }

        //active page
        $pageUrl = str_replace('{page}', $this->page, $this->path);
        $pagination .= '<li class="active" ><a href="'.$pageUrl.'" >'.$this->page.'</a ></li >';

        //after page
        $end = min($this->pageNum-1, $this->page + $this->step);
        for($i=$this->page+1; $i<=$end; $i++){
            $pageUrl = str_replace('{page}', $i, $this->path);
            $pagination .= ' <li><a href="'.$pageUrl.'" >'.$i.'</a ></li >';
        }

        //后省略号
        if( $this->page+$this->step < $this->pageNum-1 ){
            $pagination .= '<li ><span>...</span></li >';
        }

        //end page
        if( $this->page < $this->pageNum ){
            $pageUrl =  str_replace('{page}', $this->pageNum, $this->path);
            $pagination .= ' <li><a href="'.$pageUrl.'" >'.$this->pageNum.'</a ></li >';
        }

        if($this->page != $this->pageNum){
            //next page
            $nextPage = min($this->page+1, $this->pageNum);
            $nextUrl = str_replace('{page}', $nextPage, $this->path);
            $pagination .= '<li class="next" ><a class="icon-sprites" href="' . $nextUrl . '" ></a ></li >';
        }

        $pagination .= '</ul>';
        $pagination .= '</div>';
        return $pagination;
    }
}