<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\UserRoleEnum;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => UserRoleEnum::ADMIN ,
            'guard_name' => "web" ,
        ]);
        Role::create([
            'name' => UserRoleEnum::USER ,
            'guard_name' => "web" ,
        ]);

         User::factory(10)->create();
         Article::factory(30)->create();

         $user = User::factory()->create([
             'user_name' => 'Mohammad',
             'email' => 'mhmd@gmail.com',
         ]);

         $user->assignRole(UserRoleEnum::ADMIN);
    }
}
