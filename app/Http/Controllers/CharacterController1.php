<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterPostRequest;
use App\Models\Character;
use App\Models\Contest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Validator;

class CharacterController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $characters = $user->characters -> sortByDesc('created_at');
        return view("characters.index", ['characters' => $characters]);
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
    public function show(Character $character)
    {
        $user = Auth::user();
        if ($character -> user_id == $user->id) {
            $contests = $character->contests()->get();
            return view('characters.show',['character' =>$character,'contests'=>$contests]);
        }else{
            return Redirect::to('/characters');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CharacterPostRequest $request, Character $character)
    {
        $this ->authorize('update',$character);

        $validated = $request->validated();

        $validated['enemy']=$character->enemy;
        $character -> update($validated);

        return redirect() -> route('characters.show',['character' => $character]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character)
    {
        $this -> authorize('delete', $character);
        $character->contests()->detach();
        $character -> delete();
        return redirect() -> route('characters');
    }

    public function edit(Character $character)
    {
        $this -> authorize('update',$character);
        $user = Auth::user();
        if ($character -> user_id == $user->id) {
            return view('characters.edit',['character' =>$character]);
        }else{
            return Redirect::to('/characters');
        }
    }
}
