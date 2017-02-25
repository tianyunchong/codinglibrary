<?php
/**
 * 分页类
 * User: tyz
 * Date: 2017/2/25
 * Time: 9:18
 */
class sepPage  {
    private $total;
    private $pageUrl;
    private $curPage;
    private $perPage = 20;
    private $allPages;
    private $centerPages = 9;
    private $htmlArr = array();

    /**
     * 初始化参数
     * @param $total
     * @param $pageUrl
     * @param $curPage
     * @param int $perPage
     * @return null
     */
    public function initParams($total, $pageUrl,  $curPage = 1, $perPage = 20) {
        $this->total = $total;
        $this->pageUrl = $pageUrl;
        $this->curPage = $curPage;
        $this->perPage = $perPage;
        $this->initEnvParams();
    }

    /**
     * 初始化生成需要的参数
     * @return null
     */
    private function initEnvParams() {
        //获取下总页数
        $pages = ceil($this->total/$this->perPage);
        if ($pages < 1) {$pages = 1;}
        $this->allPages = $pages;
        if ($this->curPage > $this->allPages) {
            $this->curPage = $this->allPages;
        }
    }

    /**
     * 开始生成分页的html
     * @return string
     */
    public function buildPageHtml() {
        if ($this->allPages < $this->centerPages) {
            return $this->buildMiniatureHtml();
        }
        //开始生成首页，上一页
        $this->buildPreHtml();
        //开始生成中间页面代码
        $this->buildCenterHtml();
        //开始生成结尾的代码
        $this->buildEndHtml();
        return implode("", $this->htmlArr);
    }

    /**
     * 此种情况，是页面数过少，则生成全部，不再生成上一页，首页等
     * @return string
     */
    private function buildMiniatureHtml() {
        $html = "";
        for ($i = 1; $i <= $this->allPages; $i++) {
            if ($i == $this->curPage) {
                $html .= '<li class="page selected"><a href="'.$this->getPageUrl($i).'">'.$this->curPage.'</a></li>';
            } else {
                $html .= '<li class="page"><a href="'.$this->getPageUrl($i).'">'.$i.'</a></li>';
            }
        }
        return $html;
    }

    /**
     * 生成首页和上一页的
     * @return null
     */
    private function buildPreHtml() {
        if ($this->curPage < 2) {
            return;
        }
        $this->htmlArr[] = '<li class="first"><a href="'.$this->getPageUrl(1).'">首页</a></li>';
        $this->htmlArr[] = '<li class="previous"><a href="'.$this->getPageUrl($this->curPage-1).'">上一页</a></li>';
    }

    /**
     * 生成下一页和结尾的代码
     * @return null
     */
    private function buildEndHtml() {
        if ($this->curPage >= $this->allPages) {
            return;
        }
        $this->htmlArr[] = '<li class="next"><a href="'.$this->getPageUrl($this->curPage+1).'">下一页</a></li>';
        $this->htmlArr[] = '<li class="last"><a href="'.$this->getPageUrl($this->allPages).'">末页</a></li>';
    }

    /**
     * 生成下中间页面的代码
     * @return null
     */
    private function buildCenterHtml() {
        $start = $end = 0;
        $pre   = floor($this->centerPages/2);
        if ($this->curPage - $pre >= 1) {
            $start = $this->curPage - $pre;
        } else {
            $start = 1;
        }
        if (($start + $this->centerPages) < $this->allPages) {
            $end = $start + $this->centerPages;
        } else {
            $end = $this->allPages;
        }
        for ($i = $start; $i <= $end; $i++) {
            if ($i == $this->curPage) {
                $this->htmlArr[] .= '<li class="page selected"><a href="'.$this->getPageUrl($i).'">'.$this->curPage.'</a></li>';
            } else {
                $this->htmlArr[] .= '<li class="page"><a href="'.$this->getPageUrl($i).'">'.$i.'</a></li>';
            }
        }
    }

    /**
     * 获取下页面的链接
     * @param $page
     * @return string
     */
    private function getPageUrl($page) {
        $pageUrl = str_replace("#page#", $page, $this->pageUrl);
        return $pageUrl;
    }
}