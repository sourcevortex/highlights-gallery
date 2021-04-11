<?php

class hgw_widget extends WP_Widget {
    private $assets_dir;
    private $templates;

    function __construct() {
        parent::__construct(
            'hgw_widget', 
            __('Highlights Gallery Widget', 'hgw_widget'), 
            array( 'description' => __( 'Highlights your posts in a Carousel Gallery', 'hgw_widget' ), ) 
        );

        $this->assets_dir = HG_PLUGIN_DIR_URL . 'assets';
        $this->templates = HG_PLUGIN_DIR_PATH . '/templates';

        $this->modify_homepage_query( HG_DEFAULT_CATEGORY );
    }

    /**
     * Load plugin assets
     */
    private function load_assets() {
        wp_enqueue_style( 'hg-slick-css', $this->assets_dir . '/css/slick.css' , array(), '0.1' );
        wp_enqueue_style( 'hg-slick-theme-css', $this->assets_dir . '/css/slick-theme.css' , array(), '0.1' );
        wp_enqueue_style( 'hg-main-css', $this->assets_dir . '/css/main.css' , array(), '0.1' );
        wp_enqueue_script( 'hg-slick-js', $this->assets_dir . '/js/slick.min.js', array( 'jquery' ), '0.1', true );
        wp_enqueue_script( 'hg-main-js', $this->assets_dir . '/js/main.js', array( 'hg-slick-js' ), '0.1', true );
    }

    /**
     * Avoid show highlighted categories
     * 
     * @param string $category
     */
    private function modify_homepage_query( $category ) {
        add_action( 'pre_get_posts', function ( $query ) use ( $category ) {
            /** @var WP_Query $query */
            if ( $query->is_home() && $query->is_main_query() && $category ) {
                $query->set( 'tax_query', array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => array(
                            $category 
                        ),
                        'operator'=> 'NOT IN'
                    )
                ) );
            }
        } );
    }

    /**
     * @param string $category
     */
    private function get_highlighted_posts( $category, $number_posts = 5 ) {
        if ( $category ) {
            return get_posts([
                'args' => [
                    'category' => $category,
                ],
                'numberposts' => $number_posts
            ]);
        } else {
            return [];
        }
    }
    
    /**
     * Frontend widget
     */
    public function widget( $args, $instance ) {
        $number_posts = isset( $instance[ 'number_posts' ] ) ? $instance[ 'number_posts' ] : 5;

        $this->load_assets();        
        $highlighted_posts = $this->get_highlighted_posts( HG_DEFAULT_CATEGORY, $number_posts );

        if ( count( $highlighted_posts ) > 0 ) {
            echo $args['before_widget'];
            echo '<div class="hgw_carousel hgw_carousel_container">';
            foreach ( $highlighted_posts as $post ) {
                include $this->templates . '/default-gallery.php';
            }
            echo '</div>';
            echo $args['after_widget'];
        }
    }
            
    public function form( $instance ) {
        $number_posts = isset( $instance[ 'number_posts' ] )
            ? $instance[ 'number_posts' ]
            : __( 5, 'hgw_widget' );


        include HG_PLUGIN_DIR_PATH . '/widget-form.php';
    }
        
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['number_posts'] = ( ! empty( $new_instance['number_posts'] ) ) ? strip_tags( $new_instance['number_posts'] ) : '';
        return $instance;
    }
} 