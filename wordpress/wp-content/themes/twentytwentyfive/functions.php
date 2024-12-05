<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( get_parent_theme_file_uri( 'assets/css/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since
	 *
	 * @return string|void
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;


function create_product_attributes_taxonomy() {

    $labels = array(
        'name'              => 'Цвет',
        'singular_name'     => 'Цвет',
        'search_items'      => 'Искать по цвету',
        'all_items'         => 'Все цвета',
        'edit_item'         => 'Редактировать цвет',
        'update_item'       => 'Обновить цвет',
        'add_new_item'      => 'Добавить новый цвет',
        'new_item_name'     => 'Название нового цвета',
        'menu_name'         => 'Цвет',
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'color'),
    );

    register_taxonomy('pa_color', array('product'), $args);

    // Таксономия для размера
    $labels = array(
        'name'              => 'Размер',
        'singular_name'     => 'Размер',
        'search_items'      => 'Искать по размеру',
        'all_items'         => 'Все размеры',
        'edit_item'         => 'Редактировать размер',
        'update_item'       => 'Обновить размер',
        'add_new_item'      => 'Добавить новый размер',
        'new_item_name'     => 'Название нового размера',
        'menu_name'         => 'Размер',
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'size'),
    );

    register_taxonomy('pa_size', array('product'), $args);
}
add_action('init', 'create_product_attributes_taxonomy');

function create_product_post_type() {
    $labels = array(
        'name'               => 'Products',
        'singular_name'      => 'Product',
        'menu_name'          => 'Products',
        'name_admin_bar'     => 'Product',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Product',
        'new_item'           => 'New Product',
        'edit_item'          => 'Edit Product',
        'view_item'          => 'View Product',
        'all_items'          => 'All Products',
        'search_items'       => 'Search Products',
        'parent_item_colon'  => 'Parent Products:',
        'not_found'          => 'No products found.',
        'not_found_in_trash' => 'No products found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'hierarchical'       => false,
        'show_in_rest'       => true,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'taxonomies'         => array('pa_color', 'pa_size'),
        'rewrite'            => array('slug' => 'product'),
    );

    register_post_type('product', $args);
}
add_action('init', 'create_product_post_type');

function filter_products_by_multiple_attributes($query) {
    if (is_post_type_archive('product') && !is_admin() && $query->is_main_query()) {
        $tax_queries = array();

        if (isset($_GET['color']) && !empty($_GET['color'])) {
            $tax_queries[] = array(
                'taxonomy' => 'pa_color',
                'field'    => 'slug',
                'terms'    => $_GET['color'],
                'operator' => 'IN',
            );
        }

        if (isset($_GET['size']) && !empty($_GET['size'])) {
            $tax_queries[] = array(
                'taxonomy' => 'pa_size',
                'field'    => 'slug',
                'terms'    => $_GET['size'],
                'operator' => 'IN',
            );
        }

        if (!empty($tax_queries)) {
            $query->set('tax_query', array(
                'relation' => 'AND',
                $tax_queries,
            ));
        }
    }
}

add_action('pre_get_posts', 'filter_products_by_multiple_attributes');

function display_attribute_filters() {
    if (is_post_type_archive('product')) {
        $colors = get_terms(array(
            'taxonomy' => 'pa_color', 
            'hide_empty' => true,
        ));

        $sizes = get_terms(array(
            'taxonomy' => 'pa_size',
            'hide_empty' => true,
        ));

        echo '<form method="GET" action="' . esc_url(home_url('/')) . '">';
        echo '<div class="attribute-filter">';
        echo '<label for="color">Цвет:</label>';
        echo '<select name="color" id="color">';
        echo '<option value="">Выберите цвет</option>';
        foreach ($colors as $color) {
            echo '<option value="' . $color->slug . '" ' . selected( isset($_GET['color']) && $_GET['color'] == $color->slug, true, false ) . '>' . $color->name . '</option>';
        }
        echo '</select>';
        echo '</div>';

        echo '<div class="attribute-filter">';
        echo '<label for="size">Размер:</label>';
        echo '<select name="size" id="size">';
        echo '<option value="">Выберите размер</option>';
        foreach ($sizes as $size) {
            echo '<option value="' . $size->slug . '" ' . selected( isset($_GET['size']) && $_GET['size'] == $size->slug, true, false ) . '>' . $size->name . '</option>';
        }
        echo '</select>';
        echo '</div>';

        echo '<button type="submit">Фильтровать</button>';
        echo '</form>';
    }
}
add_action('woocommerce_before_shop_loop', 'display_attribute_filters', 10);
