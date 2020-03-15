<?php 
get_header();
?>
<div class="lyear-wrapper">
    <section class="mt-5 pb-5">
    <div class="container">
        
        <div class="row">
        <!-- 文章列表 -->
        <div class="col-xl-8">
            <?php while (have_posts()): the_post(); ?>
            <article class="lyear-arc">
                <div class="arc-header">
                    <h2 class="arc-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <ul class="arc-meta">
                        <li><i class="mdi mdi-calendar"></i> <?php the_time('Y-m-d h:s');?> </li>
                        <?php the_tags('<li><i class="mdi mdi-tag-text-outline"></i> ', ', ', '</li>'); ?>
                        <li><i class="mdi mdi-comment-multiple-outline"></i> <?php if( !post_password_required() && comments_open() ) { comments_popup_link( '暂无评论', '1 评论', '% 评论', '', '-' ); } else { echo '-'; } ?></li>
                    </ul>
                </div>
                    
                <div class="arc-preview">
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php bloginfo('template_url'); ?>/images/blog/post-1.png" alt="<?php the_title(); ?>" class="img-fluid rounded">
                    </a>
                </div>
                
                <div class="arc-synopsis">
                    <p><?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 300, '...'); ?></p>
                </div>
            </article>
            <?php endwhile; ?>
            
            <!-- 分页 -->
            <div class="row">
            <div class="col-lg-12">
            <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#"><i class="mdi mdi-chevron-left"></i></a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item"><a class="page-link" href="#"><i class="mdi mdi-chevron-right"></i></a></li>
            </ul>
            </div>
            </div>
            <!-- 分页 end -->
        </div>
        <!-- 内容 end -->

        <!-- 侧边栏 -->
        <div class="col-xl-4">
        <div class="lyear-sidebar">
        <!-- 热门文章 -->
        <aside class="widget widget-hot-posts">
        <div class="widget-title">热门文章</div>
        <ul>
        <li>
        <a href="#">三星将为 Galaxy Fold 用户提供 149 美元更换屏幕服务</a> <span>2019-09-25 10:05</span>
        </li>
        <li>
        <a href="#">专家：10年后6G将问世 数据传输速率有望比5G快100倍</a> <span>2019-09-25 08:06</span>
        </li>
        <li>
        <a href="#">苹果正式发布 iPadOS 13.1 系统，加入多项强大新功能</a> <span>2019-09-25 09:35</span>
        </li>
        </ul>
        </aside>
        
        <!-- 归档 -->
        <aside class="widget">
        <div class="widget-title">归档</div>
        <ul>
        <li><a href="#">2019 三月</a> (40)</li>
        <li><a href="#">2019 四月</a> (08)</li>
        <li><a href="#">2019 五月</a> (11)</li>
        <li><a href="#">2019 六月</a> (21)</li>
        </ul>
        </aside>
        
        <!-- 标签 -->
        <aside class="widget widget-tag-cloud">
        <div class="widget-title">标签</div>
        <div class="tag-cloud">
        <a href="#" class="badge badge-light">php</a>
        <a href="#" class="badge badge-primary">苹果</a>
        <a href="#" class="badge badge-danger">比特币</a>
        <a href="#" class="badge badge-light">linux</a>
        <a href="#" class="badge badge-light">前端</a>
        <a href="#" class="badge badge-light">vue</a>
        </div>
        </aside>
        </div>
        </div>
        <!-- 侧边栏 end -->
      </div>

    </div>
    <!-- end container -->
  </section>
</div>

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/main.min.js"></script>
</body>
</html>