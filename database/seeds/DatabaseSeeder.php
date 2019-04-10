<?php

use Illuminate\Database\Seeder;
use App\RenderedModel;
use App\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('rendered_models')->delete();

        $statuses = [
            ['id' => 1, 'file_name' => 'pikachu.glb', 'picture' => 'pikachu.png',
          'camera_x' => '1.50', 'camera_y' => '4.00', 'camera_z' => '10.00', 'description' => 'pikachu'],
            ['id' => 2, 'file_name' => 'chess.glb', 'picture' => 'pikachu.png',
          'camera_x' => '1.50', 'camera_y' => '4.00', 'camera_z' => '10.00', 'description' => 'pikachu'],
            ['id' => 3, 'file_name' => 'dragon.glb', 'picture' => 'pikachu.png',
          'camera_x' => '1.50', 'camera_y' => '4.00', 'camera_z' => '10.00', 'description' => 'pikachu'],
            ['id' => 4, 'file_name' => 'rex.glb', 'picture' => 'pikachu.png',
          'camera_x' => '1.50', 'camera_y' => '4.00', 'camera_z' => '10.00', 'description' => 'pikachu'],
            ['id' => 5, 'file_name' => 'starwars.glb', 'picture' => 'pikachu.png',
          'camera_x' => '1.50', 'camera_y' => '4.00', 'camera_z' => '10.00', 'description' => 'pikachu'],
            ['id' => 6, 'file_name' => 'starwars2.glb', 'picture' => 'pikachu.png',
          'camera_x' => '1.50', 'camera_y' => '4.00', 'camera_z' => '10.00', 'description' => 'pikachu'],
            ['id' => 7, 'file_name' => 'telescope.glb', 'picture' => 'pikachu.png',
          'camera_x' => '1.50', 'camera_y' => '4.00', 'camera_z' => '10.00', 'description' => 'pikachu'],

        ];

        $users = [
          ['id' => "1",
          'fname' => "minh",
          'lname' => "nguyen",
          'gender' => "male",
          'email' => "minh@ca.ca",
          'password' => '$2y$10$vXdRSIROQTlsLpLqIN.kP.teKGKo4pVGazI6y685sY0J6VmwWdypu'],

          ['id' => "2",
          'fname' => "John",
          'lname' => "Doe",
          'gender' => "male",
          'email' => "testing@test.com",
          'password' => '$2y$10$d17wqC8M9aW42MCK6tRLleNdZSIqWbF6joa7I3bNX.l0n.jtfzkj6'],

          ['id' => "3",
          'fname' => "Kevin",
          'lname' => "Flower",
          'gender' => "male",
          'email' => "kevin@ca.ca",
          'password' => '$2y$10$d17wqC8M9aW42MCK6tRLleNdZSIqWbF6joa7I3bNX.l0n.jtfzkj6']

        ];
        foreach ($statuses as $status) {
            RenderedModel::create(array(
                'id' => $status["id"],
                'file_name' => $status["file_name"],
                'picture' => $status["picture"],
                'camera_x' => $status["camera_x"],
                'camera_y' => $status["camera_y"],
                'camera_z' => $status["camera_z"],
                'description' => $status["description"],
            ));
        }

        foreach ($users as $user) {
          User::create(array(
            'id' => $user["id"],
            'fname' => $user["fname"],
            'lname' => $user["lname"],
            'email' => $user["email"],
            'gender' => $user["gender"],
            'password' => $user["password"],
          ));
        }
    }
}
