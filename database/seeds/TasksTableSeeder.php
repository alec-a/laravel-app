<?php
use Lakeview\Task;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = array('1st Fertilizer','2nd Fertilizer','Plow','Lime','Cultivate','Plant','Weed','Harvest','Mow','Ted','Rake','Silage','Bale','Wrap','Stack');
		
		foreach($tasks as $task){
			Task::create(['task' => $task,'options' => '']);
		}
    }
}
