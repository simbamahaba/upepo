<?php

namespace Simbamahaba\Upepo\Console\Commands;

use Illuminate\Console\Command;
use Simbamahaba\Upepo\Models\Admin;
use Illuminate\Support\Facades\Hash;
class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin {email=admin@laravel.com} {password=parola} {name=Admin} {--I|info}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates admin account';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if($this->option('info') == false) {
            $message = 'Admin account created with DEFAULT settings.';
            if ($this->confirm('Do you wish to specify admin\'s details?')) {
                $name = $this->ask('Enter admin\'s name');
                $email = $this->ask('Enter admin\'s email');
                $password = $this->ask('Enter admin\'s password');
                $this->newLine();
                $this->line('+------------------------------');
                $this->line('| NAME: ' . $name);
                $this->line('| EMAIL: ' . $email);
                $this->line('| PASSWORD: ' . $password);
                $this->line('+------------------------------');
                $this->newLine();
                if ($this->confirm('Everything OK?')) {
                    $message = 'Admin account created with PROVIDED settings.';
                } else {
                    $message = 'Admin account not created.';
                    $this->info('Admin account not created.');
                    return 0;
                }
            } else {
                $email = $this->argument('email');
                $password = $this->argument('password');
                $name = $this->argument('name');
            }

            $admin = new Admin();
            $admin->name = $name;
            $admin->email = $email;
            $admin->password = Hash::make($password);
            $admin->created_at = now();
            $admin->save();

            $this->info('Congrats! You can login now at yoursite/admin/login. Enjoy!');
            $this->info($message);
        }
        $admins = Admin::select('name','email','created_at')->get();
        $header = ['name','email','created_at'];
        $this->table($header, $admins);

    }
}
