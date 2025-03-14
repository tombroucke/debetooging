<?php

namespace DeBetooging\OptionsPages;

use DeBetoogingSocialMedia as SocialMedia;
use DeBetooging\Abstracts\OptionsPage as AbstractsOptionsPage;
use StoutLogic\AcfBuilder\FieldsBuilder;
use DeBetooging\Contracts\OptionsPage;

class General extends AbstractsOptionsPage implements OptionsPage
{
    protected string $slug = 'de-betooging-settings';

    protected string $title = 'General Settings';

    protected string $menuTitle = 'General Settings';

    public function __construct()
    {
        $this->title = __('General Settings', 'de-betooging');
        $this->menuTitle = __('General Settings', 'de-betooging');
    }

    protected function fields(FieldsBuilder $fieldsBuilder) : FieldsBuilder
    {
        $fieldsBuilder = $this->addContactInformation($fieldsBuilder);
        $fieldsBuilder = $this->addSocialMedia($fieldsBuilder);
        $fieldsBuilder = $this->addOpeningHours($fieldsBuilder);
        $fieldsBuilder = $this->addNewsletter($fieldsBuilder);
        return $fieldsBuilder;
    }

    private function addSocialMedia(FieldsBuilder $settings): FieldsBuilder
    {
        $settings
            ->addTab('social_media', [
                'label' => __('Social media URL\'s', 'de-betooging'),
            ]);

        $channels = SocialMedia::allChannels();

        $channels->each(function ($channel, $key) use ($settings) {
            $settings
                ->addUrl('social_media_' . $key, [
                    'label' => $channel['label'],
                ]);
        });
        return $settings;
    }

    private function addContactInformation(FieldsBuilder $settings) : FieldsBuilder
    {
        $settings
            ->addTab('contact_information', [
                'label' => __('Contact information', 'de-betooging'),
            ]);
        
        $fields = collect([
            'company' => __('Company', 'de-betooging'),
            'street' => __('Street', 'de-betooging'),
            'street_number' => __('Number', 'de-betooging'),
            'postcode' => __('Postcode', 'de-betooging'),
            'city' => __('City', 'de-betooging'),
            'country' => __('Country', 'de-betooging'),
            'phone' => __('Phone', 'de-betooging'),
            'email' => __('Email', 'de-betooging'),
            'vat_number' => __('VAT number', 'de-betooging'),
        ]);

        $fields->each(function ($label, $key) use ($settings) {
            $settings
                ->addText('contact_information_' . $key, [
                    'label' => $label,
                ]);
        });
        return $settings;
    }

    private function addOpeningHours(FieldsBuilder $settings) : FieldsBuilder
    {
        $settings
            ->addTab('opening_hours', [
                'label' => __('Opening hours', 'de-betooging'),
            ]);
        $days = app()->make('de_betooging.locale')->weekDays();
        $days->each(function ($day, $key) use ($settings) {
            $settings
                ->addRepeater('opening_hours_' . $key, [
                    'label' => ucfirst($day),
                ])
                    ->addTimePicker('from', [
                        'label' => __('From', 'de-betooging'),
                        'display_format' => 'H:i',
                        'return_format' => 'H:i',
                        'default_value' => '09:00',
                    ])
                    ->addTimePicker('to', [
                        'label' => __('To', 'de-betooging'),
                        'display_format' => 'H:i',
                        'return_format' => 'H:i',
                        'default_value' => '17:00',
                    ])
                ->endRepeater();
        });
        return $settings;
    }

    private function addNewsletter(FieldsBuilder $settings) : FieldsBuilder
    {
        $settings
            ->addTab('newsletter', [
                'label' => __('Newsletter', 'de-betooging'),
            ]);
        $settings
            ->addTextarea('newsletter_signup_form', [
                'label' => __('Newsletter signup form', 'de-betooging'),
                'rows' => 40,
                'instructions' => __('Enter the signup form code. You can use the [newsletter-signup-form] shortcode to display the signup form.', 'de-betooging'),
            ]);
        return $settings;
    }
}
