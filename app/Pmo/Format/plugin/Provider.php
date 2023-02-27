<?php
/**
 * Provides everything needed for the Plugin
 */
    $this->loadTranslationsFrom(__DIR__.'/Lang', 'Plugins/Plugin_Code/Plugin_Key');
    $this->loadViewsFrom(__DIR__.'/Views', 'Plugins/Plugin_Code/Plugin_Key');

    if (sc_config('Plugin_Key')) {
    // $this->mergeConfigFrom(
    //     __DIR__.'/config.php', 'key_define_for_plugin'
    // );
    }
