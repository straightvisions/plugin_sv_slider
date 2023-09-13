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
    // props are global attributes for the Service, not for the specific block
    private $props = [];
    private $parent = null;

    public function __construct(array $props = [], $parent = null){
        $this->flush(); // init flush
        $this->props = $props; // assign props
        $this->parent = $parent; // experimental
    }

    public function render(array $attributes, $content){
        $output = '';
        // prepare everything
        $this->flush(); // forget everything from previous runs
        $this->set_attributes($attributes);
        $this->set_children_count();
        $this->set_slides_count();
        $this->set_content($content);
        // ----------------------------------------------------
        // ----------------------------------------------------

        if($this->children_count > 0){
            ob_start();
            $this->render_css();
            $this->render_content();
            $output = ob_get_clean();

			// enqueue scripts
	        $this->parent->enqueue_scripts();
        }else{
            $output = '<p><i>Please add slides to the slider block!</i></p>';
        }
        
        // ----------------------------------------------------
        // ----------------------------------------------------
        return $output;
    }

    private function render_content(){
        require($this->get_path('lib/frontend/tpl/slider.php'));
    }

    private function render_css(){
        echo '<style>' . $this->get_css_vars() . '</style>';
    }

    private function set_children_count(){
        $this->children_count = $this->get_attr('childrenCount', 0);
    }

    private function set_slides_count($children = false){
        $children = $children !== false ? (int)$children : (int)$this->get_attr('childrenCount', 0);

        //@todo indicators are not responsive!
        $visible_slides_per_breakpoint = $this->get_attr('--swiffy-slider-item-count', ['Mobile'=>1]);
        $mobile = (int) $visible_slides_per_breakpoint['Mobile'];
        // we need at least one breakpoint with 1 slide
        $mobile = $mobile > 0 ? $mobile : 1;
        $count = ceil( $children / $mobile );

        $this->slides_count = $count;
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
        // populate data attributes
        $this->set_data_attributes();
        // get selectors for css and class
        $this->set_selectors();
        // populate class names for wrapper
        $this->set_classnames();

    }

    private function get_wrapper_tag(){
        return $this->get_block_attr('tagName', false) ?  $this->get_block_attr('tagName') : 'div';
    }

    private function get_wrapper_id(){
        return $this->get_block_attr('anchor') !== '' ? ' id="'.$this->get_block_attr('anchor').'" ' : '';
    }

    private function get_wrapper_class(){
        return ' class="' . implode(' ', $this->get_block_attr('className', [])).'" ';
    }

    private function get_slider_class(array $custom_class_names = []){
        return ' class="' . implode(' ', array_merge($this->get_attr('className', []), $custom_class_names)).'" ';
    }

    private function get_slider_data_attr(){
        return implode(' ', $this->get_attr('dataAttribute', []));
    }

    private function get_slider_content(){
        $output = '';
        $blocks = parse_blocks($this->content);

        foreach ($blocks as $block) {
            $output .= render_block($block);
        }
        return $output;
    }

    private function get_attr(string $name, $default = ''){
        return isset($this->attr[$name]) ? $this->attr[$name] : $default;
    }

    private function get_block_attr(string $name, $default = ''){
        return isset($this->attr['block'][$name]) ? $this->attr['block'][$name] : $default;
    }

    private function sanitize_key(string $key): string{
        if ( is_scalar( $key ) ) {
            $key = preg_replace( '/[^a-z\d_\-]/i', '', $key );
        }
        return $key;
    }

    private function get_path(string $path = ''){
        return $this->parent->get_path($path); // experimental
        //return trailingslashit( dirname( __FILE__ ) ) . $path;
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
        $this->css_selector = '.wp-block-straightvisions-sv-slider.wp-block-straightvisions-sv-slider-' . $blockId . ' .swiffy-slider';
    }

    private function get_breakpoints(){
        return isset($this->props['breakpoints']) ? $this->props['breakpoints'] : ['mobile'=>0];
    }

    // CSS PIPE STEP 0A ---------------------------------------------------------------------
    
    private function get_css_vars(): string {
        $output = '';
        $list   = $this->get_media_query_list($this->attr);

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

    private function set_classnames(){
        // get classnames attr from block attributes, it's from Gutenberg, so it's a string mostly
        // "className" is the key provided from Gutenberg, so we will keep it that way
        $classnames_block = is_string($this->get_block_attr('className')) ? explode(' ', $this->get_block_attr('className')) : $this->get_block_attr('className', []);
        $classnames_slider = is_string($this->get_attr('className')) ? explode(' ', $this->get_attr('className')) : $this->get_attr('className', []);

        // block unique selector classes --------------------------------------------------------
        $classnames_block[] = $this->class_selector;
        $classnames_block[] = 'slider-type-'.$this->get_attr('sliderType', 'default');
        // 3rd party specific classes -----------------------------------------------------------
        if($this->get_attr('sliderType') === 'woocommerce'){
            $classnames_block[] = 'slider-type-woocommerce-'.$this->get_attr('sliderTypeWooCommerce', 'default');
        }
        // alignment ----------------------------------------------------------------------------
        $classnames_block[] = 'align'.$this->get_block_attr('align');
        // slider classes -----------------------------------------------------------------------
        $classnames_slider[] = "sv-slider-inner";
        $classnames_slider[] = "swiffy-slider";
        $classnames_slider[] = "slider-nav-visible"; //@todo make a setting
        // autoplay static class ----------------------------------------------------------------
        $classnames_slider[] = $this->get_attr('--swiffy-slider-class-autoplay', false)
                       && $this->attr['--swiffy-slider-class-autoplay'] === true ? ' slider-nav-autoplay' : '';

        $classnames_slider[] =  $this->get_attr('--swiffy-slider-class-autopause', false)
                       && $this->attr['--swiffy-slider-class-autopause'] === true ? ' slider-nav-autopause' : '';
        // item view ratio class --------------------------------------------------------------
        $classnames_slider[] = $this->item_ratio_is_set() ? ' slider-item-ratio' : '';
        // indicators --------------------------------------------------------------------------
        $classnames_slider[] = $this->get_attr('indicators-style', false) ? 'slider-indicators-' . $this->get_attr('indicators-style') : '';
        $classnames_slider[] = $this->get_attr('indicators-style', false) ? 'slider-indicators-' . $this->get_attr('indicators-style') : '';
        $classnames_slider[] = $this->get_attr('indicators-dark', false) ? 'slider-indicators-dark' : '';
        $classnames_slider[] = $this->get_attr('indicators-outside', false) ? 'slider-indicators-outside' : '';
        $classnames_slider[] = $this->get_attr('indicators-highlight', false) ? 'slider-indicators-highlight' : '';
        $classnames_slider[] = $this->get_attr('indicators-visible-sm', false) ? 'slider-indicators-sm' : '';

        // remove duplicates and empty lines
        $classnames_block = array_unique(array_filter($classnames_block));
        $classnames_slider = array_unique(array_filter($classnames_slider));
        // set
        $this->attr['block']['className'] = $classnames_block;
        $this->attr['className'] = $classnames_slider;
    }

    private function set_data_attributes(){
        $data = [];

        if($this->get_attr('--swiffy-slider-data-autoplay-timeout', false)){
            $data[] = 'data-slider-nav-autoplay-interval="'
                      . (int)$this->get_attr('--swiffy-slider-data-autoplay-timeout')
                      . '"';
        }

        $this->attr['dataAttribute'] = $data;
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