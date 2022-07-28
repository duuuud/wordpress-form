<?php

//Show only Gallery Block
function wpdocs_allowed_block_types( $allowed_block_types, $post ) {
	if ( $post->post_type === 'gallery' ) {
		return array('core/gallery');
	}
	return $allowed_block_types;
}
add_filter( 'allowed_block_types', 'wpdocs_allowed_block_types', 10, 2 );


//add column to dashboard table
function new_contact_methods( $contactmethods ) {
	global $post;
	if($post->post_type === 'gallery'){
		$contactmethods['short_code'] = 'Short code';
	}
	return $contactmethods;
}

function new_modify_user_table( $column ) {
	global $post;
	if($post->post_type === 'gallery'){
		$column['short_code'] = 'Short code';
	}
	return $column;
}

function new_modify_user_table_row( $val, $post_id) {
	global $post;

	switch ($val) {
		case 'short_code' :
			if($post->post_type === 'gallery'){
				echo '[gallery id='.$post_id.' gallery_name="gallery name" gallery_size="gallery_size"]';
			}
		default:
	}
	return $val;
}

add_filter( 'manage_posts_columns', 'new_modify_user_table' );
add_filter( 'user_contactmethods', 'new_contact_methods', 10, 1 );
add_filter( 'manage_posts_custom_column', 'new_modify_user_table_row', 10, 3 );	