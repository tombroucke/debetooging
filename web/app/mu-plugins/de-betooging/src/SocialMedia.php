<?php

namespace DeBetooging;

use Illuminate\Support\Collection;

class SocialMedia
{
    private Collection $channels;

    public function __construct()
    {
        $this->channels = collect([
            'facebook' => [
                'label' => __('Facebook', 'de-betooging'),
                'icon' => 'facebook'
            ],
            'instagram' => [
                'label' => __('Instagram', 'de-betooging'),
                'icon' => 'instagram'
            ],
            'linkedin' => [
                'label' => __('LinkedIn', 'de-betooging'),
                'icon' => 'linkedin'
            ],
            'x' => [
                'label' => __('X', 'de-betooging'),
                'icon' => 'x-twitter'
            ],
            'youtube' => [
                'label' => __('YouTube', 'de-betooging'),
                'icon' => 'youtube'
            ],
            'vimeo' => [
                'label' => __('Vimeo', 'de-betooging'),
                'icon' => 'vimeo'
            ],
            'tiktok' => [
                'label' => __('TikTok', 'de-betooging'),
                'icon' => 'tiktok'
            ],
            'pinterest' => [
                'label' => __('Pinterest', 'de-betooging'),
                'icon' => 'pinterest'
            ],
            'tripadvisor' => [
                'label' => __('Tripadvisor', 'de-betooging'),
                'icon' => 'tripadvisor'
            ],
        ]);
    }

    public function allChannels() : Collection
    {
        return $this->channels->map(function ($channel, $key) {
            $channel['link'] = get_field('social_media_' . $key, 'option');
            return $channel;
        });
    }
    
    public function channels() : Collection
    {
        return $this->allChannels()
            ->filter(function ($channel) {
                return $channel['link'];
            });
    }
}
