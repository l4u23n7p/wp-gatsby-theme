<?php

class Test_API_Post extends WP_UnitTestCase {

	/**
	 * Test REST Server.
	 *
	 * @var WP_REST_Server
	 */
	protected $server;

	public function setUp() {
		parent::setUp();
		/* @var WP_REST_Server $wp_rest_server */
		global $wp_rest_server;
		$this->server = $wp_rest_server = new \WP_REST_Server();
		do_action( 'rest_api_init' );
		$this->posts = $this->factory->post->create_many( 10 );
	}

	public function test_posts() {
		wp_set_current_user( $this->subscriber );
		$request  = new \WP_REST_Request( 'GET', '/wp/v2/posts' );
		$response = $this->server->dispatch( $request );
		$this->assertEquals( 200, $response->get_status() );
	}

	public function test_post_fields() {
		wp_set_current_user( $this->subscriber );

		foreach ( $this->posts as $post_id ) {
			$request  = new \WP_REST_Request( 'GET', "/wp/v2/posts/$post_id" );
			$response = $this->server->dispatch( $request );
			$this->assertEquals( 200, $response->get_status() );
			$data = $response->get_data();
			$this->assertArrayHasKey( 'yoast_meta', $data );
			$this->assertArrayHasKey( 'post_categories', $data );
			$this->assertArrayHasKey( 'featured_media_url', $data );
			$this->assertArrayHasKey( 'author_meta', $data );
		}
	}
}
