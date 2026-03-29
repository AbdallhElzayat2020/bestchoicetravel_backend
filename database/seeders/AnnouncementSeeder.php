<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Seeds the default announcement row and turns the top bar on (dynamic text from DB).
     */
    public function run(): void
    {
        if (Announcement::query()->exists()) {
            return;
        }

        Announcement::create([
            'content' => 'A Nile cruise is the classic way to explore Egypt — luxury vessels, riverside temples, and timeless moments.',
            'status' => 'active',
            'sort_order' => 0,
        ]);

        Setting::updateOrCreate(
            ['key' => 'announcement_bar_enabled'],
            ['value' => '1']
        );
        Setting::clearCache();
    }
}
