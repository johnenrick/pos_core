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
        Model::unguard();
        $this->call(AccountTypesTableSeeder::class);
        // $this->call(ModulesTableSeeder::class);
        // $this->call(AccountTypeModulesTableSeeder::class);
        // $this->call(AccountsTableSeeder::class);
        $this->call(DiscountSeeder::class);
        $this->call(BusTripExpenseItemSeeder::class);
        $this->call(VoidRequestReasonSeeder::class);
        Model::reguard();

    }
}
