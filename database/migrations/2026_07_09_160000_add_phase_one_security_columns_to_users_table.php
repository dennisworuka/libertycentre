<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('google2fa_secret')->nullable()->after('password');
            $table->timestamp('mfa_confirmed_at')->nullable()->after('google2fa_secret');
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
            $table->timestamp('locked_until')->nullable()->after('last_login_ip');
            $table->unsignedInteger('failed_login_attempts')->default(0)->after('locked_until');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn([
                'google2fa_secret',
                'mfa_confirmed_at',
                'last_login_at',
                'last_login_ip',
                'locked_until',
                'failed_login_attempts',
            ]);
        });
    }
};
