<?php

namespace DeBetooging;

class OpeningHours
{
    public function schedule()
    {
        $schedule = collect();
        $weekdays = app()->make('de_betooging.locale');
        $weekdays->weekDays()->each(function ($day, $key) use ($schedule) {
            $openingHours = array_filter((array)get_field('opening_hours_' . $key, 'option'));
            $schedule->push([
                'day' => $day,
                'hours' => $openingHours,
            ]);
        });
        return $schedule;
    }
}
