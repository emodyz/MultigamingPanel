<?php

namespace App\Models;

use App\Models\Traits\HasPrimaryKeyAsUuid;
use Laravel\Jetstream\Membership as JetstreamMembership;

class Membership extends JetstreamMembership
{
    use HasPrimaryKeyAsUuid;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}
