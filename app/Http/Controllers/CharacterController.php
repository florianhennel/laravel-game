<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterPostRequest;
use App\Models\Character;
use Illuminate\Auth\Events\Validated;
use Illuminate\Database\Schema\ForeignKeyDefinition;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CharacterController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny',Character::class);
        $user = Auth::user();
        $characters = $user->characters -> sortByDesc('created_at');
        return view("characters.index", ['characters' => $characters]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CharacterPostRequest $request)
    {
        $this ->authorize('create',Character::class);

        $validated = $request->validated();
        $validated['enemy']=$request->has('enemy');
        $validated['user_id'] =Auth::id();

        Character::create($validated);

        return redirect()->route('characters');

    }
    /**
     * Display the specified resource.
     */
    public function show(Character $character)
    {
        $this->authorize('view',$character);
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

        $character -> update($validated);

        return redirect() -> route('characters.show',['character' => $character]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character)
    {
        $this -> authorize('delete', $character);
        $character -> delete();
        return redirect() -> route('characters');
    }

    public function edit(Character $character)
    {
        $this -> authorize('update',$character);
        
        return view('characters.edit',['character' =>$character,'isAdmin'=>Auth::user()->admin]);
    }
    
    public function create()
    {
        $this ->authorize('create',Character::class);

        return view('characters.create',['isAdmin'=>Auth::user()->admin]);
    }
}
