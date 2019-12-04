<?php

use Illuminate\Database\Seeder;

class MessageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'initial',
            'final',
        ];

        foreach ($types as $type) {
            \App\Models\MessageType::firstOrCreate([
                'name' => $type
            ]);
        }
    }
}
