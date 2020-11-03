<?php

namespace App\Models;

use App\Models\Traits\HasPrimaryKeyAsUuid;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasPrimaryKeyAsUuid;
}
