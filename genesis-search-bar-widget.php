<?php
/*
Plugin Name: Genesis Search Bar Widget
Description: A search bar widget for Studiopress Genesis with customizable placeholder text.
Version: 1.0
Author: Abhishek Ghosh
*/

class Genesis_Search_Bar_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'genesis_search_bar_widget',
            __('Genesis Search Bar Widget', 'text_domain'),
            array('description' => __('A custom search bar for Genesis theme.', 'text_domain'))
        );
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
    }

    public function enqueue_styles() {
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');
        wp_enqueue_style('genesis-search-bar-widget-style', plugins_url('style.css', __FILE__));
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        $placeholder = !empty($instance['placeholder']) ? $instance['placeholder'] : __('Search...', 'text_domain');
        echo '<div class="genesis-search-bar-widget">
                <form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">
                    <div class="search-container">
                        <i class="fas fa-search"></i>
                        <input type="search" class="search-field" placeholder="' . esc_attr($placeholder) . '" value="" name="s">
                    </div>
                </form>
              </div>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        $placeholder = !empty($instance['placeholder']) ? $instance['placeholder'] : '';
        echo '<p>
                <label for="' . $this->get_field_id('placeholder') . '">Placeholder Text:</label>
                <input class="widefat" id="' . $this->get_field_id('placeholder') . '" name="' . $this->get_field_name('placeholder') . '" type="text" value="' . esc_attr($placeholder) . '" />
              </p>';
    }

    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['placeholder'] = (!empty($new_instance['placeholder'])) ? sanitize_text_field($new_instance['placeholder']) : '';
        return $instance;
    }
}

function register_genesis_search_bar_widget() {
    register_widget('Genesis_Search_Bar_Widget');
}
add_action('widgets_init', 'register_genesis_search_bar_widget');

// Plugin Styles
function genesis_search_bar_widget_styles() {
    echo '<style>
        .genesis-search-bar-widget .search-container {
            display: flex;
            align-items: center;
            background: #f5f5f5;
            padding: 10px;
            border-radius: 25px;
        }
        .genesis-search-bar-widget .search-container i {
            margin-right: 10px;
            color: #666;
        }
        .genesis-search-bar-widget .search-field {
            border: none;
            background: none;
            outline: none;
            flex-grow: 1;
            font-size: 16px;
        }
    </style>';
}
add_action('wp_head', 'genesis_search_bar_widget_styles');
