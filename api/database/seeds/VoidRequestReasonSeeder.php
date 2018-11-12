<?php

use Illuminate\Database\Seeder;

class VoidRequestReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB:: table('void_request_reasons')->truncate();
      DB:: table('void_request_reasons') -> insert([
        ["id" => 1, "description" => "Others"],
        ["id" => 2, "description" => "Ticket Refund due to Bus Failure"],
        ["id" => 3, "description" => "Bus Transfer due to Bus Failure"],
        ["id" => 4, "description" => "Ticket Refund"]
      ]);

    }
}
