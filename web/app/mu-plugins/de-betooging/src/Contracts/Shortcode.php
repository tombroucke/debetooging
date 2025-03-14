<?php

namespace DeBetooging\Contracts;

interface Shortcode
{
    public function callback(array|string $atts = []) : string;
}
