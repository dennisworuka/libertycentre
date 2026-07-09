<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PurgeExpiredPersonalData extends Command
{
    protected $signature = 'liberty:purge-expired-personal-data {--dry-run : Report what would be purged without changing data}';

    protected $description = 'Apply configured retention rules to user-submitted personal data.';

    public function handle(): int
    {
        $this->info('Retention purge skeleton ready. Phase-specific models will register their rules as they are built.');

        return self::SUCCESS;
    }
}
