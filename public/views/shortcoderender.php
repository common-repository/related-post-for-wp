<?php
/**
 * This file render the shortcode to the frontend
 *
 * @package Woo-category-slider
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WooCommerce Category Slider - Shortcode Render class
 *
 * @since 0.1
 */
if ( ! class_exists( 'SP_WPRP_Shortcode_Render' ) ) {
	class SP_WPRP_Shortcode_Render {

		/**
		 * SP_WPRP_Shortcode_Render single instance of the class
		 *
		 * @since 0.1
		 */
		protected static $_instance = null;


		/**
		 * SP_WPRP_Shortcode_Render Instance
		 *
		 * @since 0.1
		 * 
		 * @static
		 * @return self Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * SP_WPRP_Shortcode_Render constructor.
		 */
		public function __construct() {
			add_shortcode( 'wp_related_posts', array( $this, 'shortcode_render' ) );
		}

		/**
		 * @param $attributes
		 *
		 * @return string
		 * @since 0.1
		 */
		public function shortcode_render( $attributes ) {

			if ( empty( $attributes['id'] ) ) {
				return;
			}
			$post_id = $attributes['id'];

			global $post;
			$tags = wp_get_post_tags( $post->ID );

			if ( $tags ) {
				$tag_ids = array();
				foreach( $tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
				$args = array(
					'tag__in' => $tag_ids,
					'post__not_in' => array( $post->ID ),
					'posts_per_page' => 3,
					'caller_get_posts' => 1,
				);

				$query = new wp_query( $args );
			}

			$outline = '';

			$outline .= '<div class="sp-wprp-section sp-wprp-section-' . $post_id . '">';
			$outline .= '<h3 class="sp-wprp-section-title">Related Posts</h3>';

			$outline .= '<div id="sp-wprp-area-' . $post_id . '" class="sp-wprp-area">';
			if ( $tags ) {
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						$outline .= '<div class="sp-wprp-item sp-wprp-col-xl-3 sp-wprp-col-lg-3 sp-wprp-col-md-3 sp-wprp-col-sm-2 sp-wprp-col-xs-1">';
						$outline .= '<div class="sp-wprp-item-bg">';
							$outline .= '<a href="' . get_the_permalink() . '">' . get_the_post_thumbnail( $query->post->ID, 'wprp-post-img-size' ) . '</a>';
							$outline .= '<div class="sp-wprp-post-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></div>';
						$outline .= '</div>'; // sp-wprp-item-bg.
						$outline .= '</div>'; // sp-wprp-item.
					}
				}
			}

			$outline .= '</div>'; // sp-wprp-area.
			$outline .= '</div>'; // sp-wprp-section.

			wp_reset_query();

			return $outline;

		}

	}

	new SP_WPRP_Shortcode_Render();
}
