<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SystemHealthWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New referrals', $this->countIfTableExists('referrals', ['status' => 'New'])),
            Stat::make('New enquiries', $this->countIfTableExists('enquiries', ['status' => 'New'])),
            Stat::make('Job applications', $this->countIfTableExists('applications', ['status' => 'New'])),
            Stat::make('Queue jobs', Schema::hasTable('jobs') ? DB::table('jobs')->count() : 0),
        ];
    }

    private function countIfTableExists(string $table, array $where): int
    {
        if (! Schema::hasTable($table)) {
            return 0;
        }

        return DB::table($table)->where($where)->count();
    }
}
