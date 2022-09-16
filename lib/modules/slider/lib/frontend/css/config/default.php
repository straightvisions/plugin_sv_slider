<?php
namespace sv_slider\css_generator;

class _default{
    private $selector = '';

    public function __construct(string $selector = ''){
        $this->selector = $selector;
    }

    public function get(string $key, $val): array {
        $list = [
            $this->selector => $key . ':' . $val . ';'
        ];

        return $list;
    }

}
