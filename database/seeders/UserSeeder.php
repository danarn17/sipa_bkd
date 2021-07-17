<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $webmaster = User::create([
            'name' => 'Danar N',
            'username' => 'webmaster',
            'password' => bcrypt('webmaster')
        ]);
        $webmaster->assignRole('webmaster');

        $webmaster = User::create([
            'name' => 'Admin 1',
            'username' => 'admin',
            'password' => bcrypt('adminrhs123')
        ]);
        $webmaster->assignRole('admin');

        $webmaster = User::create([
            'name' => 'Reguler',
            'username' => 'user',
            'password' => bcrypt('user')
        ]);
        $webmaster->assignRole('reguler');
    }
}
