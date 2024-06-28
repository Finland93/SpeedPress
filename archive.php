<?php get_header(); ?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <header class="page-header mb-4">
                <h1 class="page-title">
                    <?php
                    if (is_category()) {
                        single_cat_title();
                    } elseif (is_tag()) {
                        single_tag_title();
                    } elseif (is_author()) {
                        the_post();
                        echo 'Author Archives: ' . get_the_author();
                        rewind_posts();
                    } elseif (is_day()) {
                        echo 'Daily Archives: ' . get_the_date();
                    } elseif (is_month()) {
                        echo 'Monthly Archives: ' . get_the_date('F Y');
                    } elseif (is_year()) {
                        echo 'Yearly Archives: ' . get_the_date('Y');
                    } else {
                        echo 'Archives';
                    }
                    ?>
                </h1>
                <?php if (is_category() || is_tag() || is_author() || is_day() || is_month() || is_year()) : ?>
                    <div class="archive-description"><?php echo term_description(); ?></div>
                <?php endif; ?>
            </header>
            <div class="row">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="position-relative">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'custom-size', false, array('class' => 'card-img-top')); ?>
                                    </a>
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo '<span class="badge bg-primary position-absolute top-0 start-0 m-2">' . esc_html($categories[0]->name) . '</span>';
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            <div class="bg-dark text-white p-2">
                                <?php echo get_the_date(); ?>
                            </div>
                            <div class="card-body">
                                <h2 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <?php
            // Pagination
            the_posts_pagination(array(
                'prev_text' => '&laquo; ' . esc_html__('Previous', 'speedpress'),
                'next_text' => esc_html__('Next', 'speedpress') . ' &raquo;',
            ));
            ?>

        <?php else : ?>
            <p><?php esc_html_e('Sorry, no posts matched your criteria.', 'speedpress'); ?></p>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="sidebar">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
</main>

<?php get_footer(); ?>
