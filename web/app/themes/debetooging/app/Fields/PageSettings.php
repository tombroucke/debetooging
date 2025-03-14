<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class PageSettings extends Field
{
    /**
     * The field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('page_settings');

        $fields
            ->setLocation('post_type', '==', 'page');

        $fields
            ->addTrueFalse('alternative_header', [
                'label' => __('Alternative header', 'sage'),
                'instructions' => __('Show the alternative, small header', 'sage'),
                'default_value' => true,
            ]);

        return $fields->build();
    }
}
