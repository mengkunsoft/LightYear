<?php

/**
 * 主题侧边栏
 */

// 注册侧边小工具栏
function mk_register_sidebar() {
    register_sidebar( array(
        'name'          => '默认侧边栏',
        'id'            => 'widget_default',
        'description'   => '配置全站侧边栏显示内容',
        
        'before_widget' => '<aside class="widget widget-hot-posts %2$s">',
        'after_widget'  => '</aside>',
        
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>'
    ));
    
    register_sidebar( array(
        'name'          => '文章侧边栏',
        'id'            => 'widget_single',
        'description'   => '配置文章内容侧边栏显示内容',
        
        'before_widget' => '<aside class="widget widget-hot-posts %2$s">',
        'after_widget'  => '</aside>',
        
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>'
    ));
    
    register_sidebar( array(
        'name'          => '页面侧边栏',
        'id'            => 'widget_page',
        'description'   => '配置页面内容侧边栏显示内容',
        
        'before_widget' => '<aside class="widget widget-hot-posts %2$s">',
        'after_widget'  => '</aside>',
        
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>'
    ));
} 
add_action('widgets_init', 'mk_register_sidebar'); 


// 侧栏标签改造
function mk_tag_cloud($tag_cloud) {
    $tag_cloud = preg_replace('/(" style="[^"]*")/isU', ' badge badge-light"', $tag_cloud);
	return $tag_cloud;
}
add_filter('wp_tag_cloud', 'mk_tag_cloud', 1);
