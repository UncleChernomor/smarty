<?php get_header(); ?>
<div class="smarty-main">
<?php
/* Start the Loop */
while ( have_posts() ) :
    the_post();

    esc_html_e('Location:', '');
    $locations = get_the_terms(get_the_ID(), 'location');
    if (!is_wp_error($locations) && $locations !== false) {
        foreach ($locations as $current_location) {
            echo " " . esc_html__($current_location->name);
        }
    }
    echo "<hr>";
    the_content();
    echo "<hr>";
    $name = get_post_meta(get_the_ID(), 'name', true);
    $coords = get_post_meta(get_the_ID(), 'coords', true);
    $floor = get_post_meta(get_the_ID(), 'floor', true);
    $type = get_post_meta(get_the_ID(), 'type_building', true);
    // echo "<pre>";
    // var_dump($name);
    // echo "</pre>";
    ?>
    <div>
        <div>
            Name: <?= $name; ?>
        </div>
        <div>
            Coords: <?= $coords; ?>
        </div>
        <div>
            Count of floor: <?= $floor; ?>
        </div>
        <div>
            Type building: <?= $type; ?>
        </div>
    </div>
</div>
    <?php

    if ( is_attachment() ) {
        // Parent post navigation.
        the_post_navigation(
            array(
                /* translators: %s: Parent post link. */
                'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentytwentyone' ), '%title' ),
            )
        );
    }

    // If comments are open or there is at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) {
        comments_template();
    }

    // Previous/next post navigation.
    $twentytwentyone_next = is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' );
    $twentytwentyone_prev = is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' );

    $twentytwentyone_next_label     = esc_html__( 'Next post', 'twentytwentyone' );
    $twentytwentyone_previous_label = esc_html__( 'Previous post', 'twentytwentyone' );

    the_post_navigation(
        array(
            'next_text' => '<p class="meta-nav">' . $twentytwentyone_next_label . $twentytwentyone_next . '</p><p class="post-title">%title</p>',
            'prev_text' => '<p class="meta-nav">' . $twentytwentyone_prev . $twentytwentyone_previous_label . '</p><p class="post-title">%title</p>',
        )
    );
endwhile; // End of the loop.

get_footer();