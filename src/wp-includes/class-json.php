<?php
_deprecated_file( basename( __FILE__ ), '5.3.0', '', 'The PHP native JSON extension is now a requirement.' );

// Check if backwards_compat_json() is defined by the drop-in.
if ( file_exists( WP_CONTENT_DIR . '/backwards-compat.php' ) && function_exists( 'backwards_compat_json' ) ) {
    backwards_compat_json();
    return;
} else {
    // Print a warning and bail.
    _doing_it_wrong( basename( __FILE__ ), 'Without the backwards-compatibility drop-in, plugins can\'t use WP\'s deprecated JSON functions anymore.', '6.4.0' );
}
