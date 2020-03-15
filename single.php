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
                <h2 class="arc-title"><a href="#"><?php the_title(); ?></a></h2>
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

              <div class="mt-5 lyear-comment-title">
                <h5><span>评论 (5)</span></h5>
              </div>

              <ul class="media-list list-unstyled lyear-comment">

                <li id="comment-1">
				  <div class="media">
                    <img class="d-flex mr-3 rounded-circle" src="images/author.jpg" alt="花满楼">
                    <div class="media-body">
                      <a href="#!" class="text-custom reply-btn" data-id="1"><i class="mdi mdi-reply"></i>&nbsp; 回复</a>
                      <h4 class="media-heading"><a href="#!">花满楼</a></h4>
                      <p class="text-muted post-date">2019-09-25 16:17</p>
                      <p>只要你肯去领略，就会发现人生本是多么可爱，每个季节里都有很多足以让你忘记所有烦恼的赏心乐趣。</p>
                    </div>
				  </div>
                </li>

                <li id="comment-2">
				  <div class="media">
                    <img class="d-flex mr-3 rounded-circle" src="images/author.jpg" alt="陆小凤">
                    <div class="media-body">
                      <a href="#!" class="text-custom reply-btn" data-id="2"><i class="mdi mdi-reply"></i>&nbsp; 回复</a>
                      <h4 class="media-heading"><a href="#!">陆小凤</a></h4>
                      <p class="text-muted post-date">2019-07-06 15:32</p>
                      <p>有的人求名，有的人求利，我求的是什么呢？</p>
                    </div>
				  </div>
				  <ul class="comment-children">
				    <li id="comment-3">
                      <div class="media">
                        <img class="d-flex mr-3 rounded-circle" src="images/author.jpg" alt="西门吹雪">
                        <div class="media-body">
                          <a href="#!" class="text-custom reply-btn" data-id="3"><i class="mdi mdi-reply"></i>&nbsp; 回复</a>
                          <h4 class="media-heading"><a href="#!">西门吹雪</a></h4>
                          <p class="text-muted post-date">2019-07-06 15:36</p>
                          <p>麻烦！</p>
                        </div>
                      </div>
					</li>
				  </ul>
                </li>

                <li id="comment-4">
				  <div class="media">
                    <img class="d-flex mr-3 rounded-circle" src="images/author.jpg" alt="楚留香">
                    <div class="media-body">
                      <a href="#!" class="text-custom reply-btn" data-id="4"><i class="mdi mdi-reply"></i>&nbsp; 回复</a>
                      <h4 class="media-heading"><a href="#!">楚留香</a></h4>
                      <p class="text-muted post-date">2019-06-27 10:02</p>
                      <p>闻君有白玉美人，妙手雕成，极尽妍态, 不胜心向往之。今夜子正,当踏月来取, 君素雅达，必不致令我徒劳往返也。</p>
                    </div>
				  </div>
                </li>

                <li id="comment-5">
				  <div class="media">
                    <img class="d-flex mr-3 rounded-circle" src="images/author.jpg" alt="傅红雪">
                    <div class="media-body">
                      <a href="#!" class="text-custom reply-btn" data-id='5'><i class="mdi mdi-reply"></i>&nbsp; 回复</a>
                      <h4 class="media-heading"><a href="#!">傅红雪</a></h4>
                      <p class="text-muted post-date">2019-06-26 11:45</p>
                      <p>一把刀，一条没有退路的征途；一个人，一个孤独而又寂寞的灵魂！</p>
                    </div>
                  </div>
                </li>
              </ul>
              
              <div id="respond" class="comment-respond">
                <div class="mt-2">
                  <h5><span>说点什么吧...</span> <small class="cancel-comment-reply" onclick="cancelReply()">(取消回复)</small></h5>
                </div>
                
                <form action="#" method="post" class="mt-4 lyear-comment-form">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <input id="author" class="form-control" placeholder="昵称*" name="author" type="text" required="" />
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <input id="email" class="form-control" placeholder="邮箱*" name="email" type="text" required="" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <input id="subject" class="form-control" placeholder="网址" name="subject" type="text" />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <textarea id="comment" class="form-control" rows="5" placeholder="想说的内容" name="comment" required=""></textarea>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <button name="submit" type="submit" id="submit" class="btn btn-primary">发表评论</button>
                      <input type='hidden' name='comment_arc_id' value='1' id='comment_arc_id' />
                      <input type='hidden' name='comment_parent' id='comment_parent' value='0' />
                    </div>
                  </div>
                </div>
              </form>
              </div>

            </div>

          </article>
        </div>
        <!-- 内容 end -->
        <?php wp_reset_query(); endwhile; ?>
        
        <?php get_sidebar();?>
      </div>

    </div>
    <!-- end container -->
  </section>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/highlight/highlight.pack.js"></script>
<script type="text/javascript" src="js/main.min.js"></script>
<script type="text/javascript">hljs.initHighlightingOnLoad();</script>
</body>
</html>