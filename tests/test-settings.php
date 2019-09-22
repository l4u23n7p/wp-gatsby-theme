<?php

class Test_Settings extends WP_UnitTestCase {

	private $email_regexp = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

	public function test_validate_page() {
		$page_id = self::factory()->post->create(
			array(
				'post_type' => 'page',
			)
		);
		$values  = array(
			'valid'      => $page_id,
			'empty'      => '',
			'invalid'    => 13337,
			'null'       => null,
			'array'      => array(),
			'string'     => 'not an integer',
			'hex'        => '0x6e0x6f0x740x200x610x6e0x200x690x6e0x740x650x720x670x650x72',
			'bool'       => true,
			'tag_script' => '<script>alert(1)</script>xss@example.com',
			'tag_img'    => '<img onerror="alert(1)" alt="noimg" src=""/>xss@example.com',
		);

		foreach ( $values as $test => $test_value ) {
			$test_result = wp_gatsby_theme_validate_page( $test_value, '' );
			if ( $test === 'valid' ) {
				$this->assertIsInt( $test_result );
				$this->assertEquals( $test_result, $test_value );
			} elseif ( $test === 'empty' ) {
				$this->assertEquals( $test_result, $test_value );
			} else {
				$this->assertIsNotInt( $test_result );
				$this->assertEquals( $test_result, '' );
			}
		}
	}

	public function test_validate_email() {
		$values = array(
			'valid'      => 'test@example.com',
			'string'     => 'iamnotvalid',
			'tag_script' => '<script>alert(1)</script>xss@example.com',
			'tag_img'    => '<img onerror="alert(1)" alt="noimg" src=""/>xss@example.com',
			'int'        => 333,
			'array'      => array(),
			'bool'       => true,
			'null'       => null,
		);

		foreach ( $values as $test => $test_value ) {
			$test_result = wp_gatsby_theme_validate_email( $test_value, '' );
			if ( $test === 'valid' ) {
				$this->assertEquals( $test_result, $test_value );
				$this->assertRegExp( $this->email_regexp, $test_result );
			} else {
				$this->assertNull( $test_result );
			}
		}

		$nullable_result = wp_gatsby_theme_validate_email( '', '', null, true );
		$this->assertEquals( $nullable_result, '' );
	}

	public function test_validate_url() {
		$values = array(
			'valid'      => 'https://example.com',
			'not_valid'  => 'http://.com',
			'string'     => 'iamnotvalid',
			// 'xss' => 'javascript://comment%0Aalert(1)',
			'tag_script' => '<script>alert(1)</script>https://example.com',
			'tag_img'    => '<img onerror="alert(1)" alt="noimg" src=""/>https://example.com',
			'int'        => 333,
			'array'      => array(),
			'bool'       => true,
			'null'       => null,
		);

		foreach ( $values as $test => $test_value ) {
			$test_result = wp_gatsby_theme_validate_url( $test_value, '' );
			if ( $test === 'valid' ) {
				$this->assertEquals( $test_result, $test_value );
			} else {
				$this->assertNull( $test_result );
			}
		}

		$nullable_result = wp_gatsby_theme_validate_url( '', '', null, true );
		$this->assertEquals( $nullable_result, '' );
	}

	public function test_validate_boolean() {
		$values = array(
			'valid'      => 0,
			'valid_2'    => 1,
			'not_valid'  => 333,
			'string'     => 'iamnotvalid',
			'xss'        => 'javascript://comment%0Aalert(1)',
			'tag_script' => '<script>alert(1)</script>0',
			'tag_img'    => '<img onerror="alert(1)" alt="noimg" src=""/>1',
			'int'        => 333,
			'array'      => array(),
			'bool'       => true,
			'null'       => null,
		);

		foreach ( $values as $test => $test_value ) {
			$test_result = wp_gatsby_theme_validate_boolean( $test_value );
			if ( $test === 'valid' || $test === 'valid_2' ) {
				$this->assertEquals( $test_result, $test_value );
			} else {
				$this->assertEquals( $test_result, 0 );
			}
		}
	}

	public function test_validate_jwt_expire() {
		$values = array(
			'valid'      => '7d15H20m',
			'valid_trim' => '  7D15h20M  ',
			'not_valid'  => '15W3Y2H5M230',
			'string'     => 'iamnotvalid',
			'xss'        => 'javascript://comment%0Aalert(1)',
			'tag_script' => '<script>alert(1)</script>0',
			'tag_img'    => '<img onerror="alert(1)" alt="noimg" src=""/>1',
			'int'        => 333,
			'array'      => array(),
			'bool'       => true,
			'null'       => null,
		);

		foreach ( $values as $test => $test_value ) {
			$test_result = wp_gatsby_theme_validate_jwt_expire( $test_value );
			if ( $test === 'valid' ) {
				$this->assertEquals( $test_result, strtoupper( $test_value ) );
			} elseif ( $test === 'valid_trim' ) {
				$this->assertEquals( $test_result, strtoupper( trim( $test_value ) ) );
			} else {
				$this->assertNull( $test_result );
			}
		}
	}
}
