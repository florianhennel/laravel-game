<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Contest;
use App\Models\Place;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = collect();
        for ($i=0; $i < 10; $i++) { 
            $user = User::create([
                'email' => 'user'.$i.'@szerveroldali.hu',
                'name' => fake('hu_HU') -> name(),
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'is_admin' => rand(1, 5) < 2
            ]);
            $users -> add($user);
        }
        $places = collect();
        for ($i=0; $i < 5; $i++) { 
            $place = Place::create([
                'name' => fake('hu_HU') -> name(),
                'image' => fake()->image(null, 640, 480,'architecture'),
            ]);
            $places -> add($place);
        }
        $characters = collect();
        for ($i=0; $i < 10 ; $i++) {
            $skillpoints = 20;
            $enemy = rand(1, 2) == 1;
            $attributes = ['defence' => 0, 'strength' => 0, 'accuracy' => 0, 'magic' => 0];
            while ($skillpoints > 0) {
                $randomAttribute = array_rand($attributes);
                $addSkillPoints = rand(1, $skillpoints);
                $attributes[$randomAttribute] += $addSkillPoints;
                $skillpoints -= $addSkillPoints;
            }
            $character = Character::create([
                'name' => fake('hu_HU') -> userName(),
                'enemy' => $enemy,
                'defence' => $attributes['defence'],
                'strength' => $attributes['strength'],
                'accuracy' => $attributes['accuracy'],
                'magic' => $attributes['magic'],
                'user_id' => $users ->where('admin','=',true)->isNotEmpty() ? ($users ->where('admin','=',true) -> random() -> id ):null,
            ]);
            $characters -> add($character);
        }
        for ($i=0; $i < 5; $i++) { 
            $contest = Contest::create([
                'win' => null,
                'history' => null,
                'user_id' => $users ->where('admin','=',true)->isNotEmpty() ? ($users ->where('admin','=',true) -> random() -> id ):null,
                'place_id'=> $places -> random() -> id,
            ]);
            $contest -> characters() -> sync(
                [$characters -> where('enemy','=','true') -> random() -> pluck('id'),$characters -> where('enemy','=','false') -> random() -> pluck('id')]
            );
        }


        

    }
}
