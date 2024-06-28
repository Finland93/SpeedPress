<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php if (has_post_thumbnail()) : ?>
        <div class="hero-section mb-5">
            <img src="<?php the_post_thumbnail_url('large'); ?>" class="img-fluid w-100" alt="<?php the_title_attribute(); ?>">
        </div>
    <?php endif; ?>
<?php endwhile; endif; ?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>

                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            <?php endwhile; else : ?>
                <p><?php esc_html_e('Sorry, no posts matched your criteria.', 'speedpress'); ?></p>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <aside class="sidebar">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>
</main>

<?php get_footer(); ?>
