<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContestController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contests = Contest::with('user') -> get() -> sortByDesc('created_at');
        return view("contests.index", ['contests' => $contests]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contest $contest)
    {
        $access = $contest->characters->some(function ($character){
            return $character -> user_id === Auth::user() -> id;
        });
        if ($access){
            return view('contests.show',['contest'=>$contest]);
        }else{
            return Redirect::to('/');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contest $contest,$attackType)
    {
        $this -> authorize('update',$contest);
        $history = collect(json_decode($contest->history,true));
        $hero = $contest->characters->firstWhere('enemy',0);
        $enemy = $contest->characters->firstWhere('enemy',1);
        $damage = $this->damageCalculator($request->attackType,$hero,$enemy);
        $enemyHp = $contest->characters[0]->pivot->enemy_hp - $damage;
        $history->add(sprintf("%s: %s attack - %.1f damage" ,$enemy->name,$request->attackType,$damage));
        if ($enemyHp <=0) {
            $enemyHp = 0;
            $contest->win = 1;
            $history->add(sprintf("%s killed %s " ,$hero->name,$enemy->name));
        }else{
            $attack_types = ['meele', 'ranged', 'special'];
            $enemyAttackType = $attack_types[rand(0,2)];
            $damage = $this->damageCalculator($enemyAttackType,$enemy,$hero);
            $heroHp = $contest->characters[0]->pivot->hero_hp - $damage;
            $history->add(sprintf("%s: %s attack - %.1f damage" ,$enemy->name,$enemyAttackType,$damage));
            if ($heroHp <=0) {
                $heroHp = 0;
                $contest->win = 0;
                $history->add(sprintf("%s killed %s " ,$enemy->name,$hero->name));
            }
            else{
                $contest -> win = null;
            }
        }
        $contest -> history =json_encode($history);
        $contest -> save();
        $contest -> characters() -> sync([$enemy->id => ['enemy_hp'=>$enemyHp,'hero_hp'=>$heroHp],$hero->id =>['hero_hp'=>$heroHp,'enemy_hp'=>$enemyHp]]); // n:n
        return Redirect::to('/contests/'.$contest->id);
    }

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contest $contest)
    {
        //
    }
}
