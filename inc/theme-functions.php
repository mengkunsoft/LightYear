<?php

/**
 * 主题函数
 */

// 加载前端脚本及样式
function mk_theme_scripts() {
    $theme_static_url = get_template_directory_uri();
    
    // 前端脚本
    wp_enqueue_script('jquery',    $theme_static_url . '/js/jquery.min.js',     array(), THEME_VERSION, true);
    wp_enqueue_script('bootstrap', $theme_static_url . '/js/bootstrap.min.js',  array(), THEME_VERSION, true);
    wp_enqueue_script('highlight', $theme_static_url . '/js/highlight.pack.js', array(), THEME_VERSION, true);
    wp_enqueue_script('main',      $theme_static_url . '/js/main.min.js',       array(), THEME_VERSION, true);
    wp_enqueue_script('comment-reply'); 
    
    // 样式文件
    wp_enqueue_style('bootstrap',           $theme_static_url . '/css/bootstrap.min.css',           array(), THEME_VERSION, 'all');
    wp_enqueue_style('materialdesignicons', $theme_static_url . '/css/materialdesignicons.min.css', array(), THEME_VERSION, 'all');
    wp_enqueue_style('highlight',           $theme_static_url . '/css/highlight.css',               array(), THEME_VERSION, 'all');
    wp_enqueue_style('style',               $theme_static_url . '/css/style.min.css',               array(), THEME_VERSION, 'all');
    
    // 网站API设定
    wp_localize_script('script', 'mk_theme_api', array(
        'is_wap'     => wp_is_mobile()? 'true': 'false',  // 是否是手机浏览
        'ajax_url'   => admin_url() . 'admin-ajax.php',   // 评论 AJAX 路径
        'home_url'   => home_url(),                       // 网站首页路径
        'theme_url'  => get_template_directory_uri(),     // 主题路径
        'static_url' => $theme_static_url                 // 静态资源路径
    ));
}
add_action( 'wp_enqueue_scripts', 'mk_theme_scripts' );


// 自定义菜单
register_nav_menus(
    array(
        'left-menu'   => '侧边栏菜单',
        // 'mobile-menu' => '移动端侧滑菜单'
    )
);


// 导航菜单未设置回调函数
function not_set_menu_fallback($args) {
	$menus = array(
		array(
			'url'     => home_url(),
			'name'    => '首页',
			'current' => is_home()
		),
		array(
			'url'    => admin_url( 'nav-menus.php?action=locations' ),
			'name'   => '<i class="fa fa-bookmark" aria-hidden="true"></i> 添加菜单'
		)
	);
    
	$code = '<ul id="' . esc_attr( $args['theme_location'] ) . '" data-no-instant>';
	foreach ( $menus as $menu ) {
		$current_clsss = isset( $menu['current'] ) && $menu['current'] ? 'current-menu-item"' : '';
		$code .= sprintf( '<li class="%s"><a href="%s">%s</a></li>', $current_clsss, esc_url( $menu['url'] ), $menu['name'] );
	}
	$code .= '</ul>';
    
	if ( !$args['echo'] ) return $code;
	echo $code;
}


// 自动缩略图
function mk_auto_post_thumbnail($width = 270, $height = 180, $display = true, $link = true) {
    global $post;
    if ( has_post_thumbnail() ) {   // 有文章略缩图
        $img = get_the_post_thumbnail_url($post, array($width, $height));   // !这个函数要求 wp>4.4
    } else {
        $content = $post->post_content;
        // 从内容中抓取图片
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        if(count($strResult[1]) > 0) {
            $img = get_template_directory_uri().'/inc/timthumb.php?src='.urlencode($strResult[1][0]).'&w='.$width.'&h='.$height.'&zc=1';
        } else {        // 没有抓取到图片
            $img = get_template_directory_uri().'/inc/timthumb.php?_t='.rand();
        }
    }
    // 不要图片标签
    if(!$display) return $img;
    // 加上图片标签
    $img = '<img src="'.$img.'" alt="'.$post->post_title .'">';
    // 是否加上链接
    if($link) {
        echo '<a href="'.get_permalink().'">'.$img.'</a>';
    } else {
        echo $img;
    }
}


// 隐藏作者页
function mk_author_link() {
    return home_url('/');
}
add_filter('author_link', 'mk_author_link');


// 分页代码
function mk_pagenavi($p = 2) {      // 取当前页前后各 2 页
    if(is_singular()) return;       // 文章与插页不用
    
    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;
    if($max_page == 1) return;      // 只有一页时不用
    if(empty($paged))  $paged = 1;
    
    echo '<ul class="pagination">';
    
    // 分页前面的内容
    if($paged > 1)                  mk_pagelink($paged - 1, '上一页', '<i class="mdi mdi-chevron-left"></i>');    /* 如果当前页大于1就显示上一页链接 */
    if($paged > $p + 1)             mk_pagelink(1, '第一页');
    if($paged > $p + 2)             echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>'; 
    
    // 中间页码部分
    for($i = $paged - $p; $i <= $paged + $p; $i++) { 
        if($i > 0 && $i <= $max_page) {
            if($i == $paged) { 
                echo ("<li class='page-item active'><span class='page-link'>{$i}</span></li>"); 
            } else {
                mk_pagelink($i);
            }
        }
    }
    
    // 分页后面的内容
    if ($paged < $max_page - $p - 1) echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
    if ($paged < $max_page)          mk_pagelink($paged + 1, '下一页', '<i class="mdi mdi-chevron-right"></i>');              /* 如果当前页不是最后一页显示下一页链接 */
    
    echo '</ul>';
}
function mk_pagelink($pagenum, $title = '', $linktext = '') {
	if(!$title) $title = "第 {$pagenum} 页";
	if(!$linktext) $linktext = $pagenum;
	$pagenum_link = esc_html(get_pagenum_link($pagenum));
	echo "<li class='page-item'><a class='page-link' href='{$pagenum_link}' title='{$title}'>{$linktext}</a></li>";
}


// 评论@回复
function mk_comment_at($comment_text, $comment = '') {
    if($comment->comment_parent > 0) {
        $comment_text = '<a class="comment-at" href="#comment-'.$comment->comment_parent.'">' . 
                '@'.get_comment_author($comment->comment_parent).
            '</a>' . $comment_text;
    }
    return $comment_text;
}
add_filter('comment_text', 'mk_comment_at', 20, 2);


/**
 * WordPress 评论多功能工具条后台处理部分
 * 编写 By 孟坤博客
 * 文章地址： http://mkblog.cn/401/
 */
function mk_comment_code_escape( $comment ) {
    $comment = str_replace(array('<', '>'), array('&lt;', '&gt;'), $comment);
    
    $comment = preg_replace(
        array(
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[del\](.*?)\[\/del\]/is',
            '/\[pre\](.*?)\[\/pre\]/is',
            '/\[blockquote\](.*?)\[\/blockquote\]/is',
            '/\[color=([\w|#]*?)\](.*?)\[\/color\]/is',
            '/\[url=([^\"\'\]\[]+)\](.*?)\[\/url\]/is',
            '/\[img\]([^\"\'\]\[]+)\[\/img\]/is'
            ), 
            
        array(
            '<b>$1</b>',        // 变粗♂
            '<i>$1</i>',        // 变歪♂
            '<u>$1</u>',        // 加个下划线
            '<del>$1</del>',    // 加个删除线
            '<pre class="prettyprint lang- linenums:1">$1</pre>',        // 这是神秘代码
            '<blockquote>$1</blockquote>',                               // 鲁迅曾说过。。
            '<span style="color: $1">$2</span>',                         // 给点颜色看看
            '<a href="$1" target="_blank" class="comment-t-a links" rel="nofollow noopener">$2</a>',            // 会不会跳到羞羞的网站？
            '<a href="$1" data-fancybox data-no-instant><i class="fa fa-picture-o" aria-hidden="true"></i> 查看图片</a>'   // 无图无真相
            ), 
            
        $comment
    );
    
    return $comment;
}
add_filter('comment_text',     'mk_comment_code_escape');  // 在评论显示区替换
add_filter('comment_text_rss', 'mk_comment_code_escape');  // 在 RSS 中替换


// 评论内容尖括号转义
function mk_comment_escape($comment) {
    $comment = str_replace(array('<', '>'), array('&lt;', '&gt;'), $comment); // 第一步就去掉尖括号，防止xss
    return $comment;
}
add_filter('preprocess_comment', 'mk_comment_escape');    //评论写入时转义


// 密码文章表单重写 wp-includes > post-template.php
function mk_password_form($content) {
    $output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form mk-side-form" method="post">
        <p>' . __( 'This content is password protected. To view it please enter your password below:' ) . '</p>
        <p><input name="post_password" type="password" size="20" placeholder="Password" /><button type="submit">' . esc_attr_x( 'Enter', 'post password form' ) . '</button></p>
        </form>';
    return $output;
}
add_filter ('the_password_form', 'mk_password_form');


/**
 * WordPress完美禁止使用Gutenberg块编辑器并恢复到经典编辑器 - 龙笑天下
 * https://www.ilxtx.com/how-to-disable-gutenberg-block-editor.html
 */
// WP >= 5.0 正式集成Gutenberg古腾堡编辑器
// if ( version_compare( get_bloginfo('version'), '5.0', '>=' ) ) {
//     add_filter('use_block_editor_for_post', '__return_false'); // 切换回之前的编辑器
//     remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' ); // 禁止前端加载样式文件
// } else {
//     // 4.9.8 < WP < 5.0 插件形式集成Gutenberg古腾堡编辑器
//     add_filter('gutenberg_can_edit_post_type', '__return_false');
// }


// 移除多余的换行
function mk_remove_extra_line($content) 
{
    // 移除 <p> 标签换行 
    $content = preg_replace('/^\s*<\/p>/isU', '', $content);
    $content = preg_replace('/<p>\s*$/isU',   '', $content);
    // 移除 <br /> 标签换行
    $content = preg_replace('/^\s*<br\s*\/?>/isU', '', $content);
    $content = preg_replace('/<br\s*\/?>\s*$/isU', '', $content);
    return $content;
}



