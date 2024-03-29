<?php
/**
 * Accelerate functions and definitions
 *
 * This file contains all the functions and it's defination that particularly can't be
 * in other files.
 * 
 * @package ThemeGrill
 * @subpackage Accelerate
 * @since Accelerate 1.0
 */

/****************************************************************************************/

add_action( 'wp_enqueue_scripts', 'accelerate_scripts_styles_method' );
/**
 * Register jquery scripts
 */
function accelerate_scripts_styles_method() {
   /**
	* Loads our main stylesheet.
	*/
	wp_enqueue_style( 'accelerate_style', get_stylesheet_uri() );

  	wp_register_style( 'accelerate_googlefonts', 'http://fonts.googleapis.com/css?family=Roboto:400,300,100|Roboto+Slab:700,400' );
  	wp_enqueue_style( 'accelerate_googlefonts' );

	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/**
	 * Register JQuery cycle js file for slider.
	 */
	wp_register_script( 'jquery_cycle', ACCELERATE_JS_URL . '/jquery.cycle.all.min.js', array( 'jquery' ), '2.9999.5', true );
	
	/**
	 * Enqueue Slider setup js file.	 
	 */
	if ( is_front_page() && of_get_option( 'accelerate_activate_slider', '0' ) == '1' ) {
		wp_enqueue_script( 'accelerate_slider', ACCELERATE_JS_URL . '/accelerate-slider-setting.js', array( 'jquery_cycle' ), false, true );
	}
	wp_enqueue_script( 'accelerate-navigation', ACCELERATE_JS_URL . '/navigation.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'accelerate-custom', ACCELERATE_JS_URL. '/accelerate-custom.js', array( 'jquery' ) );

	wp_enqueue_style( 'accelerate-fontawesome', get_template_directory_uri().'/fontawesome/css/font-awesome.css', array(), '4.2.1' );

   $accelerate_user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(preg_match('/(?i)msie [1-8]/',$accelerate_user_agent)) {
		wp_enqueue_script( 'html5', ACCELERATE_JS_URL . '/html5.js', true ); 
	}

}

add_action( 'admin_print_styles-appearance_page_options-framework', 'accelerate_admin_styles' );
/**
 * Enqueuing some styles.
 *
 * @uses wp_enqueue_style to register stylesheets.
 * @uses wp_enqueue_style to add styles.
 */
function accelerate_admin_styles() {
	wp_enqueue_style( 'accelerate_admin_style', ACCELERATE_ADMIN_CSS_URL. '/admin.css' );
}

/****************************************************************************************/

add_filter( 'excerpt_length', 'accelerate_excerpt_length' );
/**
 * Sets the post excerpt length to 40 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function accelerate_excerpt_length( $length ) {
	return 40;
}

add_filter( 'excerpt_more', 'accelerate_continue_reading' );
/**
 * Returns a "Continue Reading" link for excerpts
 */
function accelerate_continue_reading() {
	return '';
}

/****************************************************************************************/

/**
 * Removing the default style of wordpress gallery
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Filtering the size to be medium from thumbnail to be used in WordPress gallery as a default size
 */
function accelerate_gallery_atts( $out, $pairs, $atts ) {
	$atts = shortcode_atts( array(
	'size' => 'medium',
	), $atts );

	$out['size'] = $atts['size'];
	 
	return $out;
 
}
add_filter( 'shortcode_atts_gallery', 'accelerate_gallery_atts', 10, 3 );

/****************************************************************************************/

add_filter( 'body_class', 'accelerate_body_class' );
/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function accelerate_body_class( $classes ) {
	global $post;

	if( $post ) { $layout_meta = get_post_meta( $post->ID, 'accelerate_page_layout', true ); }

	if( is_home() ) {
		$queried_id = get_option( 'page_for_posts' );
		$layout_meta = get_post_meta( $queried_id, 'accelerate_page_layout', true ); 
	}
	if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }
	$accelerate_default_layout = of_get_option( 'accelerate_default_layout', 'right_sidebar' );

	$accelerate_default_page_layout = of_get_option( 'accelerate_pages_default_layout', 'right_sidebar' );
	$accelerate_default_post_layout = of_get_option( 'accelerate_single_posts_default_layout', 'right_sidebar' );

	if( $layout_meta == 'default_layout' ) {
		if( is_page() ) {
			if( $accelerate_default_page_layout == 'right_sidebar' ) { $classes[] = ''; }
			elseif( $accelerate_default_page_layout == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
			elseif( $accelerate_default_page_layout == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
			elseif( $accelerate_default_page_layout == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }
		}
		elseif( is_single() ) {
			if( $accelerate_default_post_layout == 'right_sidebar' ) { $classes[] = ''; }
			elseif( $accelerate_default_post_layout == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
			elseif( $accelerate_default_post_layout == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
			elseif( $accelerate_default_post_layout == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }
		}
		elseif( $accelerate_default_layout == 'right_sidebar' ) { $classes[] = ''; }
		elseif( $accelerate_default_layout == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
		elseif( $accelerate_default_layout == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
		elseif( $accelerate_default_layout == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }
	}
	elseif( $layout_meta == 'right_sidebar' ) { $classes[] = ''; }
	elseif( $layout_meta == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
	elseif( $layout_meta == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
	elseif( $layout_meta == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }


	if ( of_get_option( 'accelerate_posts_page_display_type', 'large_image' ) == 'small_image' ) {
		$classes[] = 'blog-small';
	}
	if ( of_get_option( 'accelerate_posts_page_display_type', 'large_image' ) == 'small_image_alternate' ) {
		$classes[] = 'blog-alternate-small';
	}
	
	if( of_get_option( 'accelerate_site_layout', 'wide' ) == 'wide' ) {
		$classes[] = 'wide';
	}
	elseif( of_get_option( 'accelerate_site_layout', 'wide' ) == 'box' ) {
		$classes[] = '';
	}

	return $classes;
}

/****************************************************************************************/

if ( ! function_exists( 'accelerate_sidebar_select' ) ) :
/**
 * Fucntion to select the sidebar
 */
function accelerate_sidebar_select() {
	global $post;

	if( $post ) { $layout_meta = get_post_meta( $post->ID, 'accelerate_page_layout', true ); }

	if( is_home() ) {
		$queried_id = get_option( 'page_for_posts' );
		$layout_meta = get_post_meta( $queried_id, 'accelerate_page_layout', true ); 
	}

	if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }
	$accelerate_default_layout = of_get_option( 'accelerate_default_layout', 'right_sidebar' );

	$accelerate_default_page_layout = of_get_option( 'accelerate_pages_default_layout', 'right_sidebar' );
	$accelerate_default_post_layout = of_get_option( 'accelerate_single_posts_default_layout', 'right_sidebar' );

	if( $layout_meta == 'default_layout' ) {
		if( is_page() ) {
			if( $accelerate_default_page_layout == 'right_sidebar' ) { get_sidebar(); }
			elseif ( $accelerate_default_page_layout == 'left_sidebar' ) { get_sidebar( 'left' ); }
		}
		if( is_single() ) {
			if( $accelerate_default_post_layout == 'right_sidebar' ) { get_sidebar(); }
			elseif ( $accelerate_default_post_layout == 'left_sidebar' ) { get_sidebar( 'left' ); }
		}
		elseif( $accelerate_default_layout == 'right_sidebar' ) { get_sidebar(); }
		elseif ( $accelerate_default_layout == 'left_sidebar' ) { get_sidebar( 'left' ); }
	}
	elseif( $layout_meta == 'right_sidebar' ) { get_sidebar(); }
	elseif( $layout_meta == 'left_sidebar' ) { get_sidebar( 'left' ); }
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'accelerate_posts_listing_display_type_select' ) ) :
/**
 * Function to select the posts listing display type
 */
function accelerate_posts_listing_display_type_select() {			
	if ( of_get_option( 'accelerate_posts_page_display_type', 'large_image' ) == 'large_image' ) {
		$format = 'blog-large-image';
	}
	elseif ( of_get_option( 'accelerate_posts_page_display_type', 'large_image' ) == 'small_image' ) {
		$format = 'blog-small-image';
	}
	elseif ( of_get_option( 'accelerate_posts_page_display_type', 'large_image' ) == 'small_image_alternate' ) {
		$format = 'blog-small-image';
	}
	else {
		$format = get_post_format();
	}

	return $format;
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'accelerate_entry_meta' ) ) :
function accelerate_entry_meta() {
	echo '<div class="entry-meta">';
	?>
	<span class="byline"><span class="author vcard"><i class="fa fa-user"></i><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo get_the_author(); ?>"><?php echo esc_html( get_the_author() ); ?></a></span></span>
	<?php 

		$categories_list = get_the_category_list( __( ', ', 'accelerate' ) );
		if ( $categories_list )	printf( __( '<span class="cat-links"><i class="fa fa-folder-open"></i>%1$s</span>', 'accelerate' ), $categories_list );
		$post_format_icon = '';
		if( 'gallery' == get_post_format() ) {
			$post_format_icon = 'fa-picture-o';
		} else if ( 'video' == get_post_format() ) {
			$post_format_icon = 'fa-youtube-play';
		} else if ( 'quote' == get_post_format() ) {
			$post_format_icon = 'fa-quote-left';
		} else if ( 'link' == get_post_format() ) {
			$post_format_icon = 'fa-link';
		} else if ( 'image' == get_post_format() ) {
			$post_format_icon = 'fa-picture-o';
		} else if ( 'audio' == get_post_format() ) {
			$post_format_icon = 'fa-headphones';
		} else if ( 'aside' == get_post_format() ) {
			$post_format_icon = 'fa-dot-circle-o';
		} else if ( 'chat' == get_post_format() ) {
			$post_format_icon = 'fa-comments-o';
		} else if ( 'status' == get_post_format() ) {
			$post_format_icon = 'fa-pencil';
		}

		if( is_sticky() ) { $post_format_icon = 'fa-paperclip'; }
		?>

		<span class="sep"><span class="post-format"><i class="fa <?php echo $post_format_icon; ?>"></i></span></span>

		<?php

	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	printf( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark"><i class="fa fa-calendar-o"></i> %3$s</a></span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		$time_string
	);

	$tags_list = get_the_tag_list( '<span class="tag-links"><i class="fa fa-tags"></i>', __( ', ', 'accelerate' ), '</span>' );
	if ( $tags_list ) echo $tags_list;

	if ( ! post_password_required() && comments_open() ) { ?>
		<span class="comments-link"><?php comments_popup_link( __( '<i class="fa fa-comment"></i> 0 Comment', 'accelerate' ), __( '<i class="fa fa-comment"></i> 1 Comment', 'accelerate' ), __( '<i class="fa fa-comments"></i> % Comments', 'accelerate' ) ); ?></span>
	<?php }

	edit_post_link( __( 'Edit', 'accelerate' ), '<span class="edit-link"><i class="fa fa-edit"></i>', '</span>' );

	echo '</div>';
}
endif;

/****************************************************************************************/

add_action( 'admin_head', 'accelerate_favicon' );
add_action( 'wp_head', 'accelerate_favicon' );
/**
 * Fav icon for the site
 */
function accelerate_favicon() {
	if ( of_get_option( 'accelerate_activate_favicon', '0' ) == '1' ) {
		$accelerate_favicon = of_get_option( 'accelerate_favicon', '' );
		$accelerate_favicon_output = '';
		if ( !empty( $accelerate_favicon ) ) {
			$accelerate_favicon_output .= '<link rel="shortcut icon" href="'.esc_url( $accelerate_favicon ).'" type="image/x-icon" />';
		}
		echo $accelerate_favicon_output;
	}
}

/****************************************************************************************/

add_action('wp_head', 'accelerate_custom_css');
/**
 * Hooks the Custom Internal CSS to head section
 */
function accelerate_custom_css() {
	$accelerate_internal_css = '';

	$primary_color = of_get_option( 'accelerate_primary_color', '#77CC6D' );	
	if( $primary_color != '#77CC6D' ) {
		$accelerate_internal_css .= ' .accelerate-button,blockquote,button,input[type=button],input[type=reset],input[type=submit]{background-color:'.$primary_color.'}a{color:'.$primary_color.'}#page{border-top:3px solid '.$primary_color.'}#site-title a:hover{color:'.$primary_color.'}#search-form span,.main-navigation a:hover,.main-navigation ul li ul li a:hover,.main-navigation ul li ul li:hover>a,.main-navigation ul li.current-menu-ancestor a,.main-navigation ul li.current-menu-item a,.main-navigation ul li.current-menu-item ul li a:hover,.main-navigation ul li.current_page_ancestor a,.main-navigation ul li.current_page_item a,.main-navigation ul li:hover>a{background-color:'.$primary_color.'}.site-header .menu-toggle:before{color:'.$primary_color.'}.main-small-navigation li:hover{background-color:'.$primary_color.'}.main-small-navigation ul>.current-menu-item,.main-small-navigation ul>.current_page_item{background:'.$primary_color.'}.footer-menu a:hover,.footer-menu ul li.current-menu-ancestor a,.footer-menu ul li.current-menu-item a,.footer-menu ul li.current_page_ancestor a,.footer-menu ul li.current_page_item a,.footer-menu ul li:hover>a{color:'.$primary_color.'}#featured-slider .slider-read-more-button,.slider-nav a,.slider-title-head .entry-title a{background-color:'.$primary_color.'}#controllers a.active,#controllers a:hover{background-color:'.$primary_color.';color:'.$primary_color.'}.format-link .entry-content a{background-color:'.$primary_color.'}#secondary .widget_featured_single_post h3.widget-title a:hover,.widget_image_service_block .entry-title a:hover{color:'.$primary_color.'}.pagination span{background-color:'.$primary_color.'}.pagination a span:hover{color:'.$primary_color.';border-color:'.$primary_color.'}#content .comments-area a.comment-edit-link:hover,#content .comments-area a.comment-permalink:hover,#content .comments-area article header cite a:hover,.comments-area .comment-author-link a:hover{color:'.$primary_color.'}.comments-area .comment-author-link span{background-color:'.$primary_color.'}#wp-calendar #today,.comment .comment-reply-link:hover,.nav-next a,.nav-previous a{color:'.$primary_color.'}.widget-title span{border-bottom:2px solid '.$primary_color.'}#secondary h3 span:before,.footer-widgets-area h3 span:before{color:'.$primary_color.'}#secondary .accelerate_tagcloud_widget a:hover,.footer-widgets-area .accelerate_tagcloud_widget a:hover{background-color:'.$primary_color.'}.footer-widgets-area a:hover{color:'.$primary_color.'}.footer-socket-wrapper{border-top:3px solid '.$primary_color.'}.footer-socket-wrapper .copyright a:hover{color:'.$primary_color.'}a#scroll-up{background-color:'.$primary_color.'}.entry-meta .byline i,.entry-meta .cat-links i,.entry-meta a,.post .entry-title a:hover{color:'.$primary_color.'}.entry-meta .post-format i{background-color:'.$primary_color.'}.entry-meta .comments-link a:hover,.entry-meta .edit-link a:hover,.entry-meta .posted-on a:hover,.entry-meta .tag-links a:hover{color:'.$primary_color.'}.more-link span,.read-more{background-color:'.$primary_color.'}';
	}

	if( !empty( $accelerate_internal_css ) ) {
		?>
		<style type="text/css"><?php echo $accelerate_internal_css; ?></style>
		<?php
	}

	$accelerate_custom_css = of_get_option( 'accelerate_custom_css', '' );
	if( !empty( $accelerate_custom_css ) ) {
		?>
		<style type="text/css"><?php echo $accelerate_custom_css; ?></style>
		<?php
	}
}

/**************************************************************************************/

if ( ! function_exists( 'accelerate_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function accelerate_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'accelerate' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'accelerate' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'accelerate' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'accelerate' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'accelerate' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // accelerate_content_nav

/**************************************************************************************/

if ( ! function_exists( 'accelerate_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function accelerate_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'accelerate' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'accelerate' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 74 );
					printf( '<div class="comment-author-link"><i class="fa fa-user"></i>%1$s%2$s</div>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'accelerate' ) . '</span>' : ''
					);
					printf( '<div class="comment-date-time"><i class="fa fa-calendar-o"></i>%1$s</div>',
						sprintf( __( '%1$s at %2$s', 'accelerate' ), get_comment_date(), get_comment_time() )
					);
					printf( '<a class="comment-permalink" href="%1$s"><i class="fa fa-link"></i>Permalink</a>', esc_url( get_comment_link( $comment->comment_ID ) ) );
					edit_comment_link();
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'accelerate' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'accelerate' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</section><!-- .comment-content -->
			
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

/**************************************************************************************/

/* Register shortcodes. */
add_action( 'init', 'accelerate_add_shortcodes' );
/**
 * Creates new shortcodes for use in any shortcode-ready area.  This function uses the add_shortcode() 
 * function to register new shortcodes with WordPress.
 *
 * @uses add_shortcode() to create new shortcodes.
 */
function accelerate_add_shortcodes() {
	/* Add theme-specific shortcodes. */
	add_shortcode( 'the-year', 'accelerate_the_year_shortcode' );
	add_shortcode( 'site-link', 'accelerate_site_link_shortcode' );
	add_shortcode( 'wp-link', 'accelerate_wp_link_shortcode' );
	add_shortcode( 'tg-link', 'accelerate_themegrill_link_shortcode' );
}

/**
 * Shortcode to display the current year.
 *
 * @uses date() Gets the current year.
 * @return string
 */
function accelerate_the_year_shortcode() {
   return date( 'Y' );
}

/**
 * Shortcode to display a link back to the site.
 *
 * @uses get_bloginfo() Gets the site link
 * @return string
 */
function accelerate_site_link_shortcode() {
   return '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
}

/**
 * Shortcode to display a link to WordPress.org.
 *
 * @return string
 */
function accelerate_wp_link_shortcode() {
   return '<a href="'.esc_url( 'http://wordpress.org' ).'" target="_blank" title="' . esc_attr__( 'WordPress', 'accelerate' ) . '"><span>' . __( 'WordPress', 'accelerate' ) . '</span></a>';
}

/**
 * Shortcode to display a link to accelerate.com.
 *
 * @return string
 */
function accelerate_themegrill_link_shortcode() {
   return '<a href="'.esc_url( 'http://themegrill.com' ).'" target="_blank" title="'.esc_attr__( 'ThemeGrill', 'accelerate' ).'" ><span>'.__( 'ThemeGrill', 'accelerate') .'</span></a>';
}

/**************************************************************************************/

add_action( 'accelerate_footer_copyright', 'accelerate_footer_copyright', 10 );
/**
 * function to show the footer info, copyright information
 */
if ( ! function_exists( 'accelerate_footer_copyright' ) ) :
function accelerate_footer_copyright() {
	$accelerate_footer_copyright = '<div class="copyright">'.__( 'Copyright &copy; ', 'accelerate' ).'[the-year] [site-link] '.__( 'Theme by: ', 'accelerate' ).'[tg-link] '.__( 'Powered by: ', 'accelerate' ).'[wp-link]'.'</div>';
	echo do_shortcode( $accelerate_footer_copyright );
}
endif;

?>