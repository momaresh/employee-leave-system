<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ChangeLanguageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_language_switcher_changes_locale()
    {
        Livewire::test('livewire.layout.navigation')
            ->call('switchLanguage', 'ar');

        $this->assertEquals(app()->getLocale(), 'ar');
    }
}
