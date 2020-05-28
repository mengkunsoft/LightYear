<?php
/**
 * 评论模板
 */

// 密码保护的文章
if(post_password_required()) {
	echo '<p class="nocomments">' . _e('This post is password protected. Enter the password to view comments.') . '</p>';
	return;
}

// 禁止评论的文章
if(!comments_open()) {
    echo '<p class="nocomments">' . _e('Comments are closed.') . '</p>';
	return;
}


if(have_comments()) : 
?>
    
	<h3 id="comments">
		<?php
		if ( 1 == get_comments_number() ) {
			/* translators: %s: post title */
			printf( __( 'One response to %s' ), '&#8220;' . get_the_title() . '&#8221;' );
		} else {
			/* translators: 1: number of comments, 2: post title */
			printf(
				_n( '%1$s response to %2$s', '%1$s responses to %2$s', get_comments_number() ),
				number_format_i18n( get_comments_number() ),
				'&#8220;' . get_the_title() . '&#8221;'
			);
		}
		?>
	</h3>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link(); ?></div>
		<div class="alignright"><?php next_comments_link(); ?></div>
	</div>

	<ol class="commentlist">
	<?php wp_list_comments(); ?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link(); ?></div>
		<div class="alignright"><?php next_comments_link(); ?></div>
	</div>
<?php

else:
    echo '<h3 id="comments">暂无评论</h3>';
endif; 

comment_form();