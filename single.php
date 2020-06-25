<?php 
// 文章页面
get_header();
?>

<div class="lyear-wrapper">
  <section class="mt-5 pb-5">
    <div class="container">
    <div class="row">
        <?php while(have_posts()): the_post(); ?>
        <!-- 文章阅读 -->
        <div class="col-xl-8">
          <article class="lyear-arc">
            <div class="arc-header">
                <h2 class="arc-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <ul class="arc-meta">
                    <li><i class="mdi mdi-calendar"></i> <?php the_time('Y-m-d h:s');?></li>
                    <?php the_tags('<li><i class="mdi mdi-tag-text-outline"></i> ', ', ', '</li>'); ?>
                    <li><i class="mdi mdi-comment-multiple-outline"></i> <?php if( !post_password_required() && comments_open() ) { comments_popup_link( '暂无评论', '1 评论', '% 评论', '', '-' ); } else { echo '-'; } ?></li>
                    <li><?php edit_post_link('编辑内容', '<span class="am-icon-pencil"> ', '</span> '); ?></li>
                </ul>
            </div>
            
            <div class="lyear-arc-detail">
                
                <?php the_content(); ?>
                
                <div class="mt-5">
                    <h6>Tags:</h6>
                    <div class="tag-cloud">
                        <?php the_tags('<li><i class="mdi mdi-tag-text-outline"></i> ', ', ', '</li>'); ?>
                        <a href="#" class="badge badge-light">logo</a>
                        <a href="#" class="badge badge-light">AI</a>
                        <a href="#" class="badge badge-light">芯片</a>
                    </div>
                </div>
                
                <?php comments_template();?>
            </div> <!-- .lyear-arc-detail -->

          </article>
        </div>
        <!-- 内容 end -->
        <?php wp_reset_query(); endwhile; ?>
        
        <!-- 侧边栏 -->
        <?php get_sidebar();?>
      </div>

    </div>
    <!-- end container -->
  </section>
</div>

<?php get_footer(); ?>