<?php

use App\Company;
use App\EmployeeGroup;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create(
        [
            'package_id' => 6,
            'company_name' => 'Cut & Style Salon',
            'company_email' => 'cutandstyle@example.com',
            'company_phone' => '1234512345',
            'address' => 'Jaipur, India',
            'date_format' => 'd-m-Y',
            'time_format' => 'h:i a',
            'logo' => 'company.png',
            'website' => 'http://www.abc.com',
            'timezone' => 'Asia/Kolkata',
            'currency_id' => '1',
            'locale' => 'en',
            'status' => 'active',
            'verified' => 'yes',
            'popular_store' => '1'
        ]);

        $path = base_path('public/' . 'user-uploads' . '/company-logo/');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path);
        }

        File::copy(public_path('front/images/company.png'), public_path('user-uploads/company-logo/company.png'));

        $adminRole1 = Role::select('id', 'name')->where(['name' => 'administrator', 'company_id' => 1])->first();
        $employeeRole1 = Role::select('id', 'name')->where(['name' => 'employee', 'company_id' => 1])->first();

        //insert admin
        $admin1 = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => '123456',
            'company_id' => 1,
        ]);
        $admin1->attachRole($adminRole1->id);

        //insert employees
        $employee1 = new User();
        $employee1->name = 'Malik Griffith';
        $employee1->email = 'malik@example.com';
        $employee1->password = '123456';
        $employee1->mobile = '1111';
        $employee1->company_id = 1;
        $employee1->save();

        // add default employee role
        $employee1->attachRole($employeeRole1->id);

    }
}
