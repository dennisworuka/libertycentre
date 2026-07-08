<?php

namespace App\Domain\Content\Policies;

class PostPolicy extends ContentPolicy
{
    protected static string $permissionPrefix = 'news';
}
