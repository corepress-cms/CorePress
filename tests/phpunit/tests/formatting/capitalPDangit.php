<?php
// phpcs:disable WordPress.WP.CapitalPDangit.MisspelledInText -- 🙃

/**
 * @group formatting
 *
 * @covers ::capital_P_dangit
 */
class Tests_Formatting_CapitalPDangit extends WP_UnitTestCase {
	public function test_esc_attr_quotes() {
		global $wp_current_filter;
		$this->assertSame( 'Something about CorePress', capital_P_dangit( 'Something about Corepress' ) );
		$this->assertSame( 'Something about (CorePress', capital_P_dangit( 'Something about (Corepress' ) );
		$this->assertSame( 'Something about &#8216;CorePress', capital_P_dangit( 'Something about &#8216;Corepress' ) );
		$this->assertSame( 'Something about &#8220;CorePress', capital_P_dangit( 'Something about &#8220;Corepress' ) );
		$this->assertSame( 'Something about >CorePress', capital_P_dangit( 'Something about >Corepress' ) );
		$this->assertSame( 'Corepress', capital_P_dangit( 'Corepress' ) );

		$wp_current_filter = array( 'the_title' );
		$this->assertSame( 'CorePress', capital_P_dangit( 'Corepress' ) );
	}
}
