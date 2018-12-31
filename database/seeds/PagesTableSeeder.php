<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert(
			[
				'uri' => '/',
				'title' => 'Home',
				'content' => '<div class="content has-text-centered">
<h1 class="title is-1">Lakeview Estate</h1>
<p class="subtitle">Established 2009</p>
</div>'
			]);
    }
}
