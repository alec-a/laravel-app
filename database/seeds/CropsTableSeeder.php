<?php
use Lakeview\Crops;
use Illuminate\Database\Seeder;

class CropsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $crops = array('Stubble','Wheat','Barley','Canola','Maize','Soy Bean','Sugar Beet','Potato','Grass','Radish','Poplar','Cotton','Oats','Sugarcane');
		
		foreach($crops as $crop){
			Crops::create(['name' => $crop]);
		}
    }
}
