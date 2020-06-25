<?php 

// 主题版本号
define('THEME_VERSION', 1.0);

if(get_option('permalink_structure')) {
	define('BLOG_REWRITE', true);
} else {
    define('BLOG_REWRITE', false);
}

// WordPress 优化
require get_template_directory() . '/inc/wp-optimize.php';

// 主题函数
require get_template_directory() . '/inc/theme-functions.php';

// 主题侧边栏
require get_template_directory() . '/inc/theme-sidebar.php';


/**
 * 如果你需要在主题的 functions.php 中加入自定义代码，可以在主题的根目录下新建一个 PHP 文件，
 * 命名为 “user-functions.php”，然后把代码放在里面。这样的话升级主题后你的代码不会被覆盖掉
 */
if(file_exists(dirname(__FILE__) . '/user-functions.php')) {
    require_once('user-functions.php');
}

/**
 * 温馨提示：
 * - 主题代码到此结束，如果本行后出现了其它代码，说明你的网站可能被挂马了
 */