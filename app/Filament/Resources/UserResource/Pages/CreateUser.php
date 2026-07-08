<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\HtmlString;
use PragmaRX\Google2FAQRCode\Google2FA;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * 2FA is provisioned automatically in User::booted() when the record is
     * created. The secret and recovery codes are only ever shown here, once
     * — relay them to the new user through a separate secure channel.
     */
    protected function afterCreate(): void
    {
        /** @var User $user */
        $user = $this->record;

        $qrCode = (new Google2FA)->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->two_factor_secret,
        );

        Notification::make()
            ->title('2FA enrolment — shown once')
            ->body(new HtmlString(
                '<p>Scan this QR code in an authenticator app, or enter the secret manually. '.
                'This will not be shown again.</p>'.
                '<img src="'.$qrCode.'" alt="" style="margin: 0.5rem 0;">'.
                '<p><strong>Secret:</strong> '.e($user->two_factor_secret).'</p>'.
                '<p><strong>Recovery codes:</strong> '.e(implode(', ', $user->two_factor_recovery_codes)).'</p>'
            ))
            ->warning()
            ->persistent()
            ->send();
    }
}
