<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CreateOwner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user:owner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an owner account (max 1)';

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
    public function handle()
    {
        $owner = User::where('user_type','owner')->first();
        if($owner){
            $this->error('Only 1 owner is allowed');
        }
        else{
            $first_name = $this->ask('What is your first name?');
            $last_name = $this->ask('What is your last name?');
            $username = $this->ask('Choose your username.');
            $email = $this->ask('What is your email?');
            $password = $this->secret('Choose your password? (Min: 8 characters)(Press enter when done inputting)');
            while(Str::of($password)->length() < 8){
                $this->error('Password must have minimum of 8 characters');
                $password = $this->secret('Choose your password? (Min: 8 characters)(Press enter when done inputting)');
            }
            $password_confirmation = $this->secret('Confirm the password? (Press enter when done inputting)');
            while($password_confirmation !== $password){
                $this->error('Password and confirmation password does not match.');
                $password = $this->secret('Choose your password? (Min: 8 characters)(Press enter when done inputting)');
                while(Str::of($password)->length() < 8){
                    $this->error('Password must have minimum of 8 characters');
                    $password = $this->secret('Choose your password? (Min: 8 characters)(Press enter when done inputting)');
                }
                $password_confirmation = $this->secret('Confirm the password? (Press enter when done inputting)');
            }
            User::create([
                'user_type' => 'owner',
                'uuid' => (string) Str::uuid(),
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'username' => $username,
                'password' => Hash::make($password),
            ]);
            $this->info('Successfully created your owner account!');
        }
    }
}
