<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

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
        if ($this->confirm("Are you 100% sure you want to make this person admin?")) {
            # code...
            $email = $this->ask('Email');
            
            $user = User::query()->where('email', $email)->first();

            if (! $user) {
                $user = User::create([
                    'name' => $this->ask('Name'),
                    'email' => $email,
                    'password' =>Hash::make($this->secret('Password')),
                ]);
            }
            
            $role = Role::query()->where('name', 'admin')->firstOrCreate(['name' => 'admin']);
            
            $user->assignRole($role);
            
            $this->info("Listo!");
        } else {
            $this->warn("Cancelled");
        }
    }
}
