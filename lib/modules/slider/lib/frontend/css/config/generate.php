<?php
namespace sv_slider;

class css_generator{
    private $css_list = [];
    private $selector = '';

    public function __construct(string $selector = ''){
        $this->selector = $selector;
    }

    public function get_css(array $data): string {
        $output = '';

        // fill css list
        $this->parse($data);

        foreach($this->css_list as $selector => $content_array){
            $output .= $selector . '{';
            $output .= implode('', $content_array);
            $output .= '}';
        }

        // clean up
        $this->flush();

        return $output;
    }

    private function flush(){
        $this->css_list = [];
    }

    private function parse(array $data){
        foreach($data as $key => $val){
            $method = $this->get_method_name_from_key($key);
            if(method_exists($this, $method)){
                $this->add_to_css_list( $this->{$method}($key, $val) );
            }else{
               $this->add_to_css_list( $this->get_content_default($key, $val) );
            }
        }
    }

    private function get_method_name_from_key(string $key): string {
        return str_replace('-','_', $key);
    }

    private function add_to_css_list(array $pair){
        $css_list = $this->css_list;
        foreach($pair as $selector => $content){
            if( isset($css_list[$selector]) === false ){
                $css_list[$selector] = [];
            }

            $css_list[$selector][] = $content;
        }

        $this->css_list = $css_list;
    }

    private function get_path(string $path){
        return trailingslashit( dirname( __FILE__ ) ) . $path;
    }

    // custom methods ---------------------------------------------
    // custom methods ---------------------------------------------
    // custom methods ---------------------------------------------
    private function get_content_default(string $key, string $val){
       require_once($this->get_path('default.php'));
       $generator = new css_generator\_default($this->selector);

       return $generator->get($key, $val);
    }

    private function __swiffy_slider_arrows(string $key, string $val){
        require_once($this->get_path('arrows.php'));
        $generator = new css_generator\arrows($this->selector);

        return $generator->{'get_' . str_replace('-', '_', $val)}();
    }
}