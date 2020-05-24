<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new \App\User;
        $admin->username = 'admin';
        $admin->name = 'Site Administrator';
        $admin->email = 'admin@larashop.test';
        $admin->roles = json_encode(['ADMIN']);
        $admin->password = \Hash::make('admin');
        $admin->avatar = 'avatars/no-photo.jpg';
        $admin->phone = '-';
        $admin->address = 'Kepanjen, Malang';

        $admin->save();

        $this->command->info('admin user inserted');
    }
}
