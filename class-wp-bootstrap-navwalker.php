<?php
/**
 * Bootstrap 5 Nav Walker
 *
 * @package Custom_Walker
 */

class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {

    /**
     * Start Level.
     *
     * @param string &$output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param array $args An array of arguments. @see wp_nav_menu()
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $submenu = ($depth > 0) ? ' sub-menu' : '';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
    }

    /**
     * Start El.
     *
     * @param string &$output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param array $args An array of arguments. @see wp_nav_menu()
     * @param int $id Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'nav-item menu-item-' . $item->ID;
        if ($args->has_children) {
            $classes[] = 'dropdown';
        }
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'active';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';

        if ($args->has_children && $depth === 0) {
            $atts['href']          = '#';
            $atts['data-bs-toggle']   = 'dropdown';
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
            $atts['class']         = 'nav-link dropdown-toggle';
        } else {
            $atts['href'] = ! empty( $item->url ) ? $item->url : '';
            $atts['class'] = 'nav-link';
        }

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Display element.
     *
     * @param object $element Data object.
     * @param array $children_elements List of elements to continue traversing.
     * @param int $max_depth Max depth to traverse.
     * @param int $depth Depth of current element.
     * @param array $args Arguments.
     * @param string &$output Passed by reference. Used to append additional content.
     * @return void
     */
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if ( is_object( $args[0] ) )
            $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    /**
     * Menu Fallback
     * =============
     * If this function is assigned to the wp_nav_menu's fallback_cb variable
     * and a menu has not been assigned to the theme location in the WordPress
     * menu manager the function will display nothing to a non-logged in user,
     * and will add a link to the WordPress menu manager if logged in as an admin.
     *
     * @param array $args passed from the wp_nav_menu function.
     */
    public static function fallback( $args ) {
        if ( current_user_can( 'edit_theme_options' ) ) {
            $container = $args['container'];
            $container_id = $args['container_id'];
            $container_class = $args['container_class'];
            $menu_class = $args['menu_class'];
            $fallback_output = '';

            if ( $container ) {
                $fallback_output = '<' . esc_attr( $container );
                if ( $container_id ) {
                    $fallback_output .= ' id="' . esc_attr( $container_id ) . '"';
                }
                if ( $container_class ) {
                    $fallback_output .= ' class="' . esc_attr( $container_class ) . '"';
                }
                $fallback_output .= '>';
            }
            $fallback_output .= '<ul';
            if ( $menu_class ) {
                $fallback_output .= ' class="' . esc_attr( $menu_class ) . '"';
            }
            $fallback_output .= '>';
            $fallback_output .= '<li class="nav-item"><a class="nav-link" href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add a menu', 'speedpress' ) . '</a></li>';
            $fallback_output .= '</ul>';
            if ( $container ) {
                $fallback_output .= '</' . esc_attr( $container ) . '>';
            }
            echo $fallback_output;
        }
    }
}
?>
