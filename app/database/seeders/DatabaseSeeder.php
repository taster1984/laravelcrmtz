<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\File;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'manager']);

        $manager = User::factory()->create([
            'name' => 'TestManager',
            'email' => 'manager@example.com',
            'password' => 'password',
        ]);
        $manager->assignRole('manager');

        $admin = User::factory()->create([
            'name' => 'TestAdmin',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);
        $admin->assignRole('admin');

        for ($i = 1; $i <= 5; $i++) {
            $customer = Customer::factory()->create();
            $ticket = Ticket::factory()->for($customer)->create([
                'status' => 'new',
            ]);
            for ($j = 1; $j <= 2; $j++) {
                $file = File::factory()->create([
                    'ticket_id' => $ticket->id,
                    'title'     => fake()->sentence(3),
                    'type'      => 'text/plain',
                ]);

                $temp = tmpfile();
                $path = stream_get_meta_data($temp)['uri'];
                file_put_contents($path, 'fake file content');

                $file->addMedia($path)->usingFileName($file->title.".txt")->toMediaCollection('files');
            }
            Ticket::factory()->for($customer)->create([
                'status'=>fake()->randomElement(['in_progress', 'processed']),
            ]);
        }
    }
}
