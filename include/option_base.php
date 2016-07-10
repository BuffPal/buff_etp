<?php
class buffpal_cms_option_base {

    public function __construct()
    {
        //取消wordpress默认的顶部导航条
        show_admin_bar(false);
        //加载样式文件
        add_action( 'wp_enqueue_scripts', array($this,'photos_scripts'));
        //给文章设置缩略图
        add_theme_support( 'post-thumbnails' );
        //主页视屏缩略图设置 290x176
        add_image_size('etp_home_video_poster_size', 290,176,true);
        //主页文章缩略图设置 100X100
        add_image_size('etp_home_article_poster_size', 100,100,true);

        //加载菜单
        register_sidebar(
            array(
                'id' => 'sidebar-1',
                'name' => '侧边栏',//工具名称
                'before_widget' => '<div class=“sbox”>',//以这个为包裹的开头
                'after_widget' => '</div>',//以这个为包裹的闭合
                'before_title' => '<h2>',//包裹内标题以这个为开头
                'after_title' => '</h2>'//同上以这个为结尾
            )
        );


    }



    public function photos_scripts() {
        //禁止加载默认jq库
        wp_deregister_script('jquery');
        //Bootstrap样式表
        wp_enqueue_style( 'bootstrap_css', THEME_URI . '/css/bootstrap.min.css');
        //引入全屏滚动 jquery.fullPage.css 样式文件.
        if(is_home()) wp_enqueue_style('fullpage_css',THEME_URI . '/css/jquery.fullPage.css');
        //引入主页index.php  主要样式文件
        if(is_home()) wp_enqueue_style('home_css',THEME_URI.'/css/home.css');



        //引入JS文件 第五个参数为true放在尾部
        wp_enqueue_script( 'jquery', THEME_URI . '/js/jQuery.js', array(),'',true);
        wp_enqueue_script( 'bootstrap', THEME_URI . '/js/bootstrap.min.js', array( 'jquery' ),'',true);
        //引入全屏滚动 jquery.fullPage.js文件.
        if(is_home()) wp_enqueue_script( 'fullpage_js', THEME_URI . '/js/jquery.fullPage.min.js', array( 'jquery' ),'',true);




    }

}