<?php

use App\PaymentGatewayCredentials;
use App\Role;
use Illuminate\Database\Seeder;
use App\User;

class DefaultSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Super Admin';
        $user->email = 'superadmin@example.com';
        $user->calling_code = '+91';
        $user->mobile = '1919191919';
        $user->password = '123456';

        $user->save();

        $user->attachRole(Role::select('id', 'name')->where('name', 'superadmin')->first()->id);

        // Add default payment credentials
        PaymentGatewayCredentials::insert([
                'company_id' => null,
        ]);

    }
}
