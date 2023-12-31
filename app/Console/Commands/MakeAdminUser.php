<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class MakeAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trillos:make-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('Email');

        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $this->ask('Name'),
                'email' => $email,
                'password' => Hash::make($this->secret('Password')),
            ]);
        }

        $role = Role::query()->where('name', 'admin')->firstOrCreate(['name' => 'admin']);

        $user->assignRole($role);

        $this->info('Listo!');
    }
}
