<footer class="bg-dark pt-5 pb-3">
    <div class="container">
        <?php if (is_active_sidebar('footer-widget-area-1') || is_active_sidebar('footer-widget-area-2') || is_active_sidebar('footer-widget-area-3')) : ?>
            <div class="row">
                <?php if (is_active_sidebar('footer-widget-area-1')) : ?>
                    <div class="col-md-4">
                        <div class="footer-widgets text-white">
                            <?php dynamic_sidebar('footer-widget-area-1'); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-widget-area-2')) : ?>
                    <div class="col-md-4 text-white">
                        <div class="footer-widgets">
                            <?php dynamic_sidebar('footer-widget-area-2'); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-widget-area-3')) : ?>
                    <div class="col-md-4 text-white">
                        <div class="footer-widgets">
                            <?php dynamic_sidebar('footer-widget-area-3'); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="row mt-4">
            <div class="col-md-12 text-white text-center">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
<script>document.addEventListener('contextmenu', event => event.preventDefault());</script>
</body>
</html>
