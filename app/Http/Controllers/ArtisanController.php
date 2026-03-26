<?php

namespace App\Http\Controllers;

use App\Models\Artisan;
use Illuminate\Http\Request;


class ArtisanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artisans = Artisan::orderBy('id', 'desc')->paginate(10);
        //وظيفتها ترجع فيو

        return response()->view('cms.artisan.index' , compact('artisans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //نننl

        return response()->view('cms.artisan.create');
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
    public function show($id)
    {
        //
        $artisans = Artisan::findOrFail($id);
        return response()->view('cms.artisan.show' , compact('artisans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $artisans = Artisan::findOrFail($id);
        return response()->view('cms.artisan.edit' , compact('artisans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artisan $artisan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artisan $artisan)
    {
        //
    }
}
