<?php
/**
 * Plugin name: Wp-galleries
 * Plugin URI: /wp-galleries
 * Description: Create Galleries posts and interate theme with SHORTCODE
 * Version: 1.0
 * Author: David Lorenz
 * Author URI: https://shop.weblorenz.com/
 */

 defined('ABSPATH') or die ('don\'t touch me...');


 include('gutenberg-gallery-block.php');


 // Gallery post type
function add_gallery_page() {
    $labels = array(
        'name'               => _x( 'Galleries', 'post type general name' ),
        'singular_name'      => _x( 'Gallery page', 'post type singular name' ),
        'add_new'            => _x( 'Add New Gallery', 'gallery' ),
        'add_new_item'       => __( 'Add New Gallery' ),
        'edit_item'          => __( 'Edit Gallery' ),
        'new_item'           => __( 'New Gallery' ),
        'all_items'          => __( 'All Galleries' ),
        'view_item'          => __( 'View Gallery Page' ),
        'search_items'       => __( 'Search Galleries' ),
        'not_found'          => __( 'No Gallery found' ),
        'not_found_in_trash' => __( 'No Gallery found in the Trash' ),
        'menu_name'          => 'Gallery',
        'title'	=> 'Gallery'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Gallery post type',
        'show_in_rest'	=> true,
        'public'        => true,
        'menu_position' => 2,
        'rewrite' => array( 
            'slug' => 'gallery', 
            'with_front' => false,
            'feeds' => false
        ),
        'supports'      => array( 'editor', 'thumbnail' ),
        //'capability_type' => 'gallery',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'can_export' => true,
        'show_ui' => true,

    );
    register_post_type( 'gallery', $args );

}
add_action( 'init', 'add_gallery_page' );


// create shortcode with parameters so that the user can define what's queried - default is to list all blog posts
function gallery_page_parameters_shortcode( $atts ) {
    ob_start();
 
    // define attributes and their defaults
    extract( shortcode_atts( array (
        'type' => 'gallery',
        'order' => 'date',
        'orderby' => 'title',
        'posts' => -1,
        'color' => '',
        'fabric' => '',
        'category' => '',
        'id' => '',
        'gallery_name' => ''

    ), $atts ) );
 
    // define query parameters based on attributes and paarams
    $options = array(
        'post_type' => $type,
        'order' => $order,
        'orderby' => $orderby,
        'posts_per_page' => $posts,
        'color' => $color,
        'fabric' => $fabric,
        'category_name' => $category,
        'id' => $id,
        'gallery_name' => $gallery_name
    );
    $query = new WP_Query( $options );
    if ( $query->have_posts() ) { 
        $post = get_post($id);
        ?>
        <div class="lorenz-gallery">
            <h2><?= $gallery_name ?></h2>
            <div class="gallery-zone">    
                <?= $post->post_content; ?>
            </div>
        </div>
    <?php
    $myvariable = ob_get_clean();
    return $myvariable;
    }
}
add_shortcode( 'gallery', 'gallery_page_parameters_shortcode' );

//Add styles
function add_assets() {
    wp_register_style('gallery_style', plugins_url('style.css',__FILE__ ));
    wp_enqueue_style('gallery_style');

    //wp_enqueue_script( 'caustom-gallery', plugins_url( 'block.js', __FILE__ ), array( 'wp-blocks' ) );
}
add_action( 'init', 'add_assets');

//Add custom thumbnails
add_theme_support( 'post-thumbnails' );
add_image_size( 'medium-gallery', 640, 480, TRUE );
add_image_size( 'small-gallery', 250, 250, TRUE );


add_filter( 'image_size_names_choose', 'my_custom_sizes' );
function my_custom_sizes( $sizes ) {
    global $post;

    if($post->post_type === 'gallery'){
        return array(
            'small-gallery' => __( 'Small gallery' ),
            'medium-gallery' => __( 'Medium gallery' )
        );
    }
    return $sizes;
}