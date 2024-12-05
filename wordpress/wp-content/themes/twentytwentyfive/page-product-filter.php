<?php
get_header();
?>

<div class="product-filter">
    <h1>Фильтр товаров</h1>
    <form id="product_filter_form" method="GET" action="">
        <div class="filter">
            <label for="color">Цвет:</label>
            <select name="color" id="color">
                <option value="">Выберите цвет</option>
                <?php

                $colors = get_terms(array(
                    'taxonomy' => 'pa_color',
                    'hide_empty' => true, 
                ));

                foreach ($colors as $color) {
                    echo '<option value="' . esc_attr($color->slug) . '" ' . selected( isset($_GET['color']) && $_GET['color'] == $color->slug, true, false ) . '>' . esc_html($color->name) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="filter">
            <label for="size">Размер:</label>
            <select name="size" id="size">
                <option value="">Выберите размер</option>
                <?php

                $sizes = get_terms(array(
                    'taxonomy' => 'pa_size',
                    'hide_empty' => true, 
                ));

                foreach ($sizes as $size) {
                    echo '<option value="' . esc_attr($size->slug) . '" ' . selected( isset($_GET['size']) && $_GET['size'] == $size->slug, true, false ) . '>' . esc_html($size->name) . '</option>';
                }
                ?>
            </select>
        </div>

        <button type="submit">Применить фильтр</button>
    </form>

    <div class="product-list">
        <?php

        $color = isset($_GET['color']) ? sanitize_text_field($_GET['color']) : '';
        $size = isset($_GET['size']) ? sanitize_text_field($_GET['size']) : '';

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'tax_query' => array(
                'relation' => 'AND',
            ),
        );

        if ($color) {
            $args['tax_query'][] = array(
                'taxonomy' => 'pa_color',
                'field' => 'slug',
                'terms' => $color, 
                'operator' => 'IN', 
            );
        }

        if ($size) {
            $args['tax_query'][] = array(
                'taxonomy' => 'pa_size',
                'field' => 'slug', 
                'terms' => $size,     
                'operator' => 'IN',    
            );
        }

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <div class="product-item">
                    <h2><?php the_title(); ?></h2>
                    <p><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>">Подробнее</a>
                </div>
                <?php
            }
        } else {
            echo '<p>Товары не найдены.</p>';
        }

        wp_reset_postdata();
        ?>
    </div>
</div>

<?php
get_footer();
?>
