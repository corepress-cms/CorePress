<?php
/**
 * Multisite: Deprecated admin functions from past versions and WordPress MU
 *
 * These functions should not be used and will be removed in a later version.
 * It is suggested to use for the alternatives instead when available.
 *
 * @package WordPress
 * @subpackage Deprecated
 * @since 3.0.0
 */


if ( ! function_exists( 'install_global_terms' ) ) :
	/**
	 * Install global terms.
	 *
	 * @since 3.0.0
	 * @since 6.1.0 This function no longer does anything.
	 * @deprecated 6.1.0
	 */
	function install_global_terms() {
		_deprecated_function( __FUNCTION__, '6.1.0' );
	}
endif;

/**
 * Synchronizes category and post tag slugs when global terms are enabled.
 *
 * @since 3.0.0
 * @since 6.1.0 This function no longer does anything.
 * @deprecated 6.1.0
 *
 * @param WP_Term|array $term     The term.
 * @param string        $taxonomy The taxonomy for `$term`.
 * @return WP_Term|array Always returns `$term`.
 */
function sync_category_tag_slugs( $term, $taxonomy ) {
	_deprecated_function( __FUNCTION__, '6.1.0' );

	return $term;
}
