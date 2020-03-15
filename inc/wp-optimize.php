<?php
/**
 * 针对 WordPress 的优化
 * by mkblog.cn
 */

// 禁用顶部管理工具条
show_admin_bar(false);


// 移除头部冗余代码
remove_action( 'wp_head', 'wp_generator' );     // WP版本信息
remove_action( 'wp_head', 'rsd_link' );         // 离线编辑器接口
remove_action( 'wp_head', 'wlwmanifest_link' ); // 同上
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );   // 上下文章的url
remove_action( 'wp_head', 'feed_links', 2 );        // 文章和评论feed
remove_action( 'wp_head', 'feed_links_extra', 3 );  // 去除评论feed
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );           // 短链接
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );          // 移除 wp-json
remove_action( 'template_redirect', 'rest_output_link_header', 11 ); // 移除 HTTP header 中的 link
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );       // 解决4.2版本部分主题大量404请求问题
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' ); // 解决后台404请求
remove_action( 'wp_print_styles', 'print_emoji_styles' );       // 移除4.2版本前台表情样式钩子
remove_action( 'admin_print_styles', 'print_emoji_styles' );    // 移除4.2版本后台表情样式钩子
remove_action( 'the_content_feed', 'wp_staticize_emoji' );      // 移除4.2 emoji相关钩子
remove_action( 'comment_text_rss', 'wp_staticize_emoji' );      // 移除4.2 emoji相关钩子
remove_action( 'init', 'smilies_init', 5 );            // 去除 Emoji 短代码转换

remove_filter( 'the_content', 'wptexturize' );          // 禁止正文代码标点转换
remove_filter( 'comment_text', 'wptexturize' );         // 禁止评论代码标点转换
remove_filter( 'comment_text', 'make_clickable',  9 );  // 去除wordpress评论网址自动转链接

add_filter( 'xmlrpc_enabled', '__return_false' );       // 关闭XML-RPC的pingback端口
add_filter( 'use_default_gallery_style', '__return_false' );        // 去除wordpress自带相册样式
add_filter( 'pre_option_link_manager_enabled', '__return_true' );   // 启用链接功能（友链）

add_theme_support( 'custom-background' );    // 添加自定义背景功能


// 禁止加载默认jq库
function mk_enqueue_scripts() {
    wp_deregister_script('jquery');
}
add_action( 'wp_enqueue_scripts', 'mk_enqueue_scripts', 1 );


// 禁止后台加载谷歌字体
function mk_remove_open_sans_from_wp_core() {
	wp_deregister_style( 'open-sans' );
	wp_register_style( 'open-sans', false );
	wp_enqueue_style('open-sans', '' );
}
add_action( 'init', 'mk_remove_open_sans_from_wp_core' );


// 禁止 WordPress 头部加载 s.w.org 的 dns-prefetch
function mk_remove_dns_prefetch( $hints, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
        return array_diff( wp_dependencies_unique_hosts(), $hints );
    }
    return $hints;
}
add_filter( 'wp_resource_hints', 'mk_remove_dns_prefetch', 10, 2 );


// 禁用oembed  https://wordpress.org/plugins/disable-embeds/
if ( !function_exists( 'disable_embeds_init' ) ) :
    function disable_embeds_init() {
        /* @var WP $wp */
        global $wp;
        
        // Remove the embed query var.
        $wp->public_query_vars = array_diff( $wp->public_query_vars, array(
            'embed',
        ) );
        
        // Remove the REST API endpoint.
        remove_action( 'rest_api_init', 'wp_oembed_register_route' );
        
        // Turn off oEmbed auto discovery.
        add_filter( 'embed_oembed_discover', '__return_false' );
        
        // Don't filter oEmbed results.
        remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
        
        // Remove oEmbed discovery links.
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
        
        // Remove oEmbed-specific JavaScript from the front-end and back-end.
        remove_action( 'wp_head', 'wp_oembed_add_host_js' );
        add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
        
        // Remove all embeds rewrite rules.
        add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
        
        // Remove filter of the oEmbed result before any HTTP requests are made.
        remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
    }
    
    add_action( 'init', 'disable_embeds_init', 9999 );
    
    /**
    * Removes the 'wpembed' TinyMCE plugin.
    *
    * @since 1.0.0
    *
    * @param array $plugins List of TinyMCE plugins.
    * @return array The modified list.
    */
    function disable_embeds_tiny_mce_plugin( $plugins ) {
        return array_diff( $plugins, array( 'wpembed' ) );
    }
    
    /**
    * Remove all rewrite rules related to embeds.
    *
    * @since 1.2.0
    *
    * @param array $rules WordPress rewrite rules.
    * @return array Rewrite rules without embeds rules.
    */
    function disable_embeds_rewrites( $rules ) {
        foreach ( $rules as $rule => $rewrite ) {
            if ( false !== strpos( $rewrite, 'embed=true' ) ) {
                unset( $rules[ $rule ] );
            }
        }
        
        return $rules;
    }
    
    /**
    * Remove embeds rewrite rules on plugin activation.
    *
    * @since 1.2.0
    */
    function disable_embeds_remove_rewrite_rules() {
        add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
        flush_rewrite_rules();
    }
    
    register_activation_hook( __FILE__, 'disable_embeds_remove_rewrite_rules' );
    
    /**
    * Flush rewrite rules on plugin deactivation.
    *
    * @since 1.2.0
    */
    function disable_embeds_flush_rewrite_rules() {
        remove_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
        flush_rewrite_rules();
    }
    
    register_deactivation_hook( __FILE__, 'disable_embeds_flush_rewrite_rules' );
endif;


// 完全禁用 rest API  https://www.ilxtx.com/disable-json-rest-api-in-wordpress.html
/**
if ( version_compare( get_bloginfo( 'version' ), '4.7', '>=' ) ) {
    function mk_disable_rest_api( $access ) {
        return new WP_Error( 'rest_api_cannot_acess', '该功能已被禁用', array( 'status' => 403 ) );
    }
    add_filter( 'rest_authentication_errors', 'mk_disable_rest_api' );
} else {
    // Filters for WP-API version 1.x
    add_filter( 'json_enabled', '__return_false' );
    add_filter( 'json_jsonp_enabled', '__return_false' );
    // Filters for WP-API version 2.x
    add_filter( 'rest_enabled', '__return_false' );
    add_filter( 'rest_jsonp_enabled', '__return_false' );
}
**/


// 手气不错随机文章功能
function mk_random_postlite() {
    $loop = new WP_Query( array( 'post_type' => array(post), 'orderby' => 'rand', 'posts_per_page' => 1 ) );
    while ( $loop->have_posts() ) : $loop->the_post();
        wp_redirect( get_permalink() );
    endwhile;
}
if(isset($_GET['random']))
add_action( 'template_redirect', 'mk_random_postlite' );


// 文章分页新增上一页、下一页 参考 https://www.mobantu.com/7051.html
function mk_link_pages_args_prevnext_add($args) {
    global $page, $numpages, $more, $pagenow;
    
    if (!$args['next_or_number'] == 'next_and_number') return $args; // 没用到，直接退出
    
    $args['next_or_number'] = 'number'; # keep numbering for the main part
    if (!$more) return $args; # exit early
    
    if ($page-1) # there is a previous page
    $args['before'] .= _wp_link_page($page-1) . $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>';
    
    if ($page<$numpages) # there is a next page
    $args['after'] = _wp_link_page($page+1) . $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>' . $args['after'];
    
    return $args;
}
add_filter('wp_link_pages_args', 'mk_link_pages_args_prevnext_add');


// 分类目录和页面链接地址以 斜杠/ 结尾
function mk_trailingslashit($string, $type_of_url) {
    if ( $type_of_url != 'single' ) $string = trailingslashit($string);
    return $string;
}
add_filter('user_trailingslashit', 'mk_trailingslashit', 10, 2);


// 自动重命名上传的图片，防止中文出错
function mk_rename_upload_file_prefilter($file) {
    $time         = date('Ymd_His');
    $ext_name     = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filter_name  = preg_replace('/[^\w\s-]/', '', basename($file['name'], '.' . $ext_name));
    if(!$filter_name) $filter_name = $time;
    $file['name'] = $filter_name . '.' . $ext_name;
    return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'mk_rename_upload_file_prefilter' );


// 新建页面默认允许评论 来自：http://wordpress.org/plugins/allow-comments-on-pages-by-default/
function mk_open_comments_for_pages( $status, $post_type, $comment_type ) {
    if ( 'page' === $post_type ) {
        $status = 'open';
    }
    return $status;
}
add_filter( 'get_default_comment_status', 'mk_open_comments_for_pages', 10, 3 );


// 不对自己发送 pingback
function mk_no_self_ping( &$links ) {
    $home = get_option( 'home' );
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, $home ) ) unset($links[$l]);
}
add_action( 'pre_ping', 'mk_no_self_ping' );


// 修改 wordpress 后台字体为雅黑  https://mkblog.cn/242/
function mk_admin_font(){
    echo '
        <style type="text/css">
            body,   /*修改页面大部分的字体*/
            #wpadminbar *,  /*修改顶部菜单栏字体*/
            .media-frame, .media-modal, .media-frame input[type=text],  /*以下全是修改媒体库界面的字体*/
            .media-frame input[type=password], .media-frame input[type=number], 
            .media-frame input[type=search], .media-frame input[type=email], 
            .media-frame input[type=url], .media-frame select, .media-frame textarea
            { font-family: "Microsoft YaHei"; } /*这里不限于微软雅黑，可以是任意你喜欢的字体*/
        </style>
    ';
}
add_action('admin_head', 'mk_admin_font');


// 去掉描述P标签
function mk_delete_description_p($description) {
	$description = trim($description);
	$description = strip_tags($description, '');
	return ($description);
}
add_filter( 'category_description', 'mk_delete_description_p' );


// 可视化编辑器增强
function mk_enable_more_buttons($buttons) {
    $btns = array(
        'cut',
        'copy',
        'paste',
        'hr',
        'fontselect',
        'fontsizeselect',
        'sub',
        'sup',
        'backcolor',
        'anchor',
        'del',
        'cleanup',
        'styleselect',
        'wp_page',
	);
	foreach($btns as $btn) $buttons[] = $btn;
	return $buttons;
}
add_filter( 'mce_buttons_3', 'mk_enable_more_buttons' );


// 编辑器字体增加
function mk_custum_fontfamily($initArray) {  
    $initArray['font_formats'] = '微软雅黑=微软雅黑;宋体=宋体;黑体=黑体;仿宋=仿宋;楷体=楷体;隶书=隶书;幼圆=幼圆;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';
    return $initArray;  
}  
add_filter( 'tiny_mce_before_init', 'mk_custum_fontfamily' );


// 自动用文章标题为图片添加alt
function mk_auto_image_alt($content) {
    global $post;
    $title = $post->post_title;
    $s = array('/src="(.+?.(jpg|bmp|png|jepg|gif|webp))"/i' => 'src="$1" alt="'.$title.'"');
    foreach($s as $p => $r) {
        $content = preg_replace($p, $r, $content);
    }
    return $content;
}
add_filter( 'the_content', 'mk_auto_image_alt' );


// 评论作者链接新窗口打开
function mk_specs_comment_author_link() {
    $url    = get_comment_author_url();
    $author = get_comment_author();
    if (empty($url) || 'http://' == $url) {
        return $author;
    } else {
        if(mk_theme_option('comment_links_go')) {
            $url = mk_pagego_url() . $url;
        }
        return "<a target='_blank' href='{$url}' rel='external nofollow' class='url'>{$author}</a>";
    }
}
add_filter('get_comment_author_link', 'mk_specs_comment_author_link');


// 默认搜索伪静态 https://zhangge.net/5062.html
function mk_search_url_rewrite() {
    if ( BLOG_REWRITE && is_search() && ! empty( $_GET['s'] ) ) {
        wp_redirect( home_url( '/search/' ) . urlencode( get_query_var( 's' ) ) . '/');
        exit();
    }
}
add_action( 'template_redirect', 'mk_search_url_rewrite' );


// 搜索结果排除所有页面
function mk_search_filter_page($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts', 'mk_search_filter_page');


// 搜索结果只有一篇文章时自动跳转到该文章
function mk_search_one_redirect() {
	global $wp_query;

	if( $wp_query->is_search() && $wp_query->found_posts == 1 ){
		wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
		die;
	}
}
add_action( 'template_redirect', 'mk_search_one_redirect' );


// 支持 webp 格式的图片上传
function mk_support_upload_webp ( $existing_mimes=array() ) {
    $existing_mimes['webp'] = 'image/webp';
    return $existing_mimes;
}
add_filter( 'upload_mimes', 'mk_support_upload_webp' );


// 修复找回密码时链接不对
function mk_reset_password_message( $message, $key, $user_login, $user_data ) {
    if ( is_multisite() ) {
		$site_name = get_network()->site_name;
	} else {
		/*
		 * The blogname option is escaped with esc_html on the way into the database
		 * in sanitize_option we want to reverse this for the plain text arena of emails.
		 */
		$site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}
    
    $message = __( 'Someone has requested a password reset for the following account:' ) . "\r\n\r\n";
	/* translators: %s: site name */
	$message .= sprintf( __( 'Site Name: %s'), $site_name ) . "\r\n\r\n";
	/* translators: %s: user login */
	$message .= sprintf( __( 'Username: %s'), $user_login ) . "\r\n\r\n";
	$message .= __( 'If this was a mistake, just ignore this email and nothing will happen.' ) . "\r\n\r\n";
	$message .= __( 'To reset your password, visit the following address:' ) . "\r\n\r\n";
	$message .= network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n";
    
    return $message;
}
add_filter('retrieve_password_message', 'mk_reset_password_message', null, 4);


// 禁止搜索引擎收录回复链接
function mk_disallow_replytocom($output, $public) {
    $output .= "Disallow: /*?replytocom=\n";
    return $output;
}
add_filter('robots_txt', 'mk_disallow_replytocom', 10, 2);


// 有些 lnmp 环境可能没启用这个函数
if(!function_exists('mb_strimwidth')) {
    function mb_strimwidth( $str, $start, $width, $trimmarker ) {
        $output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start.'}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$width.'}).*/s','\1',$str);
        return $output.$trimmarker;
    }
}

