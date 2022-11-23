<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Visibility;

class VisibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $visibilities=[
            ['id'=> '1','name'=>'public'],
            ['id'=> '2','name'=>'contacts'],
            ['id'=> '3','name'=>'private']
        ];
    }
}
