<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {userName} {email} {password} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $userName = $this->argument('userName');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $role = $this->argument('role');

        if (!array_key_exists($role, config('cerberus.roles'))) {
            $this->error('Unknown role: '. $role);
            return 1;
        }

        if (User::withTrashed()->where('email', $email)->exists()) {
           $this->error('A user has already been registered using the following email address: '. $email);
           return 1;
        }

        User::create([
            'name' => $userName,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'role' => $role,
        ]);

        $this->info('A new user has benn successfully registered!');
        $this->line('<fg=cyan>UserName: <fg=yellow>'. $userName);
        $this->line('<fg=cyan>Email: <fg=yellow>'. $email);
        $this->line('<fg=cyan>Password: <fg=yellow>'. $password);
        $this->line('<fg=cyan>Role: <fg=yellow>'. $role);

        return 0;
    }
}
