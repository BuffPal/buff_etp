<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name()
{
    $optionsframework_settings = get_option('optionsframework');
    $optionsframework_settings['id'] = 'options_theme_customizer';
    update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'theme-textdomain'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options()
{

    $options = array();

    //=======================================================================网站配置
    $options[] = array(
        'name' => '网页配置',
        'type' => 'heading'
    );

    $options[] = array(
        'name' =>'主题颜色',
        'desc' => '将会改变当前主题的小图标颜色',
        'id' => 'etp_theme_icon_color',
        'std' => '#00A2FF',
        'type' => 'color'
    );

    $options[] = array(
        'name' => '网站LOGO',
        'desc' => '网站LOGO,标准为 200px X 50px',
        'id' => 'etp_logo',
        'type' => 'upload'
    );

    $options[] = array(
        'name' => '网站icon',
        'desc' => '网站icon,将在浏览窗口的title显示icon,请上传16x16或32x32',
        'id' => 'etp_icon',
        'type' => 'upload'
    );

    //=======================================================================主页背景图

    $options[] = array(
        'name' => '主页背景图设置',
        'type' => 'heading'
    );


    $options[] = array(
        'name' => '文章区域背景图',
        'desc' => '图片大小自定义,加上模糊效果更好',
        'id' => 'etp_home_article_bg',
        'type' => 'upload'
    );

    $options[] = array(
        'name' => '视频区域背景图',
        'desc' => '图片大小自定义,加上模糊效果更好',
        'id' => 'etp_home_video_bg',
        'type' => 'upload'
    );

    $options[] = array(
        'name' => '音乐区域背景图',
        'desc' => '图片大小自定义,加上模糊效果更好',
        'id' => 'etp_home_music_bg',
        'type' => 'upload'
    );

    $options[] = array(
        'name' => '关于我们区域背景图',
        'desc' => '图片大小自定义,加上模糊效果更好',
        'id' => 'etp_home_about_bg',
        'type' => 'upload'
    );

    $options[] = array(
        'name' => '联系我们区域背景图',
        'desc' => '图片大小自定义,加上模糊效果更好',
        'id' => 'etp_home_call_bg',
        'type' => 'upload'
    );

    //=======================================================================幻灯片

    $options[] = array(
        'name' => '幻灯片',
        'type' => 'heading'
    );


    //获取全部的分类,并且格式为 array('ID'=>'name+统计');
    $category_all = buff::get_category_all();

    if ( $category_all ) {
        $options[] = array(
            'name' => '幻灯片分类选着',
            'desc' => '请根据文档提示选着幻灯片',
            'id' => 'etp_filmslide_cat_id',
            'type' => 'select',
            'options' => $category_all
        );
    }

    $options[] = array(
        'name' => '幻灯片切换时间',
        'desc' => '将控制幻灯片切换速度,默认为8秒(单位为/ms)',
        'id' => 'etp_filmslide_velocity',
        'std' => '8000',
        'class' => 'mini',
        'type' => 'text'
    );

    //=======================================================================主页文章显示配置

    $options[] = array(
        'name' => '主页文章显示配置',
        'type' => 'heading'
    );

    //过滤上面选着的分类
    $news_checkbox_arr = $category_all;
    unset($news_checkbox_arr[buffpal('etp_filmslide_cat_id')]);

    $options[] = array(
        'name' => '主页文章显示分类选着',
        'desc' => '文章分类选着,最大只能选着4个,超过将无法正确显示',
        'id' => 'etp_article_list_id',
        'type' => 'multicheck',
        'options' => $news_checkbox_arr
    );

    //=======================================================================主页视屏显示配置

    $options[] = array(
        'name' => '视屏配置',
        'type' => 'heading'
    );

    if ( $news_checkbox_arr ) {
        $options[] = array(
            'name' => '视屏分类选着',
            'desc' => '用来显示视屏的分类目录',
            'id' => 'etp_video_cat_id',
            'type' => 'select',
            'options' => $news_checkbox_arr
        );
    }

    //=======================================================================主页音乐显示配置

    $options[] = array(
        'name' => '音乐配置',
        'type' => 'heading'
    );

    if ( $news_checkbox_arr ) {
        $options[] = array(
            'name' => '音乐分类选着',
            'desc' => '用来显示音乐的分类目录',
            'id' => 'etp_music_cat_id',
            'type' => 'select',
            'options' => $news_checkbox_arr
        );
    }

    //=======================================================================主页关于我们显示配置
    $options[] = array(
        'name' => '关于我们配置',
        'type' => 'heading'
    );

    $wp_editor_settings = array(
        'wpautop' => true, // Default
        'textarea_rows' => 40,
        'tinymce' => array( 'plugins' => 'wordpress,wplink' )
    );

    $options[] = array(
        'name' => '关于我们区域编辑',
        'desc' => '以{title@区块名}来定义一个区块以{/title}来结束,(PS:前台只能显示4个) 在内容块内可以用 {head}来定义一个h3标签{/head} 用{br/}来定义一个换行符号,用{url@要跳转的地址}内容{/url} 定义一个A标签',
        'id' => 'etp_home_about_content',
        'type' => 'editor',
        'settings' => $wp_editor_settings
    );

    //=======================================================================主页联系我们显示配置
    $options[] = array(
        'name' => '联系我们配置',
        'type' => 'heading'
    );

    $options[] = array(
        'name' =>'公司名',
        'desc' => '用来显示第一个栏位',
        'id' => 'etp_name',
        'std' => '又一个wordpress站点',
        'type' => 'text'
    );

    $options[] = array(
        'name' =>'公司地址',
        'desc' => '用来显示第二个栏位',
        'id' => 'etp_location',
        'type' => 'text'
    );
    $options[] = array(
        'desc' => '公司地址跳转地址(可以用google地图或百度地图)',
        'id' => 'etp_location_url',
        'type' => 'text'
    );

    $options[] = array(
        'name' =>'电话',
        'desc' => '用来显示第三个栏位',
        'id' => 'etp_phone',
        'type' => 'text'
    );

    $options[] = array(
        'name' =>'联系软件',
        'desc' => '用来显示第四个栏位,QQ微信之类的都行',
        'id' => 'etp_contact',
        'type' => 'text'
    );
    $options[] = array(
        'desc' => '用来与上面的跳转地址',
        'id' => 'etp_contact_url',
        'type' => 'text'
    );

    $options[] = array(
        'name' =>'邮箱地址',
        'desc' => '用来显示第四个栏位(不用加 http://)',
        'id' => 'etp_email',
        'type' => 'text'
    );

    $options[] = array(
        'name' =>'二维码第一个栏位',
        'desc' => '用来描述第一个二维码栏位',
        'id' => 'etp_twocode_one',
        'type' => 'text'
    );
    $options[] = array(
        'desc' => '二维码图片上传(请按 250x250的标准上传,如果超出后台将会进行裁剪)',
        'id' => 'etp_twocode_one_pic',
        'type' => 'upload'
    );

    $options[] = array(
        'name' =>'二维码第二个栏位',
        'desc' => '用来描述第二个二维码栏位',
        'id' => 'etp_twocode_two',
        'type' => 'text'
    );
    $options[] = array(
        'desc' => '二维码图片上传(请按 250x250的标准上传,如果超出后台将会进行裁剪)',
        'id' => 'etp_twocode_two_pic',
        'type' => 'upload'
    );

    return $options;
}