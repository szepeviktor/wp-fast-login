<?php

namespace salcode\fastLogin;

add_action( 'login_form', __NAMESPACE__ . '\login_form' );
add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\enqueue_scripts' );

function enqueue_scripts() {
	wp_enqueue_script(
		'wp-fast-login',
		plugins_url( 'js/wp-fast-login.js', __FILE__ ),
		[],
		'0.1.0'
	);
}

function login_form() {
	$args = [
		'number' => 100,
		'role' => 'Administrator',
	];
	$user_query = new \WP_User_Query( $args );
?>
<div>
	<label for="fast-login">Choose account to fast login</label><br>
	<select
		id="fast-login"
	>
		<option default value="">Select a User</option>
		<?php
			printUserOptionTags( [
				'number' => 100,
				'role' => 'Administrator'
			]);

			printUserOptionTags( [
				'number' => 100,
				'role__not_in' => [ 'Administrator' ]
			]);
		?>
	</select>
	<br><br>
</div>
<?php
}

function printUserOptionTags( $args ) {
	$user_query = new \WP_User_Query( $args );
	foreach ( $user_query->get_results() as $user ) {
		printf(
			'<option value="%d">%s</option>',
			$user->id,
			$user->display_name
		);
	}
}
