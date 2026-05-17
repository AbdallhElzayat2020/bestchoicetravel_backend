<?php

namespace App\Console\Commands;

use App\Models\CruiseExperience;
use App\Models\Tour;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncTourCruiseExperiences extends Command
{
    protected $signature = 'tours:sync-cruise-experiences';

    protected $description = 'Sync cruise_experience_id on tours from cruise_experience_tour pivot links';

    public function handle(): int
    {
        $rows = DB::table('cruise_experience_tour')->get();
        $updated = 0;

        foreach ($rows as $row) {
            $experience = CruiseExperience::find($row->cruise_experience_id);
            if (! $experience) {
                continue;
            }

            $affected = Tour::where('id', $row->tour_id)->update([
                'cruise_experience_id' => $experience->id,
                'cruise_group_id' => $experience->cruise_group_id,
            ]);

            $updated += $affected;
        }

        $this->info("Updated {$updated} tour(s) from pivot links.");

        return self::SUCCESS;
    }
}
