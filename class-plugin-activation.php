<?php
if (!class_exists('Plugin_Activation')) {
    class Plugin_Activation {

        private $plugins;

        public function __construct() {
            add_action('admin_menu', array($this, 'add_admin_menu'));
            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_notices', array($this, 'admin_notices'));
        }

        public function add_plugins($plugins) {
            $this->plugins = $plugins;
        }

        public function add_admin_menu() {
            add_menu_page(
                'Plugin Activation',
                'Plugin Activation',
                'manage_options',
                'plugin-activation',
                array($this, 'create_admin_page'),
                'dashicons-admin-plugins',
                99
            );
        }

        public function create_admin_page() {
            ?>
            <div class="wrap">
                <h1><?php esc_html_e('Required Plugins', 'speedpress'); ?></h1>
                <form method="post" action="options.php">
                    <?php settings_fields('plugin-activation-group'); ?>
                    <?php do_settings_sections('plugin-activation'); ?>
                    <?php submit_button(); ?>
                </form>
            </div>
            <?php
        }

        public function admin_init() {
            register_setting(
                'plugin-activation-group',
                'plugin_activation_settings'
            );

            add_settings_section(
                'plugin-activation-section',
                __('Install Required Plugins', 'speedpress'),
                array($this, 'section_info'),
                'plugin-activation'
            );

            foreach ($this->plugins as $plugin) {
                add_settings_field(
                    $plugin['slug'],
                    $plugin['name'],
                    array($this, 'plugin_field_callback'),
                    'plugin-activation',
                    'plugin-activation-section',
                    array(
                        'slug' => $plugin['slug'],
                        'required' => $plugin['required'],
                    )
                );
            }
        }

        public function section_info() {
            echo __('The following plugins are required for this theme. Please install and activate them.', 'speedpress');
        }

        public function plugin_field_callback($args) {
            $slug = $args['slug'];
            $plugin_path = $slug . '/' . $slug . '.php';
            $is_installed = file_exists(WP_PLUGIN_DIR . '/' . $plugin_path);
            $is_active = is_plugin_active($plugin_path);
            $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $slug), 'install-plugin_' . $slug);
            $activate_url = wp_nonce_url(self_admin_url('plugins.php?action=activate&plugin=' . $plugin_path), 'activate-plugin_' . $plugin_path);

            if (!$is_installed) {
                echo '<a href="' . esc_url($install_url) . '" class="button">' . __('Install', 'speedpress') . '</a>';
            } elseif (!$is_active) {
                echo '<a href="' . esc_url($activate_url) . '" class="button">' . __('Activate', 'speedpress') . '</a>';
            } else {
                echo '<span class="button disabled">' . __('Active', 'speedpress') . '</span>';
            }
        }

        public function admin_notices() {
            foreach ($this->plugins as $plugin) {
                $plugin_path = $plugin['slug'] . '/' . $plugin['slug'] . '.php';
                if (!is_plugin_active($plugin_path)) {
                    $class = 'notice notice-error';
                    $message = sprintf(__('The %s plugin is required for this theme. Please install and activate it.', 'speedpress'), $plugin['name']);
                    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
                }
            }
        }
    }
}
?>
