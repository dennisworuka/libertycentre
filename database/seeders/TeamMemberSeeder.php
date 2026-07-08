<?php

namespace Database\Seeders;

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['name' => 'Dr. Rolland Dankwa', 'role' => 'Director', 'bio' => 'Rolland founded Liberty Centre to give families a genuinely person-centred alternative to institutional care.'],
            ['name' => 'Beatrice Dankwa', 'role' => 'Registered Manager', 'bio' => 'Beatrice leads day-to-day operations and is the named contact for CQC compliance and safeguarding.'],
            ['name' => 'Amara Osei', 'role' => 'Senior Support Worker', 'bio' => 'Amara specialises in autism support and has been with Liberty Centre since 2022.'],
            ['name' => 'James Whitfield', 'role' => 'Senior Support Worker', 'bio' => 'James coordinates our supported living rotas across West Yorkshire.'],
            ['name' => 'Priya Chandra', 'role' => 'Community Outreach Lead', 'bio' => 'Priya builds partnerships with local employers, colleges and community groups.'],
        ];

        foreach ($members as $index => $member) {
            TeamMember::create([
                'name' => $member['name'],
                'role' => $member['role'],
                'bio' => $member['bio'],
                'order' => $index,
                'status' => PublishStatus::Published,
                'published_at' => now(),
            ]);
        }
    }
}
