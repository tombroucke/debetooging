<?php

namespace DeBetooging\Shortcodes;

use DeBetooging\Contracts\Shortcode;

class OpeningHours implements Shortcode
{

    const SHORTCODE_NAME = 'opening-hours';
    
    /**
     * Shortcode callback
     *
     * @param array<string, mixed>|string $atts The shortcode attributes.
     * @return string
     */
    public function callback(array|string $atts = []) : string
    {
        return view('DeBetooging::shortcodes.opening-hours', [
            'schedule' => app()->make('de_betooging.opening_hours')->schedule(),
        ])->toHtml();
    }
}
