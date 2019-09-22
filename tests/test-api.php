<?php

class Test_API extends WP_UnitTestCase {

	/**
	 * Test REST Server.
	 *
	 * @var WP_REST_Server
	 */
	protected $server;

	protected $routes = array(
		'/wp/v2/theme-settings',
		'/wp/v2/posts',
		'/wp/v2/pages',
		'/wp/v2/projects',
	);

	public function setUp() {
		parent::setUp();
		/* @var WP_REST_Server $wp_rest_server */
		global $wp_rest_server;
		$this->server = $wp_rest_server = new \WP_REST_Server();
		do_action( 'rest_api_init' );
	}

	public function test_register_routes() {
		$wp_routes = $this->server->get_routes();
		foreach ( $this->routes as $route ) {
			$this->assertArrayHasKey( $route, $wp_routes );
		}
	}

	public function test_endpoints() {
		$wp_routes = $this->server->get_routes();
		foreach ( $this->routes as $the_route ) {
			foreach ( $wp_routes as $route => $route_config ) {
				if ( $the_route === $route ) {
					$this->assertTrue( is_array( $route_config ) );
					foreach ( $route_config as $i => $endpoint ) {
						$this->assertTrue( is_array( $endpoint ) );
						$this->assertArrayHasKey( 'callback', $endpoint );
						if ( is_array( $endpoint['callback'] ) ) {
							$this->assertArrayHasKey( 0, $endpoint['callback'], get_class( $this ) );
							$this->assertArrayHasKey( 1, $endpoint['callback'], get_class( $this ) );
							$this->assertTrue( is_callable( array( $endpoint['callback'][0], $endpoint['callback'][1] ) ) );
						} else {
							$this->assertTrue( is_callable( $endpoint['callback'] ) );
						}
					}
				}
			}
		}
	}

	public function test_theme_settings() {
		wp_set_current_user( $this->subscriber );
		$request  = new \WP_REST_Request( 'GET', '/wp/v2/theme-settings' );
		$response = $this->server->dispatch( $request );
		$this->assertEquals( 200, $response->get_status() );
		$data = $response->get_data();
		$this->assertArrayHasKey( 'social', $data );
		$this->assertArrayHasKey( 'page', $data );
	}
}
