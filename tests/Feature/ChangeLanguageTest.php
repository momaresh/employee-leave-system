<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Livewire\Volt\Volt;

test('language switcher changes locale', function () {
    $component = Volt::test('layout.navigation')
        ->call('switchLanguage', 'ar');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    expect('ar')->toEqual(app()->getLocale());
});
