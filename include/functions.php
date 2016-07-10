<?php

/**
 *自定义函数文件
 */
class buffpal_etp_customize_function
{

    /**
     * 获取前台,关于我们的数据
     * @return array
     */
    public static function get_about_data()
    {
        $str = 'abcdefghizlmnopqrstuvwxyz';
        $arr = array();
        $content = buffpal('etp_home_about_content');
        //进行正则提取
        $reg_title = '/\{title@(.*?)}(.*?)\{\/title\}/is';

        preg_match_all($reg_title,$content,$arr_title);

        //遍历替换 里面的关键字
        foreach($arr_title[1] as $k=>$v){
            $arr[] = array(
                'title'=>$v,
                'content'=>self::get_about_content_by_reg($arr_title[2][$k]),
                'target'=>$str[$k]
            );
        }
        return $arr;
    }

    /**
     * 正则替换 {head}追求理念{/head} {br/} {url@http://www.baidu.com}百度查看{/url}
     * @param $content
     * @return string
     */
    public static function get_about_content_by_reg($content)
    {
        //替换 head
        $preg_head = '/\{head\}(.*?)\{\/head\}/is';
        if(preg_match($preg_head,$content)){
           $content =  preg_replace($preg_head,"<h3 class='head'>$1</h3>",$content);
        }

        //替换br
        $preg_head = '/\{br\/\}/is';
        if(preg_match($preg_head,$content)){
            $content =  preg_replace($preg_head,"<br />",$content);
        }

        //替换url
        $preg_head = '/\{url@(.*?)}(.*?)\{\/url\}/is';
        if(preg_match($preg_head,$content)){
            $content =  preg_replace($preg_head,"<a href='$1'>$2</a>",$content);
        }

        return $content;
    }

    /**
     * 获取 音乐分类的数据 通过 后台音乐分类选择的ID通过 _view
     * @return array
     */
    public static function get_home_music_data_new_old()
    {
        $today = date('Y-m-d');
        $arr = array();
        //通过 SQL查找
        $data = self::get_music_by_view();

        //压入数据
        foreach($data as $v){
            $name_author_arr = self::get_name_author($v['post_title']);
            $arr[] = array(
                'name' => $name_author_arr[0],
                'author' => $name_author_arr[1],
                'today' => self::if_today($v['ID'], $today),
                'url' => esc_url(get_post_permalink($v['ID']))
            );
        }
        return $arr;
    }
    

    /**
     * 获取 音乐分类的数据 通过 后台音乐分类选择的ID 通过时间
     * @return array
     */
    public static function get_home_music_data_new()
    {
        $today = date('Y-m-d');
        $arr = array();
        $cat_id = buffpal('etp_music_cat_id');
        $args = array(
            'numberposts' => 13,
            'category' => $cat_id
        );

        //获取数据
        $data = get_posts($args);

        //压入数据
        foreach ($data as $v) {
            $name_author_arr = self::get_name_author($v->post_title);
            $arr[] = array(
                'name' => $name_author_arr[0],
                'author' => $name_author_arr[1],
                'today' => self::if_today($v->ID, $today),
                'url' => esc_url(get_post_permalink($v->ID))
            );
        }
        return $arr;
    }

    /**
     * 获取后台设置的 ID 通过ID 来获取12条用于前台显示的视屏数据
     * @return array
     */
    public static function get_home_video_data()
    {
        $arr = array();
        $today = date('Y-m-d');
        $cat_id = buffpal('etp_video_cat_id');
        if (empty($cat_id)) return false;
        $args = array(
            'numberposts' => 12,
            'category' => $cat_id
        );
        $data = get_posts($args);

        //压入
        foreach ($data as $k => $v) {
            $arr[$k] = array(
                'title' => self::omitString($v->post_title, 20, ''),
                'url' => esc_url(get_post_permalink($v->ID)),
                'thumb' => esc_url(self::get_the_post_thumb_by_id($v->ID, 'videoPoster.png', 'etp_home_video_poster_size')),
                'today' => self::if_today($v->ID, $today)
            );
        }
        return $arr;
    }

    /**
     * 通过ID获取当前ID下的所有文章,返回一个数组,包含所需信息,并且提供默认值
     * @param $cid
     * @return array
     */
    public static function get_article_by_cid($cid)
    {
        $arr = array();
        $today = date('Y-m-d');
        //获取当前 ID 的文章
        $args = array(
            'numberposts' => 5,
            'category' => $cid
        );
        $data = get_posts($args);

        //压入
        foreach ($data as $k => $v) {
            $arr[$k] = array(
                'title' => self::omitString($v->post_title, 10, ''),
                'url' => esc_url(get_permalink($v->ID)),
                'today' => self::if_today($v->ID, $today)
            );

            if ($k == 0) {
                $arr[$k] = array_merge($arr[$k], array('thumb' => self::get_the_post_thumb_by_id($v->ID, 'articlePoster.png', 'etp_home_article_poster_size'), 'excerpt' => self::omitString($v->post_excerpt, 25, '')));
            }
        }
        return $arr;
    }

    /**
     * 判断当前时间是否是今天, $today请在循环时候预先定义,减少开销
     * @param $id
     * @param $today
     * @return bool
     */
    public static function if_today($id, $today)
    {
        $old = date('Y-m-d', get_post_time('U', false, $id));
        if ($old == $today) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取文章的封面图,如果没有将会读取 主题/img/articlePoster.png
     */
    public static function get_the_post_thumb_by_id($id, $str, $size = 'post-thumbnail')
    {
        $url = get_the_post_thumbnail_url($id, $size);
        $str = empty($url) ? THEME_URI . '/img/' . $str : $url;
        return $str;
    }

    /**
     * 获取后台选中的 4 个分类目录的ID 返回的是一个arr
     * @return array
     */
    public static function get_article_list_id()
    {
        $arr = array();
        $result = array();
        $id_arr = buffpal('etp_article_list_id');
        if (count($id_arr) > 0) {
            //删除没有选中的 id 并且压入
            foreach ($id_arr as $k => $v) {
                if (!$v) {
                    unset($id_arr[$k]);
                } else {
                    $arr[] = $k;
                }
            }
        }
        //做下处理只返回前4个
        for ($i = 0; $i < 4; $i++) {
            $result[$i] = $arr[$i];
        }
        return $result;
    }

    /**
     * 获取网站的LOGO图标,如果没有设置将会读取 主题/img/logo.png
     * @return string
     */
    public static function get_etp_logo()
    {
        $url = buffpal('etp_logo');
        $str = empty($url) ? THEME_URI . '/img/logo.png' : $url;
        return esc_url($str);
    }

    /**
     * 获取主页背景图,如果没有将会读取 主题/img/noBackground.jpg
     * @return string
     */
    public static function get_home_backgrond($str)
    {
        $url = buffpal($str);
        $default = THEME_URI . '/img/noBackground.jpg';
        $str = empty($url) ? $default : $url;
        return $str;
    }

    /**
     * 获取轮播器文章的数据,返回一个数组,将会包含所有需要的数据,包括默认值 并且获得 title 和 excerpt
     * 如果没有设置id将会返回 false
     * @return array
     */
    public static function get_filmslide_data()
    {
        $arr = array();
        $cat_id = buffpal('etp_filmslide_cat_id');
        if (empty($cat_id)) return false;

        //获取幻灯片文章数据
        $args = array(
            'numberposts' => 8,
            'category' => $cat_id
        );
        $data = get_posts($args);

        //压入
        foreach ($data as $v) {
            $arr[] = self::get_filmslide_arr($v);
        }
        return $arr;
    }


    /**
     * 获取分类数组,并且格式为 array('ID'=>'name'),并且名字后加上当前文章的统计
     * @return array
     */
    public static function get_category_all()
    {
        $arr = array();
        $category = get_categories();
        foreach ($category as $v) {
            $arr[$v->cat_ID] = $v->cat_name . '　　(' . self::get_category_count($v->cat_ID) . ')';
        }
        return $arr;
    }

    /**
     * 获取缩略图  为了那么一点优化
     * @param $id
     * @param $option
     * @param $path
     * @return mixed
     */
    public static function get_thumb($id, $option, $path)
    {
        if (has_post_thumbnail()):
            //输出缩略图(用上面的缩略图控制,控制大小)
            $news_thumbnail = get_the_post_thumbnail_url($id);
        elseif (empty($news_thumbnail = buffpal($option))):
            $news_thumbnail = get_template_directory_uri() . '/img/' . $path;
        endif;
        return $news_thumbnail;
    }

    /**
     * 用来分割 音乐名与音乐作者
     * @param $str
     * @return array
     */
    public static function get_name_author($str)
    {
        $arr = explode('@', $str);
        $arr[0] = self::trimStrong($arr[0]);
        $arr[1] = self::trimStrong($arr[1]);
        return $arr;
    }

    /**
     * 加强版本的trim 能过滤全角空格
     * @param  [string] $string [需要过滤字符串]
     * @return [string]         [过滤完成字符串]
     */
    public static function trimStrong($string)
    {
        //$string = mb_ereg_replace('^(([ \r\n\t])*(　)*)*', '', $string);  只去掉头部
        //$string = mb_ereg_replace('(([ \r\n\t])*(　)*)*$', '', $string);   只去掉尾部
        //下面俩是全部去除
        $string = mb_ereg_replace('(([ \r\n\t])*(　)*)*', '', $string);
        $string = mb_ereg_replace('(([ \r\n\t])*(　)*)*', '', $string);
        return $string;
    }


    /**
     * 根据文章的评论统计获取文章
     * @param $num 数
     */
    public static function get_posts_by_comemnt($num = 5)
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $slq = 'SELECT `post_title`,`ID` FROM `' . $wpdb->prefix . 'posts` WHERE `comment_status`="open" AND `post_status`="publish" AND `post_type`="post" ORDER BY `comment_count` DESC LIMIT ' . $num;
        $arr = $wpdb->get_results($slq, 'ARRAY_A');
        return $arr;
    }

    /**
     * 获取分类的文章ID并转换为 , 字符串,这里将过滤轮播图分类
     */
    public static function get_category()
    {
        //获取最新文章
        $options_categories = array();
        $options_categories_obj = get_categories();
        foreach ($options_categories_obj as $category) {
            $options_categories[$category->cat_ID] = $category->cat_name;
        }
        unset($options_categories[buffpal('buffpal_filmslide_category_id')]);
        /**
         * 这里就不能直接用 implode转换了,  因为存在布尔值,用implode  booleans依然会输出出来 , 先把里面booleans删除
         */
        $arr = buffpal('buffpal_news_categorys');
        foreach ($arr as $k => $v) {
            if ($v == false) {
                unset($options_categories[$k]);
            }
        }
        $category_id = implode(',', array_keys($options_categories));
        return $category_id;
    }

    /**
     * 正则分割post_content的内容,用于显幻灯片  并且同事获取 title 与 excerpt
     * @param $post_content     指定分类下的文章,格式请产考说明文档
     * @return array            返回可供输出数据
     */
    public static function get_filmslide_arr($obj)
    {
        $result = array();
        $regPic = '/src=\"((?!\").*?)\"\s/is';
        //匹配 第一张背景图片[0] 与 第二张显示图片[1]
        preg_match_all($regPic, $obj->post_content, $arr);

        //匹配 跳转地址 {$url@http://www.baidu.com}
        $regUrl = '/\{\$url@((?!\").*?)\}/is';
        preg_match_all($regUrl, $obj->post_content, $arr1);

        //获取title的颜色
        $regUrl = '/\{\$tcolor@((?!\").*?)\}/is';
        preg_match_all($regUrl, $obj->post_content, $arr2);

        //获取desc的颜色
        $regUrl = '/\{\$dcolor@((?!\").*?)\}/is';
        preg_match_all($regUrl, $obj->post_content, $arr3);

        //压入标题
        $result['title'] = $obj->post_title;

        //压入excerpt
        $result['excerpt'] = $obj->post_excerpt;

        //压入
        @$result['background'] = $arr[1][0] ? $arr[1][0] : TEMPLATEPATH . '/img/1.jpg';
        @$result['showPic'] = $arr[1][1] ? $arr[1][1] : TEMPLATEPATH . '/img/html5.png';
        @$result['location'] = $arr1[1][0] ? $arr1[1][0] : 'http://localhost/';
        @$result['tcolor'] = @$arr2[1][0] ? @$arr2[1][0] : buffpal('etp_theme_icon_color');
        @$result['dcolor'] = @$arr3[1][0] ? @$arr3[1][0] : '#fff';
        return $result;
    }

    /**
     * 统计一个分类下的所有文章的总数  这里建这个方法只是为了加快查询速度
     * @param $id
     * @return int
     */
    public static function get_category_count($id)
    {
        global $wpdb;
        $SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.term_id=$id";
        return $wpdb->get_var($SQL);
    }

    /**
     *  裁剪字符串长度
     * @param  [type] $string [description]
     * @param  [type] $length [description]
     * @return [type]         [description]
     */
    public static function omitString($string, $length, $str = '……')
    {
        if ($string) {
            if (mb_strlen($string, 'utf-8') > $length) {
                $string = mb_substr($string, 0, $length, 'utf-8') . $str;
            }
        }
        return $string;
    }

    /**
     * [将时间戳,转换为 多久前发布 的格式]
     * @param  [string] $time [时间戳]
     * @return [string]       [string]
     */
    public static function format_date($time)
    {
        $t = time() - $time;
        $f = array(
            '31536000' => '年',
            '2592000' => '个月',
            '604800' => '星期',
            '86400' => '天',
            '3600' => '小时',
            '60' => '分钟',
            '1' => '秒'
        );
        foreach ($f as $k => $v) {
            if (0 != $c = floor($t / (int)$k)) {
                return $c . $v . '前';
            }
        }
    }

    public static function get_post_info()
    {
        //获得评论总数
        $comment_count = get_comment_count(get_the_ID())['all'];
        $comment_string = '<li><i class="fa fa-comments"></i> :<span> ' . $comment_count . '</span> 评论</li>';

        //获得浏览次数
        if (!$view_count = get_post_meta(get_the_ID(), '_view', true)) {
            $view_count = 0;
        }
        $view_string = '<li><i class="fa fa-eye"></i> :<span> ' . $view_count . '</span> 浏览</li>';

        //获取时隔多久发布的
        $time = self::format_date(get_the_time('U'));
        $time_string = '<li><i class="fa  fa-clock-o"></i> :<time datetime="' . get_the_time('Y-m-d H:i:s') . '"> ' . $time . '</time></li>';

        //获取作者
        $author = get_the_author_link();
        $author_string = '<li><i class="fa fa-pencil-square-o"></i> : ' . $author . '</li>';

        return $comment_string . $view_string . $time_string . $author_string;
    }


    /**
     * SQL查询,获取数据库内 点击量最高的音乐
     */
    public static function get_music_by_view()
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $music_category = buffpal('etp_music_cat_id');
        $sql = 'SELECT 
                            p.`post_title`,
                            p.`ID`,m.`meta_value` 
                FROM 
                            `' . $prefix . 'posts` as p 
                LEFT JOIN 
                            `' . $prefix . 'term_relationships` as t 
                        ON 
                            t.`object_id` = p.`ID` 
                LEFT JOIN 
                            `' . $prefix . 'postmeta` as m 
                        ON 
                            p.`ID` = m.`post_id` 
                WHERE 
                            t.`term_taxonomy_id` = ' . $music_category . ' 
                AND 
                            p.`post_status` = "publish"
                AND
                            p.`post_type` = "post"
                AND
                            m.`meta_key` = "_view"  
                ORDER BY 
                            (m.`meta_value`+0) DESC 
                LIMIT 
                            13';
        $category = $wpdb->get_results($sql, 'ARRAY_A');
        return $category;
    }


}

class_alias('buffpal_etp_customize_function', 'buff');
