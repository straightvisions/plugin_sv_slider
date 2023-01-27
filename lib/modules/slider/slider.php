<?php

namespace sv_slider;

class slider extends modules {
    private $css_selector = '';
    private $class_selector = '';
    private $css_generator = null;

    public function init() {
        $this->set_section_title(__('Slider', 'sv_slider'))
             ->set_section_type('settings')
             ->load_settings()
             ->get_root()->add_section($this);

        add_action('init', array($this, 'register_block'));
        add_action('init', array($this, 'register_scripts'));
    }

    protected function load_settings(): slider {
        $this->get_setting('my_setting')
             ->set_title(__('My Setting', 'sv100'))
             ->set_description(__('Some text', 'sv100'))
             ->load_type('text');

        return $this;
    }

    public function register_block(): slider {
        $path = $this->get_path('lib/backend/src/components/wrapper/block.json');

        if (is_string($path) && file_exists($path)) {
            register_block_type(
                $path,
                array('render_callback' => array($this, 'render_block_wrapper'))
            );
        }

        return $this;
    }

    public function register_scripts(): slider {
        if (is_admin()) {
            ob_start();
            require($this->get_path('lib/backend/src/config.json'));
            $config = json_decode(ob_get_clean());

            $this->get_script('sv_slider_editor_script')
                 ->set_path('lib/backend/js/block.build.js')
                 ->set_type('js')
                 ->set_is_gutenberg()
                 ->set_is_backend()
                 ->set_localized(
                     array_merge(
                         [],
                         ['config' => $config]
                     )
                 )
                 ->set_is_enqueued();

            $this->get_script('sv_slider_swiffy_slider_css')
                 ->set_path('lib/frontend/css/swiffy-slider-modified.css')
                 ->set_is_gutenberg()
                 ->set_is_backend()
                 ->set_is_enqueued();

            $this->get_script('sv_slider_common_css')
                 ->set_path('lib/frontend/css/common.css')
                ->set_is_gutenberg()
                ->set_is_backend()
                 ->set_is_enqueued();

            $this->get_script('sv_slider_swiffy_slider_js')
                 ->set_path('lib/frontend/js/swiffy-slider.js')
                 ->set_is_gutenberg()
                 ->set_is_backend()
                 ->set_type('js')
                 ->set_is_enqueued();

            $this->get_script('editor_components')
                 ->set_is_backend()->set_is_gutenberg()->set_path('lib/backend/css/common/editor_components.css');
        } else {
            $this->get_script('sv_slider_swiffy_slider_css')
                 ->set_path('lib/frontend/css/swiffy-slider-modified.css')
                 ->set_is_enqueued();

            $this->get_script('sv_slider_common_css')
                 ->set_path('lib/frontend/css/common.css')
                 ->set_is_enqueued();

            $this->get_script('sv_slider_swiffy_slider_js')
                 ->set_path('lib/frontend/js/swiffy-slider.js')
                 ->set_type('js')
                 ->set_is_enqueued();
        }

        return $this;
    }

    private function get_css_generator(){
        // import helper class
        if($this->css_generator === null){
            require_once($this->get_path('lib/frontend/css/config/generate.php'));
            $this->css_generator = new css_generator();
        }

        // apply current id - support multiple slider
        $this->css_generator->init($this->css_selector);

        return $this->css_generator;
    }

    // SERVER SIDE RENDERING ---------------------------------------------------------------------
    // SERVER SIDE RENDERING ---------------------------------------------------------------------
    // SERVER SIDE RENDERING ---------------------------------------------------------------------

    public function render_block_wrapper(array $attributes, $content): string {
        $output = '';
        // set root selector
        $this->css_selector = $this->assign_css_selector($attributes);
        $content            = empty($content) ? $attributes['innerContent'] : $content;
        $tag                = $attributes['tagName'] ? $attributes['tagName'] : 'div';
        $id                 = $attributes['anchor'] ? ' id="'.$attributes['anchor'].'" ' : '';
        $attributes['svSlider'] = json_decode($attributes['svSlider'], true);
        $attributes['className'] = $this->populate_class_name($attributes);
        $attributes['_data'] = $this->populate_data_attributes($attributes);

        //@todo send script with server side output in editor - init swiffy - doesn't work right now
        if (defined('REST_REQUEST') && REST_REQUEST) {
            $content .= '<script>swiffyslider.init();</script>';
        }

        $children_count = isset($attributes['svSlider']['childrenCount']) ? (int)$attributes['svSlider']['childrenCount'] : 0;

        if($children_count > 0){
            ob_start();
            // output template
            if(isset( $attributes['svSlider']['isQuerySlider'] ) && $attributes['svSlider']['isQuerySlider'] === true ){
                require($this->get_path('lib/frontend/tpl/slider_query.php'));
            }else{
                require($this->get_path('lib/frontend/tpl/slider.php'));
            }
            // output css vars
            echo '<style>' . $this->get_css_vars($attributes['svSlider']) . '</style>';

            $output = ob_get_clean();
        }else{
            $output = '<p><i>Please add slides to the slider block!</i></p>';
        }

        return $output;
    }

    private function assign_css_selector(array $attributes) {
        $blockId = empty($attributes['svSlider']['blockId']) ?
            substr(md5(mt_rand()), 0, 7) :
            $attributes['svSlider']['blockId'];

        // set the class for injection in template
        $this->class_selector = 'wp-block-straightvisions-sv-slider-' . $blockId;

        // very important
        return '.swiffy-slider.wp-block-straightvisions-sv-slider-' . $blockId;
    }

    // CSS PIPE STEP 0A ---------------------------------------------------------------------
    private function get_css_vars($data): string {
        $output = '';
        $list   = $this->get_media_query_list($data);

        if (empty($list) === false) {
            $output = $this->parse_media_query_list($list);
        }

        return $output;
    }

    // CSS PIPE STEP 1 ---------------------------------------------------------------------

    private function get_media_query_list($data): array {
        $list = $this->normalize_array_keys($this->get_breakpoints_keys());

        foreach ($data as $css_var_name => $values) {
            // check for non css responsive attribute values like blockId
            if (is_array($values)) {
                $list = $this->assign_values_to_breakpoints($list, $css_var_name, $values);
                continue;
            }

        }

        return $list;
    }

    // CSS PIPE STEP 2 ---------------------------------------------------------------------

    private function normalize_array_keys(array $array): array {
        $_array = [];

        foreach ($array as $key => $val) {
            $_array[$this->normalize_string($key)] = $val;
        }

        return $_array;
    }

    // CSS PIPE STEP 3 ---------------------------------------------------------------------

    private function normalize_string(string $string): string {
        $string = str_replace('_', '', $string);
        $string = strtolower($string);

        return $string;
    }

    // CSS PIPE STEP 4 ---------------------------------------------------------------------

    private function get_breakpoints_keys(): array {
        $keys        = [];
        $breakpoints = $this->normalize_array_keys($this->get_breakpoints());

        foreach ($breakpoints as $key => $val) {
            $keys[$key] = [];
        }

        return $keys;
    }

    // CSS PIPE STEP 5 ---------------------------------------------------------------------

    private function assign_values_to_breakpoints(array $list, string $css_var_name, array $values): array {
        $values = $this->normalize_array_keys($values);

        foreach ($list as $breakpoint => &$arr) {
            if (isset($values[$breakpoint]) && empty($values[$breakpoint]) === false) {
                $arr[$css_var_name] = $values[$breakpoint];
            }
        }

        return $list;
    }

    // CSS PIPE STEP 6 ---------------------------------------------------------------------

    private function parse_media_query_list(array $list): string {
        $output      = '';
        $breakpoints = $this->normalize_array_keys($this->get_breakpoints());

        foreach ($list as $breakpoint_key => $values) {
            // check for empty
            if ($values) {
                // media query block start
                $output .= '@media(min-width: ' . $breakpoints[$breakpoint_key] . 'px)';
                $output .= $this->get_media_query_orientation($breakpoint_key);
                $output .= '{';
                // element rule block start ------------------------------
                $output .= $this->get_css_generator()->get_css($values);
                // element rule block end; -------------------------------
                $output .= '}';
                // media query block end
            }
        }

        return $output;
    }

    // we have different key naming standards in PHP and React (underscore vs CamelCase)

    private function get_media_query_orientation(string $breakpoint_key): string {
        $output         = '';
        $breakpoint_key = strtolower($breakpoint_key);

        // set portrait orientation if key is not mobile or desktop
        if (in_array($breakpoint_key, ['mobile', 'desktop']) === false) {
            $output = ' and (orientation: portrait)';
        }

        // @todo replace this later with str_contains (PHP8)
        // change orientation to landscape if key contains "landscape"
        if (strpos($breakpoint_key, 'landscape') !== false) {
            $output = ' and (orientation: landscape)';
        }

        return $output;
    }

    private function render_inner_blocks(array $children): string {
        $inner_blocks = '';

        foreach ($children as $key => $block) {
            $inner_blocks .= $block['originalContent'];
        }

        return $inner_blocks;
    }

    private function populate_class_name(array $attributes){
        $slider_attributes = $attributes['svSlider'];
        $class_name = $attributes['className'] ?? '';

        // autoplay static class
        $class_name .= isset($slider_attributes['--swiffy-slider-class-autoplay'])
                      && $slider_attributes['--swiffy-slider-class-autoplay'] === true ? ' slider-nav-autoplay' : '';

        $class_name .= isset($slider_attributes['--swiffy-slider-class-autopause'])
                       && $slider_attributes['--swiffy-slider-class-autopause'] === true ? ' slider-nav-autopause' : '';

        $class_name .= $this->item_ratio_is_set((array)$slider_attributes) ? ' slider-item-ratio' : '';

        return $class_name;
    }

    private function populate_data_attributes(array $attributes){
        $slider_attributes = $attributes['svSlider'];
        $data = [];

        if(isset($slider_attributes['--swiffy-slider-data-autoplay-timeout'])){
            $data[] = 'data-slider-nav-autoplay-interval="'
                . (int)$slider_attributes['--swiffy-slider-data-autoplay-timeout']
                . '"';
        }

        return implode(' ', $data);
    }

    private function item_ratio_is_set(array $slider_attributes): bool {
        $output = false;

        if(isset($slider_attributes['--swiffy-slider-item-ratio'])
           && is_array($slider_attributes['--swiffy-slider-item-ratio'])){

            foreach($slider_attributes['--swiffy-slider-item-ratio'] as $key => $val){
                if(empty($val) === false){
                    $output = true;
                    break;
                }
            }

        }

        return $output;
    }

}