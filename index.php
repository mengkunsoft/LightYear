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
                        <li><i class="mdi mdi-calendar"></i> <?php the_time('Y-m-d h:s');?></li>
                        <?php the_tags('<li><i class="mdi mdi-tag-text-outline"></i> ', ', ', '</li>'); ?>
                        <li><i class="mdi mdi-comment-multiple-outline"></i> <?php if( !post_password_required() && comments_open() ) { comments_popup_link( '暂无评论', '1 评论', '% 评论', '', '-' ); } else { echo '-'; } ?></li>
                    </ul>
                </div>
                
                <?php
                // 从内容中抓取图片
                preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $post->post_content, $strResult, PREG_PATTERN_ORDER);
                if(count($strResult[1]) > 0) :
                ?>
                <div class="arc-preview">
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo $strResult[1][0]; ?>" alt="<?php the_title(); ?>" class="img-fluid rounded">
                    </a>
                </div>
                <?php
                endif;
                ?>
                
                
                
                <div class="arc-synopsis">
                    <p><?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 300, '...'); ?></p>
                </div>
            </article>
            <?php endwhile; ?>
            
            <?php mk_pagenavi(); ?>
        </div>
        <!-- 内容 end -->
        
        <?php get_sidebar();?>
      </div>

    </div>
    <!-- end container -->
  </section>
</div>

<?php get_footer(); ?>