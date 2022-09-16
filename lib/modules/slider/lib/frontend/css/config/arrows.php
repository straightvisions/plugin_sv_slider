<?php
namespace sv_slider\css_generator;

class arrows{
    public function __construct(){}

    public function chevron(): array{
        $css_list = [
          '.slider-nav-chevron .slider-nav::after' => 'mask: url("data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'%23fff\' viewBox=\'0 0 16 16\'><path fill-rule=\'evenodd\' d=\'M9.224 1.553a.5.5 0 0 1 .223.67L6.56 8l2.888 5.776a.5.5 0 1 1-.894.448l-3-6a.5.5 0 0 1 0-.448l3-6a.5.5 0 0 1 .67-.223z\'></path></svg>");'
        ];

        return $css_list;
    }
    
}