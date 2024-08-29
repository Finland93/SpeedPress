<?php get_header(); ?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <header class="page-header mb-4">
                <h1 class="page-title">
                    <?php
                    if (have_posts()) :
                        printf('Search Results for: %s', get_search_query());
                    else :
                        echo 'No results found';
                    endif;
                    ?>
                </h1>
            </header>
            
            <?php
            // Start the loop for search results
            if (have_posts()) :
                while (have_posts()) : the_post(); ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="position-relative">
                                    <a href="<?php the_permalink(); ?>">
                                        <img width="388" height="221" src="<?php the_post_thumbnail_url('archive-banner'); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>">
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
                <?php endwhile;
            else :
                ?>
                <p><?php esc_html_e('Sorry, no posts matched your criteria.', 'speedpress'); ?></p>
            <?php endif; ?>

            <?php
            // Pagination
            the_posts_pagination(array(
                'prev_text' => '&laquo; ' . esc_html__('Previous', 'speedpress'),
                'next_text' => esc_html__('Next', 'speedpress') . ' &raquo;',
            ));
            ?>
        </div>

        <div class="col-md-4">
            <div class="sidebar">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
