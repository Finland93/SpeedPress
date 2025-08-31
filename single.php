<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php if (has_post_thumbnail()) : ?>
        <div class="hero-section mb-5" itemscope itemtype="http://schema.org/ImageObject">
            <img src="<?php the_post_thumbnail_url('hero-image'); ?>" class="img-fluid w-100" alt="<?php the_title_attribute(); ?>" itemprop="url" fetchpriority=high>
            <meta itemprop="width" content="1200"> <!-- Add the correct width of your image -->
            <meta itemprop="height" content="675"> <!-- Add the correct height of your image -->
        </div>
    <?php endif; ?>
<?php endwhile; endif; ?>

<main class="container mt-5" itemscope itemtype="http://schema.org/Article">
    <link itemprop="url" href="<?php echo esc_url(get_permalink()); ?>">
    <div class="row">
        <div class="col-md-8">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?> itemprop="articleBody">
                    <header>
                        <h1 itemprop="headline"><?php the_title(); ?></h1>
                        <div class="entry-meta">
                            <time itemprop="datePublished" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                            <span itemprop="author" itemscope itemtype="http://schema.org/Person">
                                by <span itemprop="name"><?php the_author(); ?></span>
                            </span>
                        </div>
                    </header>
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

