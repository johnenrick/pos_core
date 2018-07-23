<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(ModulesTableSeeder::class);

        $this->call(AccountTypesTableSeeder::class);
        $this->call(ModulesTableSeeder::class);
        $this->call(AccountTypeModulesTableSeeder::class);
        $this->call(AccountsTableSeeder::class);
        // $this->call(CompanyBranchesTableSeeder::class);
        // $this->call(CompanyBranchEmployeesTableSeeder::class);
        // $this->call(QueueFormsTableSeeder::class);
        //$this->call(QueueFormFieldsTableSeeder::class);
        // $this->call(UserTypesSeeder::class);
        Model::unguard();



        Model::reguard();

    }
}
