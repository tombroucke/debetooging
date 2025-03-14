<?php

namespace DeBetooging\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use DeBetooging\Console\FieldCommand;
use DeBetooging\Console\PostTypeCommand;
use DeBetooging\Console\TaxonomyCommand;
use DeBetooging\Console\ShortcodeCommand;
use DeBetooging\Console\SeedCommand;
use DeBetooging\Console\OptionsPageCommand;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('de_betooging.base_path', function () {
            return realpath(__DIR__ . '/../');
        });

        $this->app->singleton('de_betooging.locale', function () {
            return new \DeBetooging\Services\Locale();
        });

        $this->app->singleton('de_betooging.opening_hours', function () {
            return new \DeBetooging\OpeningHours();
        });
    }
    
    public function boot()
    {
        $this->commands([
            PostTypeCommand::class,
            TaxonomyCommand::class,
            OptionsPageCommand::class,
            FieldCommand::class,
            ShortcodeCommand::class,
            SeedCommand::class,
        ]);

        $this->loadViewsFrom(
            __DIR__.'/../../resources/views',
            'DeBetooging',
        );
        
        $this->loadTextdomain();
        $this->initPostTypes();
        $this->initOptionsPages();
        $this->initFields();
        $this->initShortcodes();
        
        Str::macro('phoneLink', function ($phone) {
            return Str::of($phone)
                ->replace(['(0)', '+'], ['', '00'])
                ->replaceMatches('/[^0-9]/', '')
                ->prepend('tel:');
        });

        Str::macro('emailLink', function ($email) {
            return Str::of(antispambot($email))
                ->prepend('mailto:');
        });
    }
    
    private function loadTextdomain()
    {
        add_action('init', function () {
            $muPluginRelPath = dirname(plugin_basename(__FILE__), 3).'/resources/languages/';
            load_muplugin_textdomain('de-betooging', $muPluginRelPath);
        }, 0);
    }
    
    private function initPostTypes()
    {
        collect([
            'PostTypes',
            'Taxonomies',
        ])->each(function ($registerableClassPath) {
            $this
                ->collectFilesIn("/$registerableClassPath")
                ->each(function ($filename) {
                    add_action('init', function () use ($filename) {
                        $className = $this->namespacedClassNameFromFilename($filename);
                        (new $className())
                        ->register();
                    });
                });
        });
    }
    
    private function initOptionsPages()
    {
        $this
            ->collectFilesIn('/OptionsPages')
            ->each(function ($filename) {
                add_action('acf/init', function () use ($filename) {
                    $className = $this->namespacedClassNameFromFilename($filename);
                    (new $className())
                    ->register();
                });
            });
    }

    private function initFields()
    {
        $this
            ->collectFilesIn('/Fields')
            ->each(function ($filename) {
                add_action('acf/init', function () use ($filename) {
                    $className = $this->namespacedClassNameFromFilename($filename);
                    (new $className())
                    ->register();
                });
            });
    }

    private function initShortcodes()
    {
        $this
            ->collectFilesIn('/Shortcodes')
            ->each(function ($filename) {
                $className = $this->namespacedClassNameFromFilename($filename);
                add_shortcode($className::SHORTCODE_NAME, [new $className(), 'callback']);
            });
    }
    
    private function collectFilesIn($path)
    {
        $fullPath = app('de_betooging.base_path') . "/$path";
        return collect(array_merge(
            glob("$fullPath/*.php"),
            glob("$fullPath/**/*.php")
        ));
    }
    
    private function namespacedClassNameFromFilename($filename)
    {
        return Str::of($filename)
            ->replace(app('de_betooging.base_path'), '')
            ->ltrim('/')
            ->replace('/', '\\')
            ->rtrim('.php')
            ->prepend('\\DeBetooging\\')
            ->__toString();
    }
}
