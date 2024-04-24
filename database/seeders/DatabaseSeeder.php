<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Contest;
use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Node\Expr\Cast\Array_;

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
                'admin' => rand(1, 5) < 2
            ]);
            $users -> where('admin','=',1) ->count() == 0 && $user -> admin = 1;
            $users -> where('admin','=',0) ->count() == 0 && $user -> admin = 0;
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
                'user_id' => $users ->where('admin','=',1)->isNotEmpty() ? ($users ->where('admin','=',1) -> random() -> id ):null,
            ]);
            $characters -> add($character);
        }
        for ($i=0; $i < 5; $i++) {
            $enemy = $characters -> where('enemy','=',1) -> random();
            $notEnemy = $characters -> where('enemy','=',0) -> random();
            $enemy -> hp = 20;
            $notEnemy -> hp = 20;

            $attack_types = ['meele', 'ranged', 'special'];
            $history = collect();
            $j = 0;
            $rounds = rand(1,10);
            while ($j < $rounds && ($enemy -> hp >0 && $notEnemy ->hp >0)) {
                $heroAttackType = $attack_types[rand(0,2)];
                $damage = $this->damageCalculator($heroAttackType,$notEnemy,$enemy);
                $enemy -> hp =$enemy->hp-$damage>=0?$enemy->hp-$damage:0;
                $history->add(sprintf("%s: %s attack - %.1f damage" ,$notEnemy->name,$heroAttackType,$damage));
                if ($enemy->hp> 0) {
                    $enemyAttackType = $attack_types[rand(0,2)];
                    $damage = $this->damageCalculator($enemyAttackType,$enemy,$notEnemy);
                    $notEnemy -> hp =$notEnemy->hp-$damage>=0?$notEnemy->hp-$damage:0;
                    $history->add(sprintf("%s: %s attack - %.1f damage" ,$enemy->name,$enemyAttackType,$damage));
                    $j++;
                }else{
                    break;
                }
                
            }
            $win = null;
            if ($enemy ->hp >0 && $notEnemy->hp <= 0) {
                $win = false;
            }else if($enemy -> hp <= 0){
                $win = true;
            }

            $contest = Contest::create([
                'win' => $win,
                'history' => json_encode($history),
                'user_id' => $notEnemy -> id,
                'place_id'=> $places -> random() -> id,
            ]);
            $contest -> characters() -> sync(
                [$enemy->id => ['enemy_hp'=>$enemy->hp,'hero_hp'=>$notEnemy->hp,'created_at' => now(), 'updated_at' => now()],$notEnemy->id =>['hero_hp'=>$notEnemy->hp,'enemy_hp'=>$enemy->hp,'created_at' => now(), 'updated_at' => now()]]
            );
        }
    }
    /** 
    * @return float
    */
    private function damageCalculator($attackType,$ATT,$DEF){
        $damage = 0;
        switch ($attackType) {
            case 'meele':
                $damage = (($ATT->strength * 0.7 + $ATT->accuracy * 0.1 + $ATT->magic * 0.1) - $DEF->defence);
                break;
            case 'ranged':
                $damage = (($ATT->strength * 0.1 + $ATT->accuracy * 0.7 + $ATT->magic * 0.1) - $DEF->defence);
                break;
            case 'special':
                $damage = (($ATT->strength * 0.1 + $ATT->accuracy * 0.1 + $ATT->magic * 0.7) - $DEF->defence);
                break;
            default:
                $damage = 0;
                break;
        }
        return $damage>0?$damage:0;
    }
}
