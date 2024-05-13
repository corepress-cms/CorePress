<?php
/**
 * Deprecated functions from past WordPress versions. You shouldn't use these
 * functions and look for the alternatives instead. The functions will be
 * removed in a later version.
 *
 * @package WordPress
 * @subpackage Deprecated
 */

/*
 * Deprecated functions come here to die.
 */

/**
 * Checks whether serialization of the current block's border properties should occur.
 *
 * @since 5.8.0
 * @access private
 * @deprecated 6.0.0 Use wp_should_skip_block_supports_serialization() introduced in 6.0.0.
 *
 * @see wp_should_skip_block_supports_serialization()
 *
 * @param WP_Block_Type $block_type Block type.
 * @return bool Whether serialization of the current block's border properties
 *              should occur.
 */
function wp_skip_border_serialization( $block_type ) {
	_deprecated_function( __FUNCTION__, '6.0.0', 'wp_should_skip_block_supports_serialization()' );

	$border_support = isset( $block_type->supports['__experimentalBorder'] )
		? $block_type->supports['__experimentalBorder']
		: false;

	return is_array( $border_support ) &&
		array_key_exists( '__experimentalSkipSerialization', $border_support ) &&
		$border_support['__experimentalSkipSerialization'];
}

/**
 * Checks whether serialization of the current block's dimensions properties should occur.
 *
 * @since 5.9.0
 * @access private
 * @deprecated 6.0.0 Use wp_should_skip_block_supports_serialization() introduced in 6.0.0.
 *
 * @see wp_should_skip_block_supports_serialization()
 *
 * @param WP_Block_type $block_type Block type.
 * @return bool Whether to serialize spacing support styles & classes.
 */
function wp_skip_dimensions_serialization( $block_type ) {
	_deprecated_function( __FUNCTION__, '6.0.0', 'wp_should_skip_block_supports_serialization()' );

	$dimensions_support = isset( $block_type->supports['__experimentalDimensions'] )
		? $block_type->supports['__experimentalDimensions']
		: false;

	return is_array( $dimensions_support ) &&
		array_key_exists( '__experimentalSkipSerialization', $dimensions_support ) &&
		$dimensions_support['__experimentalSkipSerialization'];
}

/**
 * Checks whether serialization of the current block's spacing properties should occur.
 *
 * @since 5.9.0
 * @access private
 * @deprecated 6.0.0 Use wp_should_skip_block_supports_serialization() introduced in 6.0.0.
 *
 * @see wp_should_skip_block_supports_serialization()
 *
 * @param WP_Block_Type $block_type Block type.
 * @return bool Whether to serialize spacing support styles & classes.
 */
function wp_skip_spacing_serialization( $block_type ) {
	_deprecated_function( __FUNCTION__, '6.0.0', 'wp_should_skip_block_supports_serialization()' );

	$spacing_support = isset( $block_type->supports['spacing'] )
		? $block_type->supports['spacing']
		: false;

	return is_array( $spacing_support ) &&
		array_key_exists( '__experimentalSkipSerialization', $spacing_support ) &&
		$spacing_support['__experimentalSkipSerialization'];
}

/**
 * Inject the block editor assets that need to be loaded into the editor's iframe as an inline script.
 *
 * @since 5.8.0
 * @deprecated 6.0.0
 */
function wp_add_iframed_editor_assets_html() {
	_deprecated_function( __FUNCTION__, '6.0.0' );
}

/**
 * Retrieves thumbnail for an attachment.
 * Note that this works only for the (very) old image metadata style where 'thumb' was set,
 * and the 'sizes' array did not exist. This function returns false for the newer image metadata style
 * despite that 'thumbnail' is present in the 'sizes' array.
 *
 * @since 2.1.0
 * @deprecated 6.1.0
 *
 * @param int $post_id Optional. Attachment ID. Default is the ID of the global `$post`.
 * @return string|false Thumbnail file path on success, false on failure.
 */
function wp_get_attachment_thumb_file( $post_id = 0 ) {
	_deprecated_function( __FUNCTION__, '6.1.0' );

	$post_id = (int) $post_id;
	$post    = get_post( $post_id );

	if ( ! $post ) {
		return false;
	}

	// Use $post->ID rather than $post_id as get_post() may have used the global $post object.
	$imagedata = wp_get_attachment_metadata( $post->ID );

	if ( ! is_array( $imagedata ) ) {
		return false;
	}

	$file = get_attached_file( $post->ID );

	if ( ! empty( $imagedata['thumb'] ) ) {
		$thumbfile = str_replace( wp_basename( $file ), $imagedata['thumb'], $file );
		if ( file_exists( $thumbfile ) ) {
			/**
			 * Filters the attachment thumbnail file path.
			 *
			 * @since 2.1.0
			 *
			 * @param string $thumbfile File path to the attachment thumbnail.
			 * @param int    $post_id   Attachment ID.
			 */
			return apply_filters( 'wp_get_attachment_thumb_file', $thumbfile, $post->ID );
		}
	}

	return false;
}

/**
 * Gets the path to a translation file for loading a textdomain just in time.
 *
 * Caches the retrieved results internally.
 *
 * @since 4.7.0
 * @deprecated 6.1.0
 * @access private
 *
 * @see _load_textdomain_just_in_time()
 *
 * @param string $domain Text domain. Unique identifier for retrieving translated strings.
 * @param bool   $reset  Whether to reset the internal cache. Used by the switch to locale functionality.
 * @return string|false The path to the translation file or false if no translation file was found.
 */
function _get_path_to_translation( $domain, $reset = false ) {
	_deprecated_function( __FUNCTION__, '6.1.0', 'WP_Textdomain_Registry' );

	static $available_translations = array();

	if ( true === $reset ) {
		$available_translations = array();
	}

	if ( ! isset( $available_translations[ $domain ] ) ) {
		$available_translations[ $domain ] = _get_path_to_translation_from_lang_dir( $domain );
	}

	return $available_translations[ $domain ];
}

/**
 * Gets the path to a translation file in the languages directory for the current locale.
 *
 * Holds a cached list of available .mo files to improve performance.
 *
 * @since 4.7.0
 * @deprecated 6.1.0
 * @access private
 *
 * @see _get_path_to_translation()
 *
 * @param string $domain Text domain. Unique identifier for retrieving translated strings.
 * @return string|false The path to the translation file or false if no translation file was found.
 */
function _get_path_to_translation_from_lang_dir( $domain ) {
	_deprecated_function( __FUNCTION__, '6.1.0', 'WP_Textdomain_Registry' );

	static $cached_mofiles = null;

	if ( null === $cached_mofiles ) {
		$cached_mofiles = array();

		$locations = array(
			WP_LANG_DIR . '/plugins',
			WP_LANG_DIR . '/themes',
		);

		foreach ( $locations as $location ) {
			$mofiles = glob( $location . '/*.mo' );
			if ( $mofiles ) {
				$cached_mofiles = array_merge( $cached_mofiles, $mofiles );
			}
		}
	}

	$locale = determine_locale();
	$mofile = "{$domain}-{$locale}.mo";

	$path = WP_LANG_DIR . '/plugins/' . $mofile;
	if ( in_array( $path, $cached_mofiles, true ) ) {
		return $path;
	}

	$path = WP_LANG_DIR . '/themes/' . $mofile;
	if ( in_array( $path, $cached_mofiles, true ) ) {
		return $path;
	}

	return false;
}

/**
 * Allows multiple block styles.
 *
 * @since 5.9.0
 * @deprecated 6.1.0
 *
 * @param array $metadata Metadata for registering a block type.
 * @return array Metadata for registering a block type.
 */
function _wp_multiple_block_styles( $metadata ) {
	_deprecated_function( __FUNCTION__, '6.1.0' );
	return $metadata;
}

/**
 * Generates an inline style for a typography feature e.g. text decoration,
 * text transform, and font style.
 *
 * @since 5.8.0
 * @access private
 * @deprecated 6.1.0 Use wp_style_engine_get_styles() introduced in 6.1.0.
 *
 * @see wp_style_engine_get_styles()
 *
 * @param array  $attributes   Block's attributes.
 * @param string $feature      Key for the feature within the typography styles.
 * @param string $css_property Slug for the CSS property the inline style sets.
 * @return string CSS inline style.
 */
function wp_typography_get_css_variable_inline_style( $attributes, $feature, $css_property ) {
	_deprecated_function( __FUNCTION__, '6.1.0', 'wp_style_engine_get_styles()' );

	// Retrieve current attribute value or skip if not found.
	$style_value = _wp_array_get( $attributes, array( 'style', 'typography', $feature ), false );
	if ( ! $style_value ) {
		return;
	}

	// If we don't have a preset CSS variable, we'll assume it's a regular CSS value.
	if ( ! str_contains( $style_value, "var:preset|{$css_property}|" ) ) {
		return sprintf( '%s:%s;', $css_property, $style_value );
	}

	/*
	 * We have a preset CSS variable as the style.
	 * Get the style value from the string and return CSS style.
	 */
	$index_to_splice = strrpos( $style_value, '|' ) + 1;
	$slug            = substr( $style_value, $index_to_splice );

	// Return the actual CSS inline style e.g. `text-decoration:var(--wp--preset--text-decoration--underline);`.
	return sprintf( '%s:var(--wp--preset--%s--%s);', $css_property, $css_property, $slug );
}

/**
 * Determines whether global terms are enabled.
 *
 * @since 3.0.0
 * @since 6.1.0 This function now always returns false.
 * @deprecated 6.1.0
 *
 * @return bool Always returns false.
 */
function global_terms_enabled() {
	_deprecated_function( __FUNCTION__, '6.1.0' );

	return false;
}

/**
 * Filter the SQL clauses of an attachment query to include filenames.
 *
 * @since 4.7.0
 * @deprecated 6.0.3
 * @access private
 *
 * @param array $clauses An array including WHERE, GROUP BY, JOIN, ORDER BY,
 *                       DISTINCT, fields (SELECT), and LIMITS clauses.
 * @return array The unmodified clauses.
 */
function _filter_query_attachment_filenames( $clauses ) {
	_deprecated_function( __FUNCTION__, '6.0.3', 'add_filter( "wp_allow_query_attachment_by_filename", "__return_true" )' );
	remove_filter( 'posts_clauses', __FUNCTION__ );
	return $clauses;
}

/**
 * Retrieves a page given its title.
 *
 * If more than one post uses the same title, the post with the smallest ID will be returned.
 * Be careful: in case of more than one post having the same title, it will check the oldest
 * publication date, not the smallest ID.
 *
 * Because this function uses the MySQL '=' comparison, $page_title will usually be matched
 * as case-insensitive with default collation.
 *
 * @since 2.1.0
 * @since 3.0.0 The `$post_type` parameter was added.
 * @deprecated 6.2.0 Use WP_Query.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string       $page_title Page title.
 * @param string       $output     Optional. The required return type. One of OBJECT, ARRAY_A, or ARRAY_N, which
 *                                 correspond to a WP_Post object, an associative array, or a numeric array,
 *                                 respectively. Default OBJECT.
 * @param string|array $post_type  Optional. Post type or array of post types. Default 'page'.
 * @return WP_Post|array|null WP_Post (or array) on success, or null on failure.
 */
function get_page_by_title( $page_title, $output = OBJECT, $post_type = 'page' ) {
	_deprecated_function( __FUNCTION__, '6.2.0', 'WP_Query' );
	global $wpdb;

	if ( is_array( $post_type ) ) {
		$post_type           = esc_sql( $post_type );
		$post_type_in_string = "'" . implode( "','", $post_type ) . "'";
		$sql                 = $wpdb->prepare(
			"SELECT ID
			FROM $wpdb->posts
			WHERE post_title = %s
			AND post_type IN ($post_type_in_string)",
			$page_title
		);
	} else {
		$sql = $wpdb->prepare(
			"SELECT ID
			FROM $wpdb->posts
			WHERE post_title = %s
			AND post_type = %s",
			$page_title,
			$post_type
		);
	}

	$page = $wpdb->get_var( $sql );

	if ( $page ) {
		return get_post( $page, $output );
	}

	return null;
}

/**
 * Returns the correct template for the site's home page.
 *
 * @access private
 * @since 6.0.0
 * @deprecated 6.2.0 Site Editor's server-side redirect for missing postType and postId
 *                   query args is removed. Thus, this function is no longer used.
 *
 * @return array|null A template object, or null if none could be found.
 */
function _resolve_home_block_template() {
	_deprecated_function( __FUNCTION__, '6.2.0' );

	$show_on_front = get_option( 'show_on_front' );
	$front_page_id = get_option( 'page_on_front' );

	if ( 'page' === $show_on_front && $front_page_id ) {
		return array(
				'postType' => 'page',
				'postId'   => $front_page_id,
		);
	}

	$hierarchy = array( 'front-page', 'home', 'index' );
	$template  = resolve_block_template( 'home', $hierarchy, '' );

	if ( ! $template ) {
		return null;
	}

	return array(
			'postType' => 'wp_template',
			'postId'   => $template->id,
	);
}

/**
 * Displays the link to the Windows Live Writer manifest file.
 *
 * @link https://msdn.microsoft.com/en-us/library/bb463265.aspx
 * @since 2.3.1
 * @deprecated 6.3.0 WLW manifest is no longer in use and no longer included in core,
 *                   so the output from this function is removed.
 */
function wlwmanifest_link() {
	_deprecated_function( __FUNCTION__, '6.3.0' );
}

/**
 * Queues comments for metadata lazy-loading.
 *
 * @since 4.5.0
 * @deprecated 6.3.0 Use wp_lazyload_comment_meta() instead.
 *
 * @param WP_Comment[] $comments Array of comment objects.
 */
function wp_queue_comments_for_comment_meta_lazyload( $comments ) {
	_deprecated_function( __FUNCTION__, '6.3.0', 'wp_lazyload_comment_meta()' );
	// Don't use `wp_list_pluck()` to avoid by-reference manipulation.
	$comment_ids = array();
	if ( is_array( $comments ) ) {
		foreach ( $comments as $comment ) {
			if ( $comment instanceof WP_Comment ) {
				$comment_ids[] = $comment->comment_ID;
			}
		}
	}

	wp_lazyload_comment_meta( $comment_ids );
}

/**
 * Gets the default value to use for a `loading` attribute on an element.
 *
 * This function should only be called for a tag and context if lazy-loading is generally enabled.
 *
 * The function usually returns 'lazy', but uses certain heuristics to guess whether the current element is likely to
 * appear above the fold, in which case it returns a boolean `false`, which will lead to the `loading` attribute being
 * omitted on the element. The purpose of this refinement is to avoid lazy-loading elements that are within the initial
 * viewport, which can have a negative performance impact.
 *
 * Under the hood, the function uses {@see wp_increase_content_media_count()} every time it is called for an element
 * within the main content. If the element is the very first content element, the `loading` attribute will be omitted.
 * This default threshold of 3 content elements to omit the `loading` attribute for can be customized using the
 * {@see 'wp_omit_loading_attr_threshold'} filter.
 *
 * @since 5.9.0
 * @deprecated 6.3.0 Use wp_get_loading_optimization_attributes() instead.
 * @see wp_get_loading_optimization_attributes()
 *
 * @global WP_Query $wp_query WordPress Query object.
 *
 * @param string $context Context for the element for which the `loading` attribute value is requested.
 * @return string|bool The default `loading` attribute value. Either 'lazy', 'eager', or a boolean `false`, to indicate
 *                     that the `loading` attribute should be skipped.
 */
function wp_get_loading_attr_default( $context ) {
	_deprecated_function( __FUNCTION__, '6.3.0', 'wp_get_loading_optimization_attributes()' );
	global $wp_query;

	// Skip lazy-loading for the overall block template, as it is handled more granularly.
	if ( 'template' === $context ) {
		return false;
	}

	/*
	 * Do not lazy-load images in the header block template part, as they are likely above the fold.
	 * For classic themes, this is handled in the condition below using the 'get_header' action.
	 */
	$header_area = WP_TEMPLATE_PART_AREA_HEADER;
	if ( "template_part_{$header_area}" === $context ) {
		return false;
	}

	// Special handling for programmatically created image tags.
	if ( 'the_post_thumbnail' === $context || 'wp_get_attachment_image' === $context ) {
		/*
		 * Skip programmatically created images within post content as they need to be handled together with the other
		 * images within the post content.
		 * Without this clause, they would already be counted below which skews the number and can result in the first
		 * post content image being lazy-loaded only because there are images elsewhere in the post content.
		 */
		if ( doing_filter( 'the_content' ) ) {
			return false;
		}

		// Conditionally skip lazy-loading on images before the loop.
		if (
			// Only apply for main query but before the loop.
			$wp_query->before_loop && $wp_query->is_main_query()
			/*
			 * Any image before the loop, but after the header has started should not be lazy-loaded,
			 * except when the footer has already started which can happen when the current template
			 * does not include any loop.
			 */
			&& did_action( 'get_header' ) && ! did_action( 'get_footer' )
		) {
			return false;
		}
	}

	/*
	 * The first elements in 'the_content' or 'the_post_thumbnail' should not be lazy-loaded,
	 * as they are likely above the fold.
	 */
	if ( 'the_content' === $context || 'the_post_thumbnail' === $context ) {
		// Only elements within the main query loop have special handling.
		if ( is_admin() || ! in_the_loop() || ! is_main_query() ) {
			return 'lazy';
		}

		// Increase the counter since this is a main query content element.
		$content_media_count = wp_increase_content_media_count();

		// If the count so far is below the threshold, return `false` so that the `loading` attribute is omitted.
		if ( $content_media_count <= wp_omit_loading_attr_threshold() ) {
			return false;
		}

		// For elements after the threshold, lazy-load them as usual.
		return 'lazy';
	}

	// Lazy-load by default for any unknown context.
	return 'lazy';
}

/**
 * Adds `loading` attribute to an `img` HTML tag.
 *
 * @since 5.5.0
 * @deprecated 6.3.0 Use wp_img_tag_add_loading_optimization_attrs() instead.
 * @see wp_img_tag_add_loading_optimization_attrs()
 *
 * @param string $image   The HTML `img` tag where the attribute should be added.
 * @param string $context Additional context to pass to the filters.
 * @return string Converted `img` tag with `loading` attribute added.
 */
function wp_img_tag_add_loading_attr( $image, $context ) {
	_deprecated_function( __FUNCTION__, '6.3.0', 'wp_img_tag_add_loading_optimization_attrs()' );
	/*
	 * Get loading attribute value to use. This must occur before the conditional check below so that even images that
	 * are ineligible for being lazy-loaded are considered.
	 */
	$value = wp_get_loading_attr_default( $context );

	// Images should have source and dimension attributes for the `loading` attribute to be added.
	if ( ! str_contains( $image, ' src="' ) || ! str_contains( $image, ' width="' ) || ! str_contains( $image, ' height="' ) ) {
		return $image;
	}

	/** This filter is documented in wp-admin/includes/media.php */
	$value = apply_filters( 'wp_img_tag_add_loading_attr', $value, $image, $context );

	if ( $value ) {
		if ( ! in_array( $value, array( 'lazy', 'eager' ), true ) ) {
			$value = 'lazy';
		}

		return str_replace( '<img', '<img loading="' . esc_attr( $value ) . '"', $image );
	}

	return $image;
}

/**
 * Takes input from [0, n] and returns it as [0, 1].
 *
 * Direct port of TinyColor's function, lightly simplified to maintain
 * consistency with TinyColor.
 *
 * @link https://github.com/bgrins/TinyColor
 *
 * @since 5.8.0
 * @deprecated 6.3.0
 *
 * @access private
 *
 * @param mixed $n   Number of unknown type.
 * @param int   $max Upper value of the range to bound to.
 * @return float Value in the range [0, 1].
 */
function wp_tinycolor_bound01( $n, $max ) {
	_deprecated_function( __FUNCTION__, '6.3.0' );
	if ( 'string' === gettype( $n ) && str_contains( $n, '.' ) && 1 === (float) $n ) {
		$n = '100%';
	}

	$n = min( $max, max( 0, (float) $n ) );

	// Automatically convert percentage into number.
	if ( 'string' === gettype( $n ) && str_contains( $n, '%' ) ) {
		$n = (int) ( $n * $max ) / 100;
	}

	// Handle floating point rounding errors.
	if ( ( abs( $n - $max ) < 0.000001 ) ) {
		return 1.0;
	}

	// Convert into [0, 1] range if it isn't already.
	return ( $n % $max ) / (float) $max;
}

/**
 * Direct port of tinycolor's boundAlpha function to maintain consistency with
 * how tinycolor works.
 *
 * @link https://github.com/bgrins/TinyColor
 *
 * @since 5.9.0
 * @deprecated 6.3.0
 *
 * @access private
 *
 * @param mixed $n Number of unknown type.
 * @return float Value in the range [0,1].
 */
function _wp_tinycolor_bound_alpha( $n ) {
	_deprecated_function( __FUNCTION__, '6.3.0' );

	if ( is_numeric( $n ) ) {
		$n = (float) $n;
		if ( $n >= 0 && $n <= 1 ) {
			return $n;
		}
	}
	return 1;
}

/**
 * Rounds and converts values of an RGB object.
 *
 * Direct port of TinyColor's function, lightly simplified to maintain
 * consistency with TinyColor.
 *
 * @link https://github.com/bgrins/TinyColor
 *
 * @since 5.8.0
 * @deprecated 6.3.0
 *
 * @access private
 *
 * @param array $rgb_color RGB object.
 * @return array Rounded and converted RGB object.
 */
function wp_tinycolor_rgb_to_rgb( $rgb_color ) {
	_deprecated_function( __FUNCTION__, '6.3.0' );

	return array(
		'r' => wp_tinycolor_bound01( $rgb_color['r'], 255 ) * 255,
		'g' => wp_tinycolor_bound01( $rgb_color['g'], 255 ) * 255,
		'b' => wp_tinycolor_bound01( $rgb_color['b'], 255 ) * 255,
	);
}

/**
 * Helper function for hsl to rgb conversion.
 *
 * Direct port of TinyColor's function, lightly simplified to maintain
 * consistency with TinyColor.
 *
 * @link https://github.com/bgrins/TinyColor
 *
 * @since 5.8.0
 * @deprecated 6.3.0
 *
 * @access private
 *
 * @param float $p first component.
 * @param float $q second component.
 * @param float $t third component.
 * @return float R, G, or B component.
 */
function wp_tinycolor_hue_to_rgb( $p, $q, $t ) {
	_deprecated_function( __FUNCTION__, '6.3.0' );

	if ( $t < 0 ) {
		++$t;
	}
	if ( $t > 1 ) {
		--$t;
	}
	if ( $t < 1 / 6 ) {
		return $p + ( $q - $p ) * 6 * $t;
	}
	if ( $t < 1 / 2 ) {
		return $q;
	}
	if ( $t < 2 / 3 ) {
		return $p + ( $q - $p ) * ( 2 / 3 - $t ) * 6;
	}
	return $p;
}

/**
 * Converts an HSL object to an RGB object with converted and rounded values.
 *
 * Direct port of TinyColor's function, lightly simplified to maintain
 * consistency with TinyColor.
 *
 * @link https://github.com/bgrins/TinyColor
 *
 * @since 5.8.0
 * @deprecated 6.3.0
 *
 * @access private
 *
 * @param array $hsl_color HSL object.
 * @return array Rounded and converted RGB object.
 */
function wp_tinycolor_hsl_to_rgb( $hsl_color ) {
	_deprecated_function( __FUNCTION__, '6.3.0' );

	$h = wp_tinycolor_bound01( $hsl_color['h'], 360 );
	$s = wp_tinycolor_bound01( $hsl_color['s'], 100 );
	$l = wp_tinycolor_bound01( $hsl_color['l'], 100 );

	if ( 0 === $s ) {
		// Achromatic.
		$r = $l;
		$g = $l;
		$b = $l;
	} else {
		$q = $l < 0.5 ? $l * ( 1 + $s ) : $l + $s - $l * $s;
		$p = 2 * $l - $q;
		$r = wp_tinycolor_hue_to_rgb( $p, $q, $h + 1 / 3 );
		$g = wp_tinycolor_hue_to_rgb( $p, $q, $h );
		$b = wp_tinycolor_hue_to_rgb( $p, $q, $h - 1 / 3 );
	}

	return array(
		'r' => $r * 255,
		'g' => $g * 255,
		'b' => $b * 255,
	);
}

/**
 * Parses hex, hsl, and rgb CSS strings using the same regex as TinyColor v1.4.2
 * used in the JavaScript. Only colors output from react-color are implemented.
 *
 * Direct port of TinyColor's function, lightly simplified to maintain
 * consistency with TinyColor.
 *
 * @link https://github.com/bgrins/TinyColor
 * @link https://github.com/casesandberg/react-color/
 *
 * @since 5.8.0
 * @since 5.9.0 Added alpha processing.
 * @deprecated 6.3.0
 *
 * @access private
 *
 * @param string $color_str CSS color string.
 * @return array RGB object.
 */
function wp_tinycolor_string_to_rgb( $color_str ) {
	_deprecated_function( __FUNCTION__, '6.3.0' );

	$color_str = strtolower( trim( $color_str ) );

	$css_integer = '[-\\+]?\\d+%?';
	$css_number  = '[-\\+]?\\d*\\.\\d+%?';

	$css_unit = '(?:' . $css_number . ')|(?:' . $css_integer . ')';

	$permissive_match3 = '[\\s|\\(]+(' . $css_unit . ')[,|\\s]+(' . $css_unit . ')[,|\\s]+(' . $css_unit . ')\\s*\\)?';
	$permissive_match4 = '[\\s|\\(]+(' . $css_unit . ')[,|\\s]+(' . $css_unit . ')[,|\\s]+(' . $css_unit . ')[,|\\s]+(' . $css_unit . ')\\s*\\)?';

	$rgb_regexp = '/^rgb' . $permissive_match3 . '$/';
	if ( preg_match( $rgb_regexp, $color_str, $match ) ) {
		$rgb = wp_tinycolor_rgb_to_rgb(
			array(
				'r' => $match[1],
				'g' => $match[2],
				'b' => $match[3],
			)
		);

		$rgb['a'] = 1;

		return $rgb;
	}

	$rgba_regexp = '/^rgba' . $permissive_match4 . '$/';
	if ( preg_match( $rgba_regexp, $color_str, $match ) ) {
		$rgb = wp_tinycolor_rgb_to_rgb(
			array(
				'r' => $match[1],
				'g' => $match[2],
				'b' => $match[3],
			)
		);

		$rgb['a'] = _wp_tinycolor_bound_alpha( $match[4] );

		return $rgb;
	}

	$hsl_regexp = '/^hsl' . $permissive_match3 . '$/';
	if ( preg_match( $hsl_regexp, $color_str, $match ) ) {
		$rgb = wp_tinycolor_hsl_to_rgb(
			array(
				'h' => $match[1],
				's' => $match[2],
				'l' => $match[3],
			)
		);

		$rgb['a'] = 1;

		return $rgb;
	}

	$hsla_regexp = '/^hsla' . $permissive_match4 . '$/';
	if ( preg_match( $hsla_regexp, $color_str, $match ) ) {
		$rgb = wp_tinycolor_hsl_to_rgb(
			array(
				'h' => $match[1],
				's' => $match[2],
				'l' => $match[3],
			)
		);

		$rgb['a'] = _wp_tinycolor_bound_alpha( $match[4] );

		return $rgb;
	}

	$hex8_regexp = '/^#?([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/';
	if ( preg_match( $hex8_regexp, $color_str, $match ) ) {
		$rgb = wp_tinycolor_rgb_to_rgb(
			array(
				'r' => base_convert( $match[1], 16, 10 ),
				'g' => base_convert( $match[2], 16, 10 ),
				'b' => base_convert( $match[3], 16, 10 ),
			)
		);

		$rgb['a'] = _wp_tinycolor_bound_alpha(
			base_convert( $match[4], 16, 10 ) / 255
		);

		return $rgb;
	}

	$hex6_regexp = '/^#?([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/';
	if ( preg_match( $hex6_regexp, $color_str, $match ) ) {
		$rgb = wp_tinycolor_rgb_to_rgb(
			array(
				'r' => base_convert( $match[1], 16, 10 ),
				'g' => base_convert( $match[2], 16, 10 ),
				'b' => base_convert( $match[3], 16, 10 ),
			)
		);

		$rgb['a'] = 1;

		return $rgb;
	}

	$hex4_regexp = '/^#?([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})$/';
	if ( preg_match( $hex4_regexp, $color_str, $match ) ) {
		$rgb = wp_tinycolor_rgb_to_rgb(
			array(
				'r' => base_convert( $match[1] . $match[1], 16, 10 ),
				'g' => base_convert( $match[2] . $match[2], 16, 10 ),
				'b' => base_convert( $match[3] . $match[3], 16, 10 ),
			)
		);

		$rgb['a'] = _wp_tinycolor_bound_alpha(
			base_convert( $match[4] . $match[4], 16, 10 ) / 255
		);

		return $rgb;
	}

	$hex3_regexp = '/^#?([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})$/';
	if ( preg_match( $hex3_regexp, $color_str, $match ) ) {
		$rgb = wp_tinycolor_rgb_to_rgb(
			array(
				'r' => base_convert( $match[1] . $match[1], 16, 10 ),
				'g' => base_convert( $match[2] . $match[2], 16, 10 ),
				'b' => base_convert( $match[3] . $match[3], 16, 10 ),
			)
		);

		$rgb['a'] = 1;

		return $rgb;
	}

	/*
	 * The JS color picker considers the string "transparent" to be a hex value,
	 * so we need to handle it here as a special case.
	 */
	if ( 'transparent' === $color_str ) {
		return array(
			'r' => 0,
			'g' => 0,
			'b' => 0,
			'a' => 0,
		);
	}
}

/**
 * Returns the prefixed id for the duotone filter for use as a CSS id.
 *
 * @since 5.9.1
 * @deprecated 6.3.0
 *
 * @access private
 *
 * @param array $preset Duotone preset value as seen in theme.json.
 * @return string Duotone filter CSS id.
 */
function wp_get_duotone_filter_id( $preset ) {
	_deprecated_function( __FUNCTION__, '6.3.0' );
	return WP_Duotone::get_filter_id_from_preset( $preset );
}

/**
 * Returns the CSS filter property url to reference the rendered SVG.
 *
 * @since 5.9.0
 * @since 6.1.0 Allow unset for preset colors.
 * @deprecated 6.3.0
 *
 * @access private
 *
 * @param array $preset Duotone preset value as seen in theme.json.
 * @return string Duotone CSS filter property url value.
 */
function wp_get_duotone_filter_property( $preset ) {
	_deprecated_function( __FUNCTION__, '6.3.0' );
	return WP_Duotone::get_filter_css_property_value_from_preset( $preset );
}

/**
 * Returns the duotone filter SVG string for the preset.
 *
 * @since 5.9.1
 * @deprecated 6.3.0
 *
 * @access private
 *
 * @param array $preset Duotone preset value as seen in theme.json.
 * @return string Duotone SVG filter.
 */
function wp_get_duotone_filter_svg( $preset ) {
	_deprecated_function( __FUNCTION__, '6.3.0' );
	return WP_Duotone::get_filter_svg_from_preset( $preset );
}

/**
 * Registers the style and colors block attributes for block types that support it.
 *
 * @since 5.8.0
 * @deprecated 6.3.0 Use WP_Duotone::register_duotone_support() instead.
 *
 * @access private
 *
 * @param WP_Block_Type $block_type Block Type.
 */
function wp_register_duotone_support( $block_type ) {
	_deprecated_function( __FUNCTION__, '6.3.0', 'WP_Duotone::register_duotone_support()' );
	return WP_Duotone::register_duotone_support( $block_type );
}

/**
 * Renders out the duotone stylesheet and SVG.
 *
 * @since 5.8.0
 * @since 6.1.0 Allow unset for preset colors.
 * @deprecated 6.3.0 Use WP_Duotone::render_duotone_support() instead.
 *
 * @access private
 *
 * @param string $block_content Rendered block content.
 * @param array  $block         Block object.
 * @return string Filtered block content.
 */
function wp_render_duotone_support( $block_content, $block ) {
	_deprecated_function( __FUNCTION__, '6.3.0', 'WP_Duotone::render_duotone_support()' );
	$wp_block = new WP_Block( $block );
	return WP_Duotone::render_duotone_support( $block_content, $block, $wp_block );
}

/**
 * Returns a string containing the SVGs to be referenced as filters (duotone).
 *
 * @since 5.9.1
 * @deprecated 6.3.0 SVG generation is handled on a per-block basis in block supports.
 *
 * @return string
 */
function wp_get_global_styles_svg_filters() {
	_deprecated_function( __FUNCTION__, '6.3.0' );

	/*
	 * Ignore cache when the development mode is set to 'theme', so it doesn't interfere with the theme
	 * developer's workflow.
	 */
	$can_use_cached = ! wp_is_development_mode( 'theme' );
	$cache_group    = 'theme_json';
	$cache_key      = 'wp_get_global_styles_svg_filters';
	if ( $can_use_cached ) {
		$cached = wp_cache_get( $cache_key, $cache_group );
		if ( $cached ) {
			return $cached;
		}
	}

	$supports_theme_json = wp_theme_has_theme_json();

	$origins = array( 'default', 'theme', 'custom' );
	if ( ! $supports_theme_json ) {
		$origins = array( 'default' );
	}

	$tree = WP_Theme_JSON_Resolver::get_merged_data();
	$svgs = $tree->get_svg_filters( $origins );

	if ( $can_use_cached ) {
		wp_cache_set( $cache_key, $svgs, $cache_group );
	}

	return $svgs;
}

/**
 * Renders the SVG filters supplied by theme.json.
 *
 * Note that this doesn't render the per-block user-defined
 * filters which are handled by wp_render_duotone_support,
 * but it should be rendered before the filtered content
 * in the body to satisfy Safari's rendering quirks.
 *
 * @since 5.9.1
 * @deprecated 6.3.0 SVG generation is handled on a per-block basis in block supports.
 */
function wp_global_styles_render_svg_filters() {
	_deprecated_function( __FUNCTION__, '6.3.0' );

	/*
	 * When calling via the in_admin_header action, we only want to render the
	 * SVGs on block editor pages.
	 */
	if (
		is_admin() &&
		! get_current_screen()->is_block_editor()
	) {
		return;
	}

	$filters = wp_get_global_styles_svg_filters();
	if ( ! empty( $filters ) ) {
		echo $filters;
	}
}

/**
 * Build an array with CSS classes and inline styles defining the colors
 * which will be applied to the navigation markup in the front-end.
 *
 * @since 5.9.0
 * @deprecated 6.3.0 This was removed from the Navigation Submenu block in favour of `wp_apply_colors_support()`.
 *                   `wp_apply_colors_support()` returns an array with similar class and style values,
 *                   but with different keys: `class` and `style`.
 *
 * @param  array $context     Navigation block context.
 * @param  array $attributes  Block attributes.
 * @param  bool  $is_sub_menu Whether the block is a sub-menu.
 * @return array Colors CSS classes and inline styles.
 */
function block_core_navigation_submenu_build_css_colors( $context, $attributes, $is_sub_menu = false ) {
	_deprecated_function( __FUNCTION__, '6.3.0' );
	$colors = array(
		'css_classes'   => array(),
		'inline_styles' => '',
	);

	// Text color.
	$named_text_color  = null;
	$custom_text_color = null;

	if ( $is_sub_menu && array_key_exists( 'customOverlayTextColor', $context ) ) {
		$custom_text_color = $context['customOverlayTextColor'];
	} elseif ( $is_sub_menu && array_key_exists( 'overlayTextColor', $context ) ) {
		$named_text_color = $context['overlayTextColor'];
	} elseif ( array_key_exists( 'customTextColor', $context ) ) {
		$custom_text_color = $context['customTextColor'];
	} elseif ( array_key_exists( 'textColor', $context ) ) {
		$named_text_color = $context['textColor'];
	} elseif ( isset( $context['style']['color']['text'] ) ) {
		$custom_text_color = $context['style']['color']['text'];
	}

	// If has text color.
	if ( ! is_null( $named_text_color ) ) {
		// Add the color class.
		array_push( $colors['css_classes'], 'has-text-color', sprintf( 'has-%s-color', $named_text_color ) );
	} elseif ( ! is_null( $custom_text_color ) ) {
		// Add the custom color inline style.
		$colors['css_classes'][]  = 'has-text-color';
		$colors['inline_styles'] .= sprintf( 'color: %s;', $custom_text_color );
	}

	// Background color.
	$named_background_color  = null;
	$custom_background_color = null;

	if ( $is_sub_menu && array_key_exists( 'customOverlayBackgroundColor', $context ) ) {
		$custom_background_color = $context['customOverlayBackgroundColor'];
	} elseif ( $is_sub_menu && array_key_exists( 'overlayBackgroundColor', $context ) ) {
		$named_background_color = $context['overlayBackgroundColor'];
	} elseif ( array_key_exists( 'customBackgroundColor', $context ) ) {
		$custom_background_color = $context['customBackgroundColor'];
	} elseif ( array_key_exists( 'backgroundColor', $context ) ) {
		$named_background_color = $context['backgroundColor'];
	} elseif ( isset( $context['style']['color']['background'] ) ) {
		$custom_background_color = $context['style']['color']['background'];
	}

	// If has background color.
	if ( ! is_null( $named_background_color ) ) {
		// Add the background-color class.
		array_push( $colors['css_classes'], 'has-background', sprintf( 'has-%s-background-color', $named_background_color ) );
	} elseif ( ! is_null( $custom_background_color ) ) {
		// Add the custom background-color inline style.
		$colors['css_classes'][]  = 'has-background';
		$colors['inline_styles'] .= sprintf( 'background-color: %s;', $custom_background_color );
	}

	return $colors;
}

/**
 * Runs the theme.json webfonts handler.
 *
 * Using `WP_Theme_JSON_Resolver`, it gets the fonts defined
 * in the `theme.json` for the current selection and style
 * variations, validates the font-face properties, generates
 * the '@font-face' style declarations, and then enqueues the
 * styles for both the editor and front-end.
 *
 * Design Notes:
 * This is not a public API, but rather an internal handler.
 * A future public Webfonts API will replace this stopgap code.
 *
 * This code design is intentional.
 *    a. It hides the inner-workings.
 *    b. It does not expose API ins or outs for consumption.
 *    c. It only works with a theme's `theme.json`.
 *
 * Why?
 *    a. To avoid backwards-compatibility issues when
 *       the Webfonts API is introduced in Core.
 *    b. To make `fontFace` declarations in `theme.json` work.
 *
 * @link  https://github.com/WordPress/gutenberg/issues/40472
 *
 * @since 6.0.0
 * @deprecated 6.4.0 Use wp_print_font_faces() instead.
 * @access private
 */
function _wp_theme_json_webfonts_handler() {
	_deprecated_function( __FUNCTION__, '6.4.0', 'wp_print_font_faces' );

	// Block themes are unavailable during installation.
	if ( wp_installing() ) {
		return;
	}

	if ( ! wp_theme_has_theme_json() ) {
		return;
	}

	// Webfonts to be processed.
	$registered_webfonts = array();

	/**
	 * Gets the webfonts from theme.json.
	 *
	 * @since 6.0.0
	 *
	 * @return array Array of defined webfonts.
	 */
	$fn_get_webfonts_from_theme_json = static function() {
		// Get settings from theme.json.
		$settings = WP_Theme_JSON_Resolver::get_merged_data()->get_settings();

		// If in the editor, add webfonts defined in variations.
		if ( is_admin() || wp_is_rest_endpoint() ) {
			$variations = WP_Theme_JSON_Resolver::get_style_variations();
			foreach ( $variations as $variation ) {
				// Skip if fontFamilies are not defined in the variation.
				if ( empty( $variation['settings']['typography']['fontFamilies'] ) ) {
					continue;
				}

				// Initialize the array structure.
				if ( empty( $settings['typography'] ) ) {
					$settings['typography'] = array();
				}
				if ( empty( $settings['typography']['fontFamilies'] ) ) {
					$settings['typography']['fontFamilies'] = array();
				}
				if ( empty( $settings['typography']['fontFamilies']['theme'] ) ) {
					$settings['typography']['fontFamilies']['theme'] = array();
				}

				// Combine variations with settings. Remove duplicates.
				$settings['typography']['fontFamilies']['theme'] = array_merge( $settings['typography']['fontFamilies']['theme'], $variation['settings']['typography']['fontFamilies']['theme'] );
				$settings['typography']['fontFamilies']          = array_unique( $settings['typography']['fontFamilies'] );
			}
		}

		// Bail out early if there are no settings for webfonts.
		if ( empty( $settings['typography']['fontFamilies'] ) ) {
			return array();
		}

		$webfonts = array();

		// Look for fontFamilies.
		foreach ( $settings['typography']['fontFamilies'] as $font_families ) {
			foreach ( $font_families as $font_family ) {

				// Skip if fontFace is not defined.
				if ( empty( $font_family['fontFace'] ) ) {
					continue;
				}

				// Skip if fontFace is not an array of webfonts.
				if ( ! is_array( $font_family['fontFace'] ) ) {
					continue;
				}

				$webfonts = array_merge( $webfonts, $font_family['fontFace'] );
			}
		}

		return $webfonts;
	};

	/**
	 * Transforms each 'src' into an URI by replacing 'file:./'
	 * placeholder from theme.json.
	 *
	 * The absolute path to the webfont file(s) cannot be defined in
	 * theme.json. `file:./` is the placeholder which is replaced by
	 * the theme's URL path to the theme's root.
	 *
	 * @since 6.0.0
	 *
	 * @param array $src Webfont file(s) `src`.
	 * @return array Webfont's `src` in URI.
	 */
	$fn_transform_src_into_uri = static function( array $src ) {
		foreach ( $src as $key => $url ) {
			// Tweak the URL to be relative to the theme root.
			if ( ! str_starts_with( $url, 'file:./' ) ) {
				continue;
			}

			$src[ $key ] = get_theme_file_uri( str_replace( 'file:./', '', $url ) );
		}

		return $src;
	};

	/**
	 * Converts the font-face properties (i.e. keys) into kebab-case.
	 *
	 * @since 6.0.0
	 *
	 * @param array $font_face Font face to convert.
	 * @return array Font faces with each property in kebab-case format.
	 */
	$fn_convert_keys_to_kebab_case = static function( array $font_face ) {
		foreach ( $font_face as $property => $value ) {
			$kebab_case               = _wp_to_kebab_case( $property );
			$font_face[ $kebab_case ] = $value;
			if ( $kebab_case !== $property ) {
				unset( $font_face[ $property ] );
			}
		}

		return $font_face;
	};

	/**
	 * Validates a webfont.
	 *
	 * @since 6.0.0
	 *
	 * @param array $webfont The webfont arguments.
	 * @return array|false The validated webfont arguments, or false if the webfont is invalid.
	 */
	$fn_validate_webfont = static function( $webfont ) {
		$webfont = wp_parse_args(
				$webfont,
				array(
						'font-family'  => '',
						'font-style'   => 'normal',
						'font-weight'  => '400',
						'font-display' => 'fallback',
						'src'          => array(),
				)
		);

		// Check the font-family.
		if ( empty( $webfont['font-family'] ) || ! is_string( $webfont['font-family'] ) ) {
			trigger_error( __( 'Webfont font family must be a non-empty string.' ) );

			return false;
		}

		// Check that the `src` property is defined and a valid type.
		if ( empty( $webfont['src'] ) || ( ! is_string( $webfont['src'] ) && ! is_array( $webfont['src'] ) ) ) {
			trigger_error( __( 'Webfont src must be a non-empty string or an array of strings.' ) );

			return false;
		}

		// Validate the `src` property.
		foreach ( (array) $webfont['src'] as $src ) {
			if ( ! is_string( $src ) || '' === trim( $src ) ) {
				trigger_error( __( 'Each webfont src must be a non-empty string.' ) );

				return false;
			}
		}

		// Check the font-weight.
		if ( ! is_string( $webfont['font-weight'] ) && ! is_int( $webfont['font-weight'] ) ) {
			trigger_error( __( 'Webfont font weight must be a properly formatted string or integer.' ) );

			return false;
		}

		// Check the font-display.
		if ( ! in_array( $webfont['font-display'], array( 'auto', 'block', 'fallback', 'optional', 'swap' ), true ) ) {
			$webfont['font-display'] = 'fallback';
		}

		$valid_props = array(
				'ascend-override',
				'descend-override',
				'font-display',
				'font-family',
				'font-stretch',
				'font-style',
				'font-weight',
				'font-variant',
				'font-feature-settings',
				'font-variation-settings',
				'line-gap-override',
				'size-adjust',
				'src',
				'unicode-range',
		);

		foreach ( $webfont as $prop => $value ) {
			if ( ! in_array( $prop, $valid_props, true ) ) {
				unset( $webfont[ $prop ] );
			}
		}

		return $webfont;
	};

	/**
	 * Registers webfonts declared in theme.json.
	 *
	 * @since 6.0.0
	 *
	 * @uses $registered_webfonts To access and update the registered webfonts registry (passed by reference).
	 * @uses $fn_get_webfonts_from_theme_json To run the function that gets the webfonts from theme.json.
	 * @uses $fn_convert_keys_to_kebab_case To run the function that converts keys into kebab-case.
	 * @uses $fn_validate_webfont To run the function that validates each font-face (webfont) from theme.json.
	 */
	$fn_register_webfonts = static function() use ( &$registered_webfonts, $fn_get_webfonts_from_theme_json, $fn_convert_keys_to_kebab_case, $fn_validate_webfont, $fn_transform_src_into_uri ) {
		$registered_webfonts = array();

		foreach ( $fn_get_webfonts_from_theme_json() as $webfont ) {
			if ( ! is_array( $webfont ) ) {
				continue;
			}

			$webfont = $fn_convert_keys_to_kebab_case( $webfont );

			$webfont = $fn_validate_webfont( $webfont );

			$webfont['src'] = $fn_transform_src_into_uri( (array) $webfont['src'] );

			// Skip if not valid.
			if ( empty( $webfont ) ) {
				continue;
			}

			$registered_webfonts[] = $webfont;
		}
	};

	/**
	 * Orders 'src' items to optimize for browser support.
	 *
	 * @since 6.0.0
	 *
	 * @param array $webfont Webfont to process.
	 * @return array Ordered `src` items.
	 */
	$fn_order_src = static function( array $webfont ) {
		$src         = array();
		$src_ordered = array();

		foreach ( $webfont['src'] as $url ) {
			// Add data URIs first.
			if ( str_starts_with( trim( $url ), 'data:' ) ) {
				$src_ordered[] = array(
						'url'    => $url,
						'format' => 'data',
				);
				continue;
			}
			$format         = pathinfo( $url, PATHINFO_EXTENSION );
			$src[ $format ] = $url;
		}

		// Add woff2.
		if ( ! empty( $src['woff2'] ) ) {
			$src_ordered[] = array(
					'url'    => sanitize_url( $src['woff2'] ),
					'format' => 'woff2',
			);
		}

		// Add woff.
		if ( ! empty( $src['woff'] ) ) {
			$src_ordered[] = array(
					'url'    => sanitize_url( $src['woff'] ),
					'format' => 'woff',
			);
		}

		// Add ttf.
		if ( ! empty( $src['ttf'] ) ) {
			$src_ordered[] = array(
					'url'    => sanitize_url( $src['ttf'] ),
					'format' => 'truetype',
			);
		}

		// Add eot.
		if ( ! empty( $src['eot'] ) ) {
			$src_ordered[] = array(
					'url'    => sanitize_url( $src['eot'] ),
					'format' => 'embedded-opentype',
			);
		}

		// Add otf.
		if ( ! empty( $src['otf'] ) ) {
			$src_ordered[] = array(
					'url'    => sanitize_url( $src['otf'] ),
					'format' => 'opentype',
			);
		}
		$webfont['src'] = $src_ordered;

		return $webfont;
	};

	/**
	 * Compiles the 'src' into valid CSS.
	 *
	 * @since 6.0.0
	 * @since 6.2.0 Removed local() CSS.
	 *
	 * @param string $font_family Font family.
	 * @param array  $value       Value to process.
	 * @return string The CSS.
	 */
	$fn_compile_src = static function( $font_family, array $value ) {
		$src = '';

		foreach ( $value as $item ) {
			$src .= ( 'data' === $item['format'] )
					? ", url({$item['url']})"
					: ", url('{$item['url']}') format('{$item['format']}')";
		}

		$src = ltrim( $src, ', ' );

		return $src;
	};

	/**
	 * Compiles the font variation settings.
	 *
	 * @since 6.0.0
	 *
	 * @param array $font_variation_settings Array of font variation settings.
	 * @return string The CSS.
	 */
	$fn_compile_variations = static function( array $font_variation_settings ) {
		$variations = '';

		foreach ( $font_variation_settings as $key => $value ) {
			$variations .= "$key $value";
		}

		return $variations;
	};

	/**
	 * Builds the font-family's CSS.
	 *
	 * @since 6.0.0
	 *
	 * @uses $fn_compile_src To run the function that compiles the src.
	 * @uses $fn_compile_variations To run the function that compiles the variations.
	 *
	 * @param array $webfont Webfont to process.
	 * @return string This font-family's CSS.
	 */
	$fn_build_font_face_css = static function( array $webfont ) use ( $fn_compile_src, $fn_compile_variations ) {
		$css = '';

		// Wrap font-family in quotes if it contains spaces.
		if (
				str_contains( $webfont['font-family'], ' ' ) &&
				! str_contains( $webfont['font-family'], '"' ) &&
				! str_contains( $webfont['font-family'], "'" )
		) {
			$webfont['font-family'] = '"' . $webfont['font-family'] . '"';
		}

		foreach ( $webfont as $key => $value ) {
			/*
			 * Skip "provider", since it's for internal API use,
			 * and not a valid CSS property.
			 */
			if ( 'provider' === $key ) {
				continue;
			}

			// Compile the "src" parameter.
			if ( 'src' === $key ) {
				$value = $fn_compile_src( $webfont['font-family'], $value );
			}

			// If font-variation-settings is an array, convert it to a string.
			if ( 'font-variation-settings' === $key && is_array( $value ) ) {
				$value = $fn_compile_variations( $value );
			}

			if ( ! empty( $value ) ) {
				$css .= "$key:$value;";
			}
		}

		return $css;
	};

	/**
	 * Gets the '@font-face' CSS styles for locally-hosted font files.
	 *
	 * @since 6.0.0
	 *
	 * @uses $registered_webfonts To access and update the registered webfonts registry (passed by reference).
	 * @uses $fn_order_src To run the function that orders the src.
	 * @uses $fn_build_font_face_css To run the function that builds the font-face CSS.
	 *
	 * @return string The `@font-face` CSS.
	 */
	$fn_get_css = static function() use ( &$registered_webfonts, $fn_order_src, $fn_build_font_face_css ) {
		$css = '';

		foreach ( $registered_webfonts as $webfont ) {
			// Order the webfont's `src` items to optimize for browser support.
			$webfont = $fn_order_src( $webfont );

			// Build the @font-face CSS for this webfont.
			$css .= '@font-face{' . $fn_build_font_face_css( $webfont ) . '}';
		}

		return $css;
	};

	/**
	 * Generates and enqueues webfonts styles.
	 *
	 * @since 6.0.0
	 *
	 * @uses $fn_get_css To run the function that gets the CSS.
	 */
	$fn_generate_and_enqueue_styles = static function() use ( $fn_get_css ) {
		// Generate the styles.
		$styles = $fn_get_css();

		// Bail out if there are no styles to enqueue.
		if ( '' === $styles ) {
			return;
		}

		// Enqueue the stylesheet.
		wp_register_style( 'wp-webfonts', '' );
		wp_enqueue_style( 'wp-webfonts' );

		// Add the styles to the stylesheet.
		wp_add_inline_style( 'wp-webfonts', $styles );
	};

	/**
	 * Generates and enqueues editor styles.
	 *
	 * @since 6.0.0
	 *
	 * @uses $fn_get_css To run the function that gets the CSS.
	 */
	$fn_generate_and_enqueue_editor_styles = static function() use ( $fn_get_css ) {
		// Generate the styles.
		$styles = $fn_get_css();

		// Bail out if there are no styles to enqueue.
		if ( '' === $styles ) {
			return;
		}

		wp_add_inline_style( 'wp-block-library', $styles );
	};

	add_action( 'wp_loaded', $fn_register_webfonts );
	add_action( 'wp_enqueue_scripts', $fn_generate_and_enqueue_styles );
	add_action( 'admin_init', $fn_generate_and_enqueue_editor_styles );
}

/**
 * Prints the CSS in the embed iframe header.
 *
 * @since 4.4.0
 * @deprecated 6.4.0 Use wp_enqueue_embed_styles() instead.
 */
function print_embed_styles() {
	_deprecated_function( __FUNCTION__, '6.4.0', 'wp_enqueue_embed_styles' );

	$type_attr = current_theme_supports( 'html5', 'style' ) ? '' : ' type="text/css"';
	$suffix    = SCRIPT_DEBUG ? '' : '.min';
	?>
	<style<?php echo $type_attr; ?>>
		<?php echo file_get_contents( ABSPATH . WPINC . "/css/wp-embed-template$suffix.css" ); ?>
	</style>
	<?php
}

/**
 * Prints the important emoji-related styles.
 *
 * @since 4.2.0
 * @deprecated 6.4.0 Use wp_enqueue_emoji_styles() instead.
 */
function print_emoji_styles() {
	_deprecated_function( __FUNCTION__, '6.4.0', 'wp_enqueue_emoji_styles' );
	static $printed = false;

	if ( $printed ) {
		return;
	}

	$printed = true;

	$type_attr = current_theme_supports( 'html5', 'style' ) ? '' : ' type="text/css"';
	?>
	<style<?php echo $type_attr; ?>>
	img.wp-smiley,
	img.emoji {
		display: inline !important;
		border: none !important;
		box-shadow: none !important;
		height: 1em !important;
		width: 1em !important;
		margin: 0 0.07em !important;
		vertical-align: -0.1em !important;
		background: none !important;
		padding: 0 !important;
	}
	</style>
	<?php
}

/**
 * Prints style and scripts for the admin bar.
 *
 * @since 3.1.0
 * @deprecated 6.4.0 Use wp_enqueue_admin_bar_header_styles() instead.
 */
function wp_admin_bar_header() {
	_deprecated_function( __FUNCTION__, '6.4.0', 'wp_enqueue_admin_bar_header_styles' );
	$type_attr = current_theme_supports( 'html5', 'style' ) ? '' : ' type="text/css"';
	?>
	<style<?php echo $type_attr; ?> media="print">#wpadminbar { display:none; }</style>
	<?php
}

/**
 * Prints default admin bar callback.
 *
 * @since 3.1.0
 * @deprecated 6.4.0 Use wp_enqueue_admin_bar_bump_styles() instead.
 */
function _admin_bar_bump_cb() {
	_deprecated_function( __FUNCTION__, '6.4.0', 'wp_enqueue_admin_bar_bump_styles' );
	$type_attr = current_theme_supports( 'html5', 'style' ) ? '' : ' type="text/css"';
	?>
	<style<?php echo $type_attr; ?> media="screen">
	html { margin-top: 32px !important; }
	@media screen and ( max-width: 782px ) {
	  html { margin-top: 46px !important; }
	}
	</style>
	<?php
}

/**
 * Runs a remote HTTPS request to detect whether HTTPS supported, and stores potential errors.
 *
 * This internal function is called by a regular Cron hook to ensure HTTPS support is detected and maintained.
 *
 * @since 5.7.0
 * @deprecated 6.4.0 The `wp_update_https_detection_errors()` function is no longer used and has been replaced by
 *                   `wp_get_https_detection_errors()`. Previously the function was called by a regular Cron hook to
 *                    update the `https_detection_errors` option, but this is no longer necessary as the errors are
 *                    retrieved directly in Site Health and no longer used outside of Site Health.
 * @access private
 */
function wp_update_https_detection_errors() {
	_deprecated_function( __FUNCTION__, '6.4.0' );

	/**
	 * Short-circuits the process of detecting errors related to HTTPS support.
	 *
	 * Returning a `WP_Error` from the filter will effectively short-circuit the default logic of trying a remote
	 * request to the site over HTTPS, storing the errors array from the returned `WP_Error` instead.
	 *
	 * @since 5.7.0
	 * @deprecated 6.4.0 The `wp_update_https_detection_errors` filter is no longer used and has been replaced by `pre_wp_get_https_detection_errors`.
	 *
	 * @param null|WP_Error $pre Error object to short-circuit detection,
	 *                           or null to continue with the default behavior.
	 */
	$support_errors = apply_filters( 'pre_wp_update_https_detection_errors', null );
	if ( is_wp_error( $support_errors ) ) {
		update_option( 'https_detection_errors', $support_errors->errors );
		return;
	}

	$support_errors = wp_get_https_detection_errors();

	update_option( 'https_detection_errors', $support_errors );
}

/**
 * Adds `decoding` attribute to an `img` HTML tag.
 *
 * The `decoding` attribute allows developers to indicate whether the
 * browser can decode the image off the main thread (`async`), on the
 * main thread (`sync`) or as determined by the browser (`auto`).
 *
 * By default WordPress adds `decoding="async"` to images but developers
 * can use the {@see 'wp_img_tag_add_decoding_attr'} filter to modify this
 * to remove the attribute or set it to another accepted value.
 *
 * @since 6.1.0
 * @deprecated 6.4.0 Use wp_img_tag_add_loading_optimization_attrs() instead.
 * @see wp_img_tag_add_loading_optimization_attrs()
 *
 * @param string $image   The HTML `img` tag where the attribute should be added.
 * @param string $context Additional context to pass to the filters.
 * @return string Converted `img` tag with `decoding` attribute added.
 */
function wp_img_tag_add_decoding_attr( $image, $context ) {
	_deprecated_function( __FUNCTION__, '6.4.0', 'wp_img_tag_add_loading_optimization_attrs()' );

	/*
	 * Only apply the decoding attribute to images that have a src attribute that
	 * starts with a double quote, ensuring escaped JSON is also excluded.
	 */
	if ( ! str_contains( $image, ' src="' ) ) {
		return $image;
	}

	/** This action is documented in wp-includes/media.php */
	$value = apply_filters( 'wp_img_tag_add_decoding_attr', 'async', $image, $context );

	if ( in_array( $value, array( 'async', 'sync', 'auto' ), true ) ) {
		$image = str_replace( '<img ', '<img decoding="' . esc_attr( $value ) . '" ', $image );
	}

	return $image;
}

/**
 * Parses wp_template content and injects the active theme's
 * stylesheet as a theme attribute into each wp_template_part
 *
 * @since 5.9.0
 * @deprecated 6.4.0 Use traverse_and_serialize_blocks( parse_blocks( $template_content ), '_inject_theme_attribute_in_template_part_block' ) instead.
 * @access private
 *
 * @param string $template_content serialized wp_template content.
 * @return string Updated 'wp_template' content.
 */
function _inject_theme_attribute_in_block_template_content( $template_content ) {
	_deprecated_function(
		__FUNCTION__,
		'6.4.0',
		'traverse_and_serialize_blocks( parse_blocks( $template_content ), "_inject_theme_attribute_in_template_part_block" )'
	);

	$has_updated_content = false;
	$new_content         = '';
	$template_blocks     = parse_blocks( $template_content );

	$blocks = _flatten_blocks( $template_blocks );
	foreach ( $blocks as &$block ) {
		if (
			'core/template-part' === $block['blockName'] &&
			! isset( $block['attrs']['theme'] )
		) {
			$block['attrs']['theme'] = get_stylesheet();
			$has_updated_content     = true;
		}
	}

	if ( $has_updated_content ) {
		foreach ( $template_blocks as &$block ) {
			$new_content .= serialize_block( $block );
		}

		return $new_content;
	}

	return $template_content;
}

/**
 * Parses a block template and removes the theme attribute from each template part.
 *
 * @since 5.9.0
 * @deprecated 6.4.0 Use traverse_and_serialize_blocks( parse_blocks( $template_content ), '_remove_theme_attribute_from_template_part_block' ) instead.
 * @access private
 *
 * @param string $template_content Serialized block template content.
 * @return string Updated block template content.
 */
function _remove_theme_attribute_in_block_template_content( $template_content ) {
	_deprecated_function(
		__FUNCTION__,
		'6.4.0',
		'traverse_and_serialize_blocks( parse_blocks( $template_content ), "_remove_theme_attribute_from_template_part_block" )'
	);

	$has_updated_content = false;
	$new_content         = '';
	$template_blocks     = parse_blocks( $template_content );

	$blocks = _flatten_blocks( $template_blocks );
	foreach ( $blocks as $key => $block ) {
		if ( 'core/template-part' === $block['blockName'] && isset( $block['attrs']['theme'] ) ) {
			unset( $blocks[ $key ]['attrs']['theme'] );
			$has_updated_content = true;
		}
	}

	if ( ! $has_updated_content ) {
		return $template_content;
	}

	foreach ( $template_blocks as $block ) {
		$new_content .= serialize_block( $block );
	}

	return $new_content;
}

/**
 * Prints the skip-link script & styles.
 *
 * @since 5.8.0
 * @access private
 * @deprecated 6.4.0 Use wp_enqueue_block_template_skip_link() instead.
 *
 * @global string $_wp_current_template_content
 */
function the_block_template_skip_link() {
	_deprecated_function( __FUNCTION__, '6.4.0', 'wp_enqueue_block_template_skip_link()' );

	global $_wp_current_template_content;

	// Early exit if not a block theme.
	if ( ! current_theme_supports( 'block-templates' ) ) {
		return;
	}

	// Early exit if not a block template.
	if ( ! $_wp_current_template_content ) {
		return;
	}
	?>

	<?php
	/**
	 * Print the skip-link styles.
	 */
	?>
	<style id="skip-link-styles">
		.skip-link.screen-reader-text {
			border: 0;
			clip: rect(1px,1px,1px,1px);
			clip-path: inset(50%);
			height: 1px;
			margin: -1px;
			overflow: hidden;
			padding: 0;
			position: absolute !important;
			width: 1px;
			word-wrap: normal !important;
		}

		.skip-link.screen-reader-text:focus {
			background-color: #eee;
			clip: auto !important;
			clip-path: none;
			color: #444;
			display: block;
			font-size: 1em;
			height: auto;
			left: 5px;
			line-height: normal;
			padding: 15px 23px 14px;
			text-decoration: none;
			top: 5px;
			width: auto;
			z-index: 100000;
		}
	</style>
	<?php
	/**
	 * Print the skip-link script.
	 */
	?>
	<script>
	( function() {
		var skipLinkTarget = document.querySelector( 'main' ),
			sibling,
			skipLinkTargetID,
			skipLink;

		// Early exit if a skip-link target can't be located.
		if ( ! skipLinkTarget ) {
			return;
		}

		/*
		 * Get the site wrapper.
		 * The skip-link will be injected in the beginning of it.
		 */
		sibling = document.querySelector( '.wp-site-blocks' );

		// Early exit if the root element was not found.
		if ( ! sibling ) {
			return;
		}

		// Get the skip-link target's ID, and generate one if it doesn't exist.
		skipLinkTargetID = skipLinkTarget.id;
		if ( ! skipLinkTargetID ) {
			skipLinkTargetID = 'wp--skip-link--target';
			skipLinkTarget.id = skipLinkTargetID;
		}

		// Create the skip link.
		skipLink = document.createElement( 'a' );
		skipLink.classList.add( 'skip-link', 'screen-reader-text' );
		skipLink.href = '#' + skipLinkTargetID;
		skipLink.innerHTML = '<?php /* translators: Hidden accessibility text. */ esc_html_e( 'Skip to content' ); ?>';

		// Inject the skip link.
		sibling.parentElement.insertBefore( skipLink, sibling );
	}() );
	</script>
	<?php
}

/**
 * Ensure that the view script has the `wp-interactivity` dependency.
 *
 * @since 6.4.0
 * @deprecated 6.5.0
 *
 * @global WP_Scripts $wp_scripts
 */
function block_core_query_ensure_interactivity_dependency() {
	_deprecated_function( __FUNCTION__, '6.5.0', 'wp_register_script_module' );
	global $wp_scripts;
	if (
		isset( $wp_scripts->registered['wp-block-query-view'] ) &&
		! in_array( 'wp-interactivity', $wp_scripts->registered['wp-block-query-view']->deps, true )
	) {
		$wp_scripts->registered['wp-block-query-view']->deps[] = 'wp-interactivity';
	}
}

/**
 * Ensure that the view script has the `wp-interactivity` dependency.
 *
 * @since 6.4.0
 * @deprecated 6.5.0
 *
 * @global WP_Scripts $wp_scripts
 */
function block_core_file_ensure_interactivity_dependency() {
	_deprecated_function( __FUNCTION__, '6.5.0', 'wp_register_script_module' );
	global $wp_scripts;
	if (
		isset( $wp_scripts->registered['wp-block-file-view'] ) &&
		! in_array( 'wp-interactivity', $wp_scripts->registered['wp-block-file-view']->deps, true )
	) {
		$wp_scripts->registered['wp-block-file-view']->deps[] = 'wp-interactivity';
	}
}

/**
 * Ensures that the view script has the `wp-interactivity` dependency.
 *
 * @since 6.4.0
 * @deprecated 6.5.0
 *
 * @global WP_Scripts $wp_scripts
 */
function block_core_image_ensure_interactivity_dependency() {
	_deprecated_function( __FUNCTION__, '6.5.0', 'wp_register_script_module' );
	global $wp_scripts;
	if (
		isset( $wp_scripts->registered['wp-block-image-view'] ) &&
		! in_array( 'wp-interactivity', $wp_scripts->registered['wp-block-image-view']->deps, true )
	) {
		$wp_scripts->registered['wp-block-image-view']->deps[] = 'wp-interactivity';
	}
}

/**
 * Updates the block content with elements class names.
 *
 * @deprecated 6.6.0 Generation of element class name is handled via `render_block_data` filter.
 *
 * @since 5.8.0
 * @since 6.4.0 Added support for button and heading element styling.
 * @access private
 *
 * @param string $block_content Rendered block content.
 * @param array  $block         Block object.
 * @return string Filtered block content.
 */
function wp_render_elements_support( $block_content, $block ) {
	_deprecated_function( __FUNCTION__, '6.6.0', 'wp_render_elements_class_name' );
	return $block_content;
}
