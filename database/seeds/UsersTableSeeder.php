<?php
use Lakeview\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$users = array();
		$users[] = array(
			'name' =>'Alec Aldous',
			'email' => 'alecda@gmail.com',
			'password' => '$2y$10$6tMZLn.HF2IbvNM6oRMuROoNvz7pV41VH9A6TbE8bfMREfN7P.dw6',
			'fsUk' => 'alecda@gmail.com',
			'birthday' => '1992-09-25',
			'country' => 'GBR',
			'timezone' => 0,
			'english' => 1,
			'discord' => 1,
			'mic' => 1,
			'otherServer' => 0,
			'experience' => 1,
			'donate' => 1,
			'about' => 'me',
			'whyPartOfTeam' => 'you',
			'member' => 1,
			'role' => 1
			);
		$users[] = array(
			'name' =>'Test McTestFace',
			'email' => 'user@test.com',
			'password' => '$2y$10$6tMZLn.HF2IbvNM6oRMuROoNvz7pV41VH9A6TbE8bfMREfN7P.dw6',
			'fsUk' => 'alecda@gmail.com',
			'birthday' => '1992-09-25',
			'country' => 'GBR',
			'timezone' => 0,
			'english' => 1,
			'discord' => 1,
			'mic' => 1,
			'otherServer' => 0,
			'experience' => 1,
			'donate' => 1,
			'about' => 'me',
			'whyPartOfTeam' => 'you',
			'member' => 1,
			'role' => 1
			);
			
		foreach($users as $user)
		{
			User::create($user);
		}
        
    }
}
