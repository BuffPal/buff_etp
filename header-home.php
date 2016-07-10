<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link id="favicon" href="<?php echo buffpal('etp_icon') ?>" rel="icon" type="image/x-icon" />
    <title><?php echo buffpal('buffpal_web_name') ?> | <?php echo buffpal('buffpal_web_description') ?></title>
    <?php wp_head();
        //公用变量声明
        $theme_color = buffpal('etp_theme_icon_color');
    ?>
    <style>
        a,input,button{
            outline:none !important;
        }
        a{
            text-decoration: none !important;
        }
        li.current-menu-item{
            border-bottom: 3px solid <?php echo $theme_color ?> !important;
        }
        #menu-html>li:hover{
            border-bottom: 3px solid <?php echo $theme_color ?>;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top" id="home_nav">
    <div class="container">
        <div class="navbar-header">
            <a href="#" class="navbar-brand">
                <img src="<?php echo buff::get_etp_logo(); ?>" id="logo_img">
            </a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <?php wp_nav_menu(
            array(
                'container' => 'div',//最外层包裹
                'container_class' => 'collapse navbar-collapse',//最外层包裹的calss名
                'container_id' => 'navbar-collapse',//最外层包裹的id名
                'menu_class'=>'nav navbar-nav navbar-right',//ul包裹的class名
                'depth' => 1,//只显示一级菜单
            )
        ) ?>
    </div>
</nav>

