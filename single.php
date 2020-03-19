<?php 
// 文章页面
get_header();
?>

<div class="lyear-wrapper">
  <section class="mt-5 pb-5">
    <div class="container">

      <div class="row">
          <?php while ( have_posts() ) : the_post(); ?>
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
                        <a href="#" class="badge badge-light">logo</a>
                        <a href="#" class="badge badge-light">AI</a>
                        <a href="#" class="badge badge-light">芯片</a>
                    </div>
                </div>

<style>
h3#comments {
    font-size: 1.25rem;
    padding: 20px 0;
    margin-bottom: 20px;
    border-top: 1px solid #f5f5f5;
    border-bottom: 1px solid #f5f5f5;
}

.commentlist, .commentlist ul, .commentlist li {
    position: relative;
    padding-left: 0;
    list-style: none;
}
.commentlist li.comment {
    padding-left: 54px;
}
.comment-body {
    margin-top: 50px;
    word-break: break-all;
}
.comment-body .comment-author img {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 1px solid #eee;
    position: absolute;
    left: 0;
    top: 6px;
}

.comment-body .comment-author .fn {
    font-size: 14px;
    font-weight: 700;
    line-height: 1.7;
    font-style: normal;
}

.comment-body .comment-author .says {
    display: none;
}

.comment-body .comment-meta {
    margin: 2px 0 20px;
    line-height: 1.7;
    font-size: 12px;
    color: #6c757d;
}

.comment-body .comment-at {
    color: #0069d9;
    padding-right: 8px;
}

.comment-body .reply, #cancel-comment-reply-link {
    position: absolute;
    right: 0;
    top: 0;
    font-size: 12px;
}
.comment-body .reply:before {
    padding-right: 4px;
    content: "\F45A";
    display: inline-block;
    font: normal normal normal 24px/1 "Material Design Icons";
    font-size: inherit;
    text-rendering: auto;
    line-height: inherit;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.commentlist .children {
    
}

/* 评论框 */
#respond {
    position: relative;
}
#reply-title {
    font-size: 1.25rem;
    margin: 30px 0 0;
}
.comment-notes, .logged-in-as {
    color: #4d5259;
    font-size: 14px;
}

.comment-form-author,
.comment-form-email {
    width: 50%;
    float: left;
}
p.comment-form-author,
p.comment-form-email,
p.comment-form-url {
    margin-bottom: 10px;
}
.comment-form-author {
    padding-right: 12px;
}
.comment-form-email {
    padding-left: 12px;
}
#commentform label {
    font-size: 14px;
}
#author, #email, #url, #comment {
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    font-size: 14px;
    -webkit-border-radius: 2px;
         -o-border-radius: 2px;
            border-radius: 2px;
}
#author:focus, 
#email:focus, 
#url:focus, 
#comment:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}
#author, #email, #url {
    height: calc(1.5em + .75rem + 2px);
}
#comment {
    height: 6rem;
}

#submit {
    -webkit-border-radius: 2px;
         -o-border-radius: 2px;
            border-radius: 2px;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    display: inline-block;
    font-weight: 400;
    text-align: center;
    vertical-align: middle;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
}

/* 翻页 */
.navigation a {
    font-size: .8rem;
}
</style>
            
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