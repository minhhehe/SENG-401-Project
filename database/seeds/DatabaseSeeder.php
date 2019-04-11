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

        $renderedModels = [
            [
                'id' => 1,
                'file_name' => 'pikachu.glb',
                'picture' => 'pikachu.png',
                'camera_x' => '1.50',
                'camera_y' => '4.00',
                'camera_z' => '10.00',
                'description' => 'Pikachu'
            ],
            [
                'id' => 2,
                'file_name' => 'chess.glb',
                'picture' => 'chess.png',
                'camera_x' => '1.50',
                'camera_y' => '4.00',
                'camera_z' => '10.00',
                'description' => 'Chess Piece'
            ],
            [
                'id' => 3,
                'file_name' => 'dragon.glb',
                'picture' => 'dragon.png',
                'camera_x' => '1.50',
                'camera_y' => '4.00',
                'camera_z' => '10.00',
                'description' => 'Dragon'
            ],
            [
                'id' => 4,
                'file_name' => 'rex.glb',
                'picture' => 'rex.png',
                'camera_x' => '1.50',
                'camera_y' => '4.00',
                'camera_z' => '10.00',
                'description' => 'T-Rex'
            ],
            [
                'id' => 5,
                'file_name' => 'starwars.glb',
                'picture' => 'starwars.png',
                'camera_x' => '1.50',
                'camera_y' => '4.00',
                'camera_z' => '10.00',
                'description' => 'Star Wars BB-8'
            ],
            [
                'id' => 6,
                'file_name' => 'starwars2.glb',
                'picture' => 'starwars2.png',
                'camera_x' => '1.50',
                'camera_y' => '4.00',
                'camera_z' => '10.00',
                'description' => 'Star Wars BB-9E'
            ],
            [
                'id' => 7,
                'file_name' => 'telescope.glb',
                'picture' => 'telescope.png',
                'camera_x' => '1.50',
                'camera_y' => '4.00',
                'camera_z' => '10.00',
                'description' => 'Telescope'
            ],
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
        foreach ($renderedModels as $renderModel) {
            RenderedModel::create(array(
                'id' => $renderModel["id"],
                'file_name' => $renderModel["file_name"],
                'picture' => $renderModel["picture"],
                'camera_x' => $renderModel["camera_x"],
                'camera_y' => $renderModel["camera_y"],
                'camera_z' => $renderModel["camera_z"],
                'description' => $renderModel["description"],
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
