<?php
class MainMenuWalker extends Walker{
    protected $current_parent_id;
    protected $current_colum = FALSE;
    public $db_fields = array(
        'parent' => 'menu_item_parent',
        'id'     => 'db_id'
    );

    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        $indent = str_repeat( $t, $depth );

        // Default class.
        // $classes = ($depth == 0)? array('row'): array( 'sub-menu' );
        $classes = array( 'sub-menu' );
        $class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        // $output .= ($depth == 0)? "{$n}{$indent}<div$class_names>{$n}" : "{$n}{$indent}<ul$class_names>{$n}";
        $output .= "{$n}{$indent}<ul$class_names>{$n}";
    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        $indent = str_repeat( $t, $depth );
        // $output .= ($depth == 0)? "$indent</div>{$n}" : "$indent</ul>{$n}";
        $output .= "$indent</ul>{$n}";
    }

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $item_id            = $item->ID;
        $menu_haschildren   = FALSE;

        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
        if($depth == 0){
            $classes[] = 'nav-item';
        }

        if(in_array('menu-item-has-children',$classes)) $menu_haschildren = TRUE;
        // if(in_array('menu_col',$classes)) $classes[] = 'col-lg-3';

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        // if(in_array('menu_col',$classes)){
        //     $output .= $indent . '<div' . $id . $class_names .'>';
        // }else{
        //     $output .= $indent . '<li' . $id . $class_names .'>';
        // }
        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : $item->title;
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        $attributes = '';
        if($depth == 0){
            $atts['class'] = 'nav-link';
        }

        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
        $item_output = $args->before;
        // if(!in_array('menu_col',$classes)){
        //     $item_output .= '<a'. $attributes .'>';
        //     $item_output .= $args->link_before . $title . $args->link_after;
        //     $item_output .= '</a>';
        // }else{
        //     $item_output .= $args->link_before.$args->link_after;
        // }
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';

        if($depth == 0 && $menu_haschildren == TRUE){
            $this->current_parent_id = $item_id;
            $item_output  .="<span class=\"dropdown-toggle d-lg-none\" id=\"sub" . $item_id . "\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"true\"></span>";
        }

        $item_output .= $args->after;
        if($depth == 0 && $menu_haschildren == TRUE){
            // $item_output .= '<div class="dropdown-menu" aria-labelledby="sub2"><div class="container">';
            $item_output .= '<div class="dropdown-menu" aria-labelledby="sub' . $item_id . '">';
        }
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        if($this->current_parent_id == $item->ID && $depth == 0){
            // $output .= "</div></div>";
            $output .= "</div>";
        }

        // if(in_array('menu_col',$item->classes)){
        //     $output .= "</div>{$n}";
        // }else{
        //     $output .= "</li>{$n}";
        // }
        $output .= "</li>{$n}";
    }
}