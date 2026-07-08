<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Filament Panel Path
    |--------------------------------------------------------------------------
    |
    | Read here (not via env() in AdminPanelProvider) so the path still
    | resolves correctly once config:cache has run in production.
    |
    */

    'path' => env('ADMIN_PATH', 'admin'),

    /*
    |--------------------------------------------------------------------------
    | Seeded Super Admin
    |--------------------------------------------------------------------------
    |
    | Used only by database\seeders\SuperAdminUserSeeder. Never hard-code
    | credentials — set these in .env (never committed).
    |
    */

    'name' => env('ADMIN_NAME', 'Super Admin'),
    'email' => env('ADMIN_EMAIL'),
    'password' => env('ADMIN_PASSWORD'),

];
