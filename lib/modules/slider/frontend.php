<?php

namespace sv_slider;
use stdClass;

class Frontend {
    // Services
    private $CSS_Generator = null;
    // Properties
    private $css_selector;
    private $class_selector;
    private $attr;
    private $content;
    private $children_count = 0;
    private $slides_count = 0;

    public function __construct(){
        $this->flush(); // init flush
    }

    public function render(array $attributes, $content){
        $output = '';
        $this->flush(); // forget everything from previous runs
        $this->set_attributes($attributes);
        $this->set_children_count();
        $this->set_slides_count();
        $this->set_content($content);
        // ----------------------------------------------------
        // ----------------------------------------------------


        
        // ----------------------------------------------------
        // ----------------------------------------------------
        return $output;
    }

    private function set_children_count(){
        $this->children_count = $this->get_attr('childrenCount', 0);
    }

    private function set_slides_count(){
        $ch = $this
        $this->slides_count = $this->get_attr('childrenCount', 0);
    }

    // old
    function xxxx(){

        $children_count =

        if($children_count > 0){
            ob_start();
            // output template
            switch($slider_type){
                case 'post-template': require($this->get_path('lib/frontend/tpl/slider_post_template.php'));break;
                case 'woocommerce': require($this->get_path('lib/frontend/tpl/slider_woocommerce.php'));break;
                default: require($this->get_path('lib/frontend/tpl/slider.php'));
            }

            // output css vars
            echo '<style>' . $this->get_css_vars($this->attr) . '</style>';

            $output = ob_get_clean();
        }else{
            $output = '<p><i>Please add slides to the slider block!</i></p>';
        }

        return $output;
    }

    private function flush(){
        $this->attr = ['block'=>[]];
        $this->css_selector = '';
        $this->class_selector = '';
    }

    private function set_content(string $content){
        $this->content = $this->get_block_attr('innerContent'); // either returns string or empty string
        $this->content = empty($content) ? $this->content : $content;
        //@todo test if this is even working in Gutenberg
        if (defined('REST_REQUEST') && REST_REQUEST) {
            $this->content .= '<script>swiffyslider.init();</script>';
        }
    }

    public function set_attributes(array $attributes){
        // svSlider is a block custom attribute saved as JSON
        $attributes['svSlider'] = json_decode($attributes['svSlider'], true);

        // read Gutenberg block attributes
        foreach($attributes as $key => $val){
            if($this->sanitize_key($key) === 'svSlider') continue; // skip
            $this->attr['block'][$this->sanitize_key($key)] = $val;
        }

        // red custom block attributes
        foreach($attributes['svSlider'] as $key => $val){
            if($this->sanitize_key($key) === 'block'){
                error_log('WARNING - custom block attribute with name "block" not allowed.');
                continue;
            }
            
            $this->attr[$this->sanitize_key($key)] = $val;
        }
        
        // some shorthand custom attributes
        $this->attr['block']['tag'] = $this->get_block_attr('tagName', false) ?? 'div';
        $this->attr['block']['id']  = $this->get_block_attr('anchor', false) ? ' id="'.$this->get_block_attr('anchor').'" ' : '';
        // populate data attributes
        $this->set_data_attributes();
        // get selectors for css and class
        $this->set_selectors();
        // populate class names for wrapper
        $this->set_class_name();

    }

    private function get_attr(string $name, $default = ''){
        return isset($this->attr[$name]) ? $this->attr[$name] : $default;
    }

    private function get_block_attr(string $name, $default = ''){
        return isset($this->attr['block'][$name]) ? $this->attr['block'][$name] : $default;
    }

    private function sanitize_key(string $key): string{
        if ( is_scalar( $key ) ) {
            $key = trim('-');
            $key = preg_replace( '/[^a-z\d_\-]/i', '', $key );
        }
        return $key;
    }

    private function get_path(string $path){
        return trailingslashit( dirname( __FILE__ ) ) . $path;
    }

    private function get_css_generator(){
        // import helper class
        if($this->CSS_Generator === null){
            require_once($this->get_path('lib/frontend/css/config/generate.php'));
            $this->CSS_Generator = new css_generator();
        }

        // apply current id - support multiple slider
        $this->CSS_Generator->init($this->css_selector);

        return $this->CSS_Generator;
    }

    private function set_selectors() {
        $blockId = empty($this->attr->blockId) ?
            substr(md5(mt_rand()), 0, 7) :
            $this->attr->blockId;

        // set the class for injection in template
        $this->class_selector = 'wp-block-straightvisions-sv-slider-' . $blockId;
        $this->css_selector = '.swiffy-slider.wp-block-straightvisions-sv-slider-' . $blockId;
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

    // @todo might be obsolete - remove?
    private function render_inner_blocks(array $children): string {
        $inner_blocks = '';

        foreach ($children as $key => $block) {
            $inner_blocks .= $block['originalContent'];
        }

        return $inner_blocks;
    }

    private function set_class_name(){
        $class_name = $this->attr['block']['className'] ?? '';

        // autoplay static class
        $class_name .= $this->get_attr('--swiffy-slider-class-autoplay', false)
                       && $this->attr['--swiffy-slider-class-autoplay'] === true ? ' slider-nav-autoplay' : '';

        $class_name .=  $this->get_attr('--swiffy-slider-class-autopause', false)
                       && $this->attr['--swiffy-slider-class-autopause'] === true ? ' slider-nav-autopause' : '';

        // item view ratio class
        $class_name .= $this->item_ratio_is_set() ? ' slider-item-ratio' : '';

        $this->attr['block']['className'] = $class_name;
    }

    private function set_data_attributes(){
        $data = [];

        if($this->get_attr('--swiffy-slider-data-autoplay-timeout', false)){
            $data[] = 'data-slider-nav-autoplay-interval="'
                      . (int)$this->get_attr('--swiffy-slider-data-autoplay-timeout')
                      . '"';
        }

        $this->attr['dataAttribute'] = implode(' ', $data);
    }

    private function item_ratio_is_set(): bool {
        $output = false;

        if($this->get_attr('--swiffy-slider-item-ratio', false)
           && is_array($this->get_attr('--swiffy-slider-item-ratio'))){

            foreach($this->get_attr('--swiffy-slider-item-ratio') as $key => $val){
                if(empty($val) === false){
                    $output = true;
                    break;
                }
            }

        }

        return $output;
    }
}