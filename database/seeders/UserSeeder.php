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
            'email' => 'webmaster@uns.ac.id',
            'password' => bcrypt('adminrhs')
        ]);
        $webmaster->assignRole('webmaster');

        $webmaster = User::create([
            'name' => 'Admin 1',
            'email' => 'admin@uns.ac.id',
            'password' => bcrypt('adminrhs')
        ]);
        $webmaster->assignRole('admin');

        $webmaster = User::create([
            'name' => 'Author 1',
            'email' => 'author@uns.ac.id',
            'password' => bcrypt('adminrhs')
        ]);
        $webmaster->assignRole('author');
    }
}
