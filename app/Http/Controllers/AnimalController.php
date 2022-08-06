<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $animals = DB::select('select * from animals');
        return $animals;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:10',
        ]);

        $body = $request->all();

        $animals = DB::insert('insert into animals (name) values (?)', [$body["name"]]);
        return $animals;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $animal = DB::select('select * from animals where id = (?)', [$id]);
        return $animal;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:10',
        ]);
        
        $name = $request->input("name");
        if($name) {
            $animalUpdated = DB::update("update animals set name = (?) where id = (?)", [
                $name, $id
            ]);
            return $animalUpdated;
        }
        else {
            return "Animal not found";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $animalDeleted = DB::delete("delete from animals WHERE id = (?)", [$id]);
        return $animalDeleted;
    }
}
