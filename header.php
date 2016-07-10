<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php echo buffpal('buffpal_web_name') ?> | <?php echo buffpal('buffpal_web_description') ?></title>
    <?php wp_head() ?>
</head>
<body>
    <?php wp_nav_menu(
    //;
        array(
            'menu_id' => 'buffpal_nav',
            'after' => '<div class="border"></div>'
        )
    ) ?>

