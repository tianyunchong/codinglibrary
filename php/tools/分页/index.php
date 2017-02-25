<?php
/**
 * test
 * User: tyz
 * Date: 2017/2/25
 * Time: 9:14
 */
header("Content-type:text/html;charset=utf-8");
include "sepPage.php";
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
$pageObj = new sepPage();
$pageObj->initParams(1000, "/test/index.php?page=#page#", $page, 20);
echo $pageObj->buildPageHtml();