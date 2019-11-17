<?php
// silence is golden
// fake 403 error ;)

  header( 'HTTP/1.0 403 Forbidden' );
  header( 'Content-Type: application/json' );
echo json_encode(
	array(
		'code'    => 403,
		'message' => '403 access denied',
	)
);

  die;
