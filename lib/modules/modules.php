<?php

namespace sv_slider;

class modules extends init {
    public function __construct() {}

    public function init() {
        $this->load_module('slider');
    }
}