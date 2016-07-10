<?php get_header('home'); ?>
<?php
    //公用变量声明
    $theme_color = buffpal('etp_theme_icon_color');
?>
<style>
    #dowebok > div:nth-of-type(2) {
        background: url("<?php echo buff::get_home_backgrond('etp_home_article_bg'); ?>");
    }

    #dowebok > div:nth-of-type(3) {
        background: url("<?php echo buff::get_home_backgrond('etp_home_video_bg'); ?>");
    }

    #dowebok > div:nth-of-type(4) {
        background: url("<?php echo buff::get_home_backgrond('etp_home_music_bg'); ?>");
    }

    #dowebok > div:nth-of-type(5) {
        background: url("<?php echo buff::get_home_backgrond('etp_home_about_bg'); ?>");
    }

    #dowebok > div:nth-of-type(6) {
        background: url("<?php echo buff::get_home_backgrond('etp_home_call_bg'); ?>");
    }

    #fp-nav>ul>li>a.active>span{
        background-color: <?php echo $theme_color ?> !important;
    }
    #article_list>div ul>li:nth-of-type(1)>a:hover h4{
        color: <?php echo $theme_color ?>;
    }
    #video .shade>a:hover{
        color: <?php echo $theme_color ?>;
    }
    #action p.lead>span{
        color: <?php echo $theme_color ?>;
        text-shadow: 0 0 1px #333;
    }

</style>
<div id="dowebok">
    <!--首页轮播-->
    <div class="section active">
        <?php
            //获取轮播器文章的数据,返回一个数组,将会包含所有需要的数据,包括默认值 PS:如果没有设置,将会返回false
            $filmslide_data_arr = buff::get_filmslide_data();
        ?>
        <!--声明一个轮播容器 slide幻灯片,滑动 data-ride=carousel开启轮播-->
        <div id="buffCarousel" class="carousel slide fullscreen">
            <!--定义下面的小按钮-->
            <ol class="carousel-indicators hidden-xs">
                <?php
                    for($i = 0;$i<count($filmslide_data_arr);$i++):
                ?>
                <li data-target="#buffCarousel" data-slide-to="<?php echo $i ?>" <?php if($i==0): ?>class="active"<?php endif; ?>></li>
                <?php endfor; ?>
            </ol>
            <!--定义图片容器-->
            <div class="carousel-inner">
                <?php
                    if(count($filmslide_data_arr) > 0):
                        foreach($filmslide_data_arr as $k=>$v):
                ?>
                            <div class="item <?php if($k==1){echo 'active';} ?>" style="background:url('<?php echo $v['background'] ?>');">
                                <figure class="row">
                                    <hgroup class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="pull-right">
                                            <a href="<?php echo esc_url($v['location']) ?>" style="color: <?php echo $v['tcolor'] ?>;"><h1 class="title title_animation"><?php echo $v['title'] ?></h1></a>
                                            <p class="lead desc desc_animation" style="color: <?php echo $v['dcolor'] ?>;"><?php echo $v['excerpt'] ?></p>
                                            <a href="<?php echo esc_url($v['location']) ?>" class="btn btn-primary button btn_animation" role="button">LEARN MORE</a>
                                        </div>
                                    </hgroup>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="pull-left img img_animation hidden-xs">
                                            <img src="<?php echo esc_url($v['showPic']) ?>"
                                                 class="img-responsive img_animation">
                                        </div>
                                    </div>
                                </figure>
                            </div>
                <?php
                        endforeach;
                    endif;
                ?>
            </div>
            <!--定义左右小箭头-->
            <a href="#buffCarousel" data-slide="prev" class="carousel-control left">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a href="#buffCarousel" data-slide="next" class="carousel-control right">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
            <!--向下小按钮动画-->
            <div class="down hidden-xs">
                <span style="border-left:4px solid <?php echo $theme_color ?>;border-bottom:4px solid <?php echo $theme_color ?>;"></span>
                <span style="border-left:4px solid <?php echo $theme_color ?>;border-bottom:4px solid <?php echo $theme_color ?>;"></span>
            </div>
        </div>

    </div>
    <!--文章列表-->
    <div class="section">
        <section class="container-fluid" id="article">
            <h2 class="col-xs-12 text-center">最新<span>文章</span><a href="#" class="btn btn-primary pull-right" role="button" id="article_more">More</a></h2>
            <div class="row" id="article_list">

                <?php
                    //获取后台选中的 4 个分类目录的ID 返回的是一个arr
                    $article_list_id = buff::get_article_list_id();
                    if(count($article_list_id)>0):
                        foreach($article_list_id as $cid):
                             ?>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="well well-sm text-center"><?php echo get_category($cid)->name; ?> <span
                                            class="btn btn-default btn-sm pull-right title_more"><a href="">+</a></span></div>
                                    <ul>
                                        <?php
                                            //通过ID获取当前ID下的所有文章,返回一个数组,包含所需信息,并且提供默认值
                                            $cate_list_data = buff::get_article_by_cid($cid);
                                            foreach($cate_list_data as $k=>$v):
                                        ?>
                                        <?php  if($k==0): ?>
                                        <li>
                                            <a href="<?php echo $v['url'] ?>">
                                                <div class="media">
                                                    <div class="media-left media-top">
                                                        <img src="<?php echo $v['thumb'] ?>" class="media-object" style="height: 100px;width: 100px;"/>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading"><?php echo $v['title'] ?>　　<?php if($v['today']): ?><span class="label label-danger">new</span><?php endif; ?></h4>
                                                        <p class="hidden-xs"><?php echo $v['excerpt'] ?></p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <?php else: ?>
                                        <li><a href="<?php echo $v['url'] ?>"><?php echo $v['title'] ?></a>　　<?php if($v['today']): ?><span class="label label-danger">new</span><?php endif; ?></li>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php
                        endforeach;
                    endif;
                ?>



            </div>
        </section>
    </div>
    <!--视频列表-->
    <div class="section">
        <div id="video" class="container">
            <div class="row">
                <?php
                    //获取 视屏分类的数据
                    $video_data = buff::get_home_video_data();
                    if(count($video_data)>0):
                        foreach($video_data as $v):
                ?>
                            <div class="col-md-3 col-sm-4 col-xs-6 video">
                                <img src="<?php echo $v['thumb'] ?>" class="img-responsive center-block">
                                <?php if($v['today']): ?>
                                    <div class="today">
                                        今日
                                    </div>
                                <?php endif; ?>
                                <div class="shade">
                                    <div><?php echo $v['title']; ?></div>
                                    <a href="<?php echo $v['url'] ?>">
                                        <span class="glyphicon glyphicon-play-circle"></span>
                                    </a>
                                </div>
                            </div>
                <?php
                        endforeach;
                    endif;
                ?>

            </div>
            <button class="btn btn-info pull-center pull-right" id="video_more_btn">MORE</button>
        </div>
    </div>
    <!--音乐列表-->
    <div class="section">
        <div id="music" class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <blockquote>最新排行</blockquote>
                    <ul class="music_list">
                        <?php
                        //获取 音乐分类的数据最新的
                        $music_data = buff::get_home_music_data_new();
                        if(count($music_data)>0):
                            foreach($music_data as $v):
                        ?>
                            <li>
                                <?php if($v['today']): ?><div class="today">今日</div><?php endif; ?>
                                <span><?php echo $v['name'] ?> - <?php echo $v['author'] ?></span><a href="<?php echo $v['url'] ?>"><i class="glyphicon glyphicon-play-circle"></i></a>
                            </li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <blockquote>巅峰榜</blockquote>
                    <ul class="music_list">
                        <?php
                        //获取 音乐分类的数据_view最高的
                        $music_data_old = buff::get_home_music_data_new_old();
                        if(count($music_data_old)>0):
                            foreach($music_data_old as $v):
                        ?>
                                <li>
                                    <?php if($v['today']): ?><div class="today">今日</div><?php endif; ?>
                                    <span><?php echo $v['name'] ?> - <?php echo $v['author'] ?></span><a href="<?php echo $v['url'] ?>"><i class="glyphicon glyphicon-play-circle"></i></a>
                                </li>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </ul>
                </div>




            </div>
            <a href="#" role="button" class="btn btn-default pull-right" id="music_more">MORE</a>
        </div>
    </div>
    <!--关于我们-->
    <div class="section">
        <div class="container" id="about">
            <h2 class="col-xs-12 text-center">关于<span>我们</span></h2>
            <?php
                //获取关于我们的数据
                $about_data = buff::get_about_data();
            ?>
            <ul class="nav nav-tabs nav-pills">
                <?php
                if(count($about_data)>0):
                    foreach($about_data as $k=>$v):
                ?>
                <li <?php if($k==0): ?>class="active"<?php endif; ?>><a href="#<?php echo $v['target']; ?>" data-toggle="tab"><?php echo $v['title']; ?></a><div class="sanjiao"></div></li>
                <?php
                    endforeach;
                endif;
                ?>
            </ul>
            <!--pane窗口 fade淡入 in配合fade一起用-->
            <div class="tab-content">
                <?php
                if(count($about_data)>0):
                    foreach($about_data as $k=>$v):
                ?>
                    <div class="tab-pane fade <?php if($k==0): ?>in active<?php endif; ?>" id="<?php echo $v['target']; ?>"><?php echo $v['content'] ?></div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>
    <!--联系我们-->
    <div class="section">
        <div id="call" class="container">
            <div class="row">
                <h2 class="col-xs-12 text-center">联系<span>我们</span></h2>
                <div class="img col-xs-12">
                    <div class="left pull-left"></div>
                    <img src="<?php echo esc_url(buffpal('etp_icon')); ?>">
                    <div class="right pull-right"></div>
                </div>
                <div class="row" id="action">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <p>　　</p>
                        <p class="lead"><span class="glyphicon glyphicon-home"></span> : <?php echo buffpal('etp_name'); ?></p>
                        <p class="lead"><span class="glyphicon glyphicon-map-marker"></span> : <a href="<?php echo buffpal('etp_location_url'); ?>"><?php echo buffpal('etp_location') ?></a></p>
                        <p class="lead"><span class="glyphicon glyphicon-phone-alt"></span> : <a href="tel:<?php echo buffpal('etp_phone'); ?>"><?php echo buffpal('etp_phone'); ?></a></p>
                        <p class="lead"><span class="glyphicon glyphicon-comment"></span> : <a href="<?php echo buffpal('etp_contact_url'); ?>"><?php echo buffpal('etp_contact'); ?></a></p>
                        <p class="lead"><span class="glyphicon glyphicon-send"></span> : <a href="http://<?php echo buffpal('etp_email'); ?>"><?php echo buffpal('etp_email'); ?></a></p>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div>
                            <p class="desc"><?php echo buffpal('etp_twocode_one'); ?></p>
                            <img src="<?php echo buffpal('etp_twocode_one_pic'); ?>" class="img-responsive">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div>
                            <p class="desc"><?php echo buffpal('etp_twocode_two'); ?></p>
                            <img src="<?php echo buffpal('etp_twocode_two_pic'); ?>" class="img-responsive">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
<script>
    $(function () {
        /*
         * fullpage插件控制
         */
        $('#dowebok').fullpage({
            navigation: true,
            slidesNavigation: true,
            scrollingSpeed: 600,
            css3: true,
            onLeave: function (index, nextindex) {
                if (nextindex == 1) {
                    $('#fp-nav').fadeOut('700');
                    //顺便给导航nav取消样式
                    $('#home_nav').removeClass('nav_bg');
                } else {
                    $ww = $(window).width();//这里用来解决fadeIn在小屏幕时也能显示出来的问题
                    if (!($ww < 768)) {
                        //顺便给导航nav加个背景颜色
                        $('#home_nav').addClass('nav_bg');
                        $('#fp-nav').fadeIn('700');
                    }
                }
            },
            //滚动到指定屏幕后触发
            afterLoad: function (anchorLink, index) {
                switch (index) {
                    case 2:
                        article_animation();
                        break;
                    case 3:
                        video_animation();
                        break;
                    case 4:
                        music_animation();
                        break;
                    case 5:
                        about_animation();
                        break;
                    case 6:
                        footer_animation();
                        break;
                }
            }
        });

        /*
         * 定义,上面switch函索需要用到的函数(用来加载动画);
         */
        function article_animation() {
            $('#article>h2').addClass('title_animation');
            var aArticle_list = $('#article_list>div');
            var i = 0;
            setInterval(function () {
                $('#article_list>div').eq(i).addClass('wrap_animation');
                i++;
                if (i >= aArticle_list.length) {
                    clearInterval(this);
                }
            }, 400);
        }

        function video_animation() {
            var aList = $('#video .video');
            for (var i = 0; i < aList.length; i++) {
                aList.eq(i).css('animation', '.7s _video_animation forwards ease-in-out ' + (i * 100) + 'ms');
            }
            $('#video_more_btn').css('animation', '.7s _video_more_btn forwards ease-in-out .5s');
        }

        function music_animation() {
            var aUl = $('#music ul');
            for(var f = 0;f<aUl.length;f++){
                for(var i = 0;i<13;i++){
                    aUl.eq(f).find('li').eq(i).css('animation','2s rotateM forwards ease-in-out '+(i*50+f*500)+'ms');
                }
            }
            //给bq加动画
            var aBq = $('#music blockquote');
            for(var b = 0;b<aBq.length;b++){
                aBq.eq(b).css('animation', '1s music_bq_animation forwards ease-in-out ' + (b* 400) + 'ms');
            }
            //给music more添加动画
            $('#music_more').css('animation','.8s _music_more forwards ease-in-out 2s');
        }

        function about_animation(){
            $('#about h2').css('animation','.8s _about_title forwards ease-in-out .3s');
            $('#about .nav-tabs>li').css('animation','.8s _about_nav_li forwards ease-in-out .2s');
            $('#about .tab-content').css('animation','.8s _about_tab_content forwards ease-in-out .2s');
        }

        function footer_animation() {
            var aList = $('#action>div');
            for(var i = 0;i<aList.length;i++){
                aList.eq(i).css('animation','1s _call_animation forwards ease-in-out '+i*200+'ms');
            }
            $('#call h2').css('animation','.8s _about_title forwards ease-in-out .3s');
            $('#call div.img').css('animation','.8s _about_tab_content forwards ease-in-out .2s');
        }


        /*
         * 这里不改动源码,重写项目导航的样式
         * glyphicon glyphicon-home
         * glyphicon glyphicon-pencil
         * glyphicon glyphicon-film
         * glyphicon glyphicon-music
         * glyphicon glyphicon-user
         * glyphicon glyphicon-earphone
         */
        var aIcon = ['glyphicon glyphicon-home', 'glyphicon glyphicon-pencil', 'glyphicon glyphicon-film', 'glyphicon glyphicon-music', 'glyphicon glyphicon-user', 'glyphicon glyphicon-earphone'];
        //这里有个BUG需要这行代码,在生产导航之后运行,所以把他放在 fullpage 之后
        var aItemNav = $('#fp-nav li');
        for (var i = 0; i < aIcon.length; i++) {
            aItemNav.eq(i).find('span').addClass(aIcon[i]);
        }


        /*
         * 轮播器控制
         */
        $('#buffCarousel').carousel({
            'interval': <?php echo buffpal('etp_filmslide_velocity'); ?>     //轮播时间设置
        });


        /*
         * 点击第一个区域的向下小按钮触发滚动
         */
        $('#buffCarousel div.down').on('click', function () {
            $('#dowebok').fullpage.moveSectionDown();
        });

        /**
         * 根据浏览器宽度,来让手机端,用滚动条滚动
         */
        $(window).resize(function () {
            autoScrolling();
        });

        function autoScrolling() {
            var $ww = $(window).width();
            if ($ww < 768) {
                $.fn.fullpage.setAutoScrolling(false);
            } else {
                $.fn.fullpage.setAutoScrolling(true);
            }
        }

        autoScrolling();


    });
</script>
