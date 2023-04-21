<?php

/**
 * Plugin Name: My Great Recipes Plugin
 * Description: A cool recipes plugin that alters servings sizes and whatnot.
 * Version: 0.1
 * Author: KJ Roelke
 * Author URI: https://kjroelke.online
 * Requires at least: 6.2
 * Requires PHP: 8.0
 * Text Domain: kjr
 */


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */


$my_plugin = new KJR_Recipe();
class KJR_Recipe {
	function __construct() {
		add_action('init', array($this, 'init_plugin'));
		add_filter('allowed_block_types_all', array($this, 'allowed_block_types'), 10, 2);
	}
	function init_plugin() {
		$this->register_recipe_cpt();
		register_block_type(
			__DIR__ . '/build',
			array(
				'render_callback' => array($this, 'render')
			)
		);
	}
	private function register_recipe_cpt() {
		$labels = array(
			'name'                  => _x('Recipes', 'Post type general name', 'kjr'),
			'singular_name'         => _x('Recipe', 'Post type singular name', 'kjr'),
			'menu_name'             => _x('Recipes', 'Admin Menu text', 'kjr'),
			'name_admin_bar'        => _x('Recipe', 'Add New on Toolbar', 'kjr'),
			'add_new'               => __('Add New', 'kjr'),
			'add_new_item'          => __('Add New Recipe', 'kjr'),
			'new_item'              => __('New Recipe', 'kjr'),
			'edit_item'             => __('Edit Recipe', 'kjr'),
			'view_item'             => __('View Recipe', 'kjr'),
			'all_items'             => __('All Recipes', 'kjr'),
			'search_items'          => __('Search Recipes', 'kjr'),
			'parent_item_colon'     => __('Parent Recipes:', 'kjr'),
			'not_found'             => __('No Recipes found.', 'kjr'),
			'not_found_in_trash'    => __('No Recipes found in Trash.', 'kjr'),
			'featured_image'        => _x('Recipe Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'kjr'),
			'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'kjr'),
			'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'kjr'),
			'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'kjr'),
			'archives'              => _x('Recipe archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'kjr'),
			'insert_into_item'      => _x('Insert into Recipe', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'kjr'),
			'uploaded_to_this_item' => _x('Uploaded to this Recipe', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'kjr'),
			'filter_items_list'     => _x('Filter Recipes list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'kjr'),
			'items_list_navigation' => _x('Recipes list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'kjr'),
			'items_list'            => _x('Recipes list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'kjr'),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_rest'       => true,
			'menu_icon'			 => 'dashicons-food',
			'show_in_menu'       => true,
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 20,
			'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
		);
		register_post_type('recipes', $args);
	}
	function allowed_block_types($allowed_block_types, $block_editor_context) {
		$allowed_blocks = array(
			'core/heading',
			'core/paragraph',
			'core/image',
			'kjr/recipes'
		);
		return $block_editor_context->post->post_type === 'recipes' && true === $allowed_block_types ?
			$allowed_blocks : $allowed_block_types;
	}
	function render($attr) {
		ob_start();
		var_dump($attr); ?>
<p <?php echo get_block_wrapper_attributes(); ?>>
    <?php esc_html_e('Recipe – hello from a dynamic block!', 'kjr'); ?>
</p>
<?php return ob_get_clean();
	}
}