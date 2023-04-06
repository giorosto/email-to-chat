<?php

namespace Database\Seeders;

use App\Models\EmailMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmailMessage::create([
            'body' => 'Hello Dear John Doe',
            'from' => '1',
            'to' => '2',
            'was_replied' => 0,
        ]);
    }
}
