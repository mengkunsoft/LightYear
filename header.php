<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="yinqi,mengkun" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/materialdesignicons.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/style.min.css" />
    
    <?php wp_head(); ?>
    
    <script>
    </script>
</head>
<body>

<header class="lyear-header text-center" style="background-image:url(<?php bloginfo('template_url'); ?>/images/left-bg.jpg);">
    <div class="lyear-header-container">
        <div class="lyear-mask"></div>
        <h1 class="lyear-blogger pt-lg-4 mb-0"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-toggler" data-toggle="collapse" data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                <div class="lyear-hamburger">
                    <div class="hamburger-inner"></div>
                </div>
            </a>
            
            <div id="navigation" class="collapse navbar-collapse flex-column">
                <div class="profile-section pt-3 pt-lg-0">
                    <img class="profile-image mb-3 rounded-circle mx-auto" src="<?php bloginfo('template_url'); ?>/images/lyear.png" width="120" height="120" alt="<?php bloginfo('name'); ?>" >
                    <div class="lyear-sentence mb-3">必须记住我们学习的时间是有限的。时间有限，不只由于人生短促，更由于人事纷繁。我们就应力求把我们所有的时间用去做最有益的事情。</div>
                    <hr>
                </div>
                
                <ul class="navbar-nav flex-column text-center">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.html">首页</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">技术</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">感悟</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">关于我</a>
                    </li>
                </ul>
                
                <div class="my-2 my-md-3">
                    <form class="lyear-search-form form-inline justify-content-center pt-3">
                        <input type="email" id="semail" name="semail1" class="form-control mr-md-1" placeholder="搜索关键词" />
                    </form>
                </div>
            </div>
        </nav>
    </div>
</header>
