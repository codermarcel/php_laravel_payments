<?php

use App\Entity\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( ! User::where('username', 'admin')->first())
        {
            $this->seed();
        }
    }

    /**
     * Seed owners.
     */
    private function seed()
    {
        $registerService = new \App\Service\RegisterService();

        /**
         * Seed admin.
         */
        $admin = factory(App\Entity\User::class, 'admin', 1)->make();
        $admin->id = '5eca1fa1-2027-4136-8759-36f45caa46c6';

        $registerService->fromUser($admin);

        /**
         * Seed some regular owners.
         */
        $users = factory(App\Entity\User::class, 20)->make();

        foreach ($users as $user)
        {
            $registerService->fromUser($user);
        }
    }
}
