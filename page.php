<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php if (has_post_thumbnail()) : ?>
        <div class="hero-section mb-5">
            <img src="<?php the_post_thumbnail_url('hero-image'); ?>" class="img-fluid w-100" alt="<?php the_title_attribute(); ?>" fetchpriority=high>
        </div>
    <?php endif; ?>
<?php endwhile; endif; ?>

<main class="container mt-5" itemscope itemtype="https://schema.org/WebPage">
    <div class="row">
        <div class="col-md-12">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div <?php post_class(); ?> itemprop="mainEntity" itemscope itemtype="https://schema.org/CreativeWork">
                    <meta itemprop="name" content="<?php the_title_attribute(); ?>">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endwhile; else : ?>
                <p><?php esc_html_e('Sorry, no pages matched your criteria.', 'speedpress'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>

