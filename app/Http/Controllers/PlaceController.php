<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Symfony\Contracts\Service\Attribute\Required;

class PlaceController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny',Place::class);
        $places = Place::all();
        return view("places.index", ['places' => $places]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $this->authorize('create',Place::class);
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
    ], [
        'required' => 'The :attribute field is required.',
        'image' => 'The :attribute must be an image file.',
        'image.mimes' => 'The :attribute must be a file of type: jpg, jpeg, png, webp.',
        'image.max' => 'The :attribute may not be greater than 10MB.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    
    if ($request->hasFile('image')) {
        $fileName = $request->name . '.' . $request->image->extension();
        $path = $request->file('image')->move(public_path('images'),$fileName);
        Place::create([
            'name'=>$request->name,
            'image'=>"/images/". $fileName ,
        ]);
    }

    return redirect()->route('places');
}

    public function create()
    {
        $this ->authorize('create',Place::class);

        return view('places.create');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Place $place)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {
        $this->authorize('update',$place);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,webp|max:10240',
        ], [
            'required' => 'The :attribute field is required.',
            'image' => 'The :attribute must be an image file.',
            'image.mimes' => 'The :attribute must be a file of type: jpg, jpeg, png, webp.',
            'image.max' => 'The :attribute may not be greater than 10MB.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $validated = $validator->validate();

        if ($request->hasFile('image')) {
            $fileToDelete = public_path('') . $place->image;
            if ($fileToDelete) {
                unlink($fileToDelete);
            }


            $fileName = $validated['name'] . '.' . $request->image->extension();
            $path = $request->file('image')->move(public_path('images'),$fileName);
            $validated['image']= "/images/". $fileName;
        }
        $place -> update($validated);

        return redirect()->route('places');
    }

    public function edit(Place $place)
    {
        $this -> authorize('update',$place);

        return view('places.edit',['place' =>$place]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        $this -> authorize('delete', $place);
        $place -> delete();
        return redirect() -> route('places');
    }
}
