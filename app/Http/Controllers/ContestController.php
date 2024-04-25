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
    public function update(Request $request, Contest $contest)
    {
        $this -> authorize('update', $contest);

        $validated = $request -> validate(
            [
                'title' => 'required|min:3',
                'content' => 'required',
                'date' => 'required|before_or_equal:' . now()->format('Y-m-d'),
                // 'user_id' => 'required|integer|exists:users,id',
                'cats[]' => 'array',
                'cats.*' => 'distinct|integer|exists:tags,id'
            ],
            [
                'title.required' => 'Erzsi, nincs cím!',
                'title.min' => 'Erzsi, adj :min betűt!'
            ]
        ); 
        $validated['date'] = \Carbon\Carbon::parse($validated['date']);
        $contest -> update($validated);
        $contest -> tags() -> sync($validated['cats'] ?? []); // n:n
        Session::flash('post-updated', $validated['title']);
        return redirect() -> route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contest $contest)
    {
        //
    }
}
