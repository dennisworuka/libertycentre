<?php

namespace App\Models;

use App\Concerns\LogsAdminActivity;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property string|null $two_factor_secret
 * @property array<int, string>|null $two_factor_recovery_codes
 */
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, LogsAdminActivity, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_secret' => 'encrypted',
            'two_factor_recovery_codes' => 'encrypted:array',
            'two_factor_confirmed_at' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    public function hasTwoFactorEnabled(): bool
    {
        return ! is_null($this->two_factor_confirmed_at);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['super_admin', 'editor', 'recruiter', 'newsletter_manager', 'viewer']);
    }

    /**
     * No exceptions: every account is provisioned with 2FA the moment it is
     * created (non-negotiable #10), not via a separate self-service
     * enrolment step. Callers that already set a secret (the seeder) are
     * left alone.
     */
    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (! empty($user->two_factor_secret)) {
                return;
            }

            $user->two_factor_secret = (new Google2FA)->generateSecretKey();
            $user->two_factor_recovery_codes = collect(range(1, 8))
                ->map(fn () => Str::upper(Str::random(4).'-'.Str::random(4)))
                ->all();
            $user->two_factor_confirmed_at = now();
        });
    }
}
