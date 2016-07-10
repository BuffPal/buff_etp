<?php
date_default_timezone_set('Asia/Shanghai');
define("THEME_URI", get_stylesheet_directory_uri());
define("OPTIONS_FRAMEWORK_DIRECTORY", get_template_directory_uri() . "/inc/");
require_once TEMPLATEPATH . "/inc/options-framework.php";
function p($arr){
    echo '<pre>';
    print_r($arr);
    die;
}





//引入设置文件
include_once TEMPLATEPATH.'/include/option_base.php';
new buffpal_cms_option_base();
//引入自定义函数文件(静态) 类被别名为 buffpal
include_once TEMPLATEPATH.'/include/functions.php';
//引入buffpal_list_comments 自定义comment显示函数
include_once TEMPLATEPATH.'/include/buffpal_list_comments.php';

