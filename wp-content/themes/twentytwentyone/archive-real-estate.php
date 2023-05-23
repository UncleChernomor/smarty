<?php
get_header();
$description = get_the_archive_description();
?>
    <header class="page-header alignwide">
        <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
    </header><!-- .page-header -->
    <div class="real-estate__box">
    </div>
<?php
echo do_shortcode('[smarty-lab]');

get_footer();
?>

