<?php

class Test_API_Project extends WP_UnitTestCase {

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
	}

	public function test_projects() {
		wp_set_current_user( $this->subscriber );
		$request  = new \WP_REST_Request( 'GET', '/wp/v2/projects' );
		$response = $this->server->dispatch( $request );
		$this->assertEquals( 200, $response->get_status() );
	}

	public function test_project_fields() {
		$project = $this->factory->post->create(
			array(
				'post_type' => 'project',
			)
		);
		wp_set_current_user( $this->subscriber );

		$request  = new \WP_REST_Request( 'GET', "/wp/v2/projects/$project" );
		$response = $this->server->dispatch( $request );
		$this->assertEquals( 200, $response->get_status() );
		$data = $response->get_data();
		$this->assertArrayHasKey( 'yoast_meta', $data );
		$this->assertArrayHasKey( 'project_filters', $data );
		$this->assertArrayHasKey( 'featured_media_url', $data );
		$this->assertArrayHasKey( 'acf_meta', $data );
	}

}
