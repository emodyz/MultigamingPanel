<?php

//TODO: Move this into Cerberus

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RoleExists implements Rule
{
    private \Illuminate\Support\Collection $roles;
    private string $role;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->roles = collect(config('cerberus.roles'));
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->role = $value;
        return $this->roles->has($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Unknown Role: '. $this->role .' !';
    }
}
