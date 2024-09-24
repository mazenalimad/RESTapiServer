<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Resources\v1\moviesResources;
use App\Http\Resources\v1\MoviesCollection;
use App\Models\movies;
use App\Http\Requests\StoremoviesRequest;
use App\Http\Requests\UpdatemoviesRequest;
use App\Http\Controllers\Controller;
use Request;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = movies::paginate()->load('directors', 'cast_members', 'domains', 'genres', 'languages');
        return response()->json(new MoviesCollection($movies));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoremoviesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoremoviesRequest $request)
    {
        // Create a new movie using mass assignment
        $movie = movies::create($request->validated());

        // Sync the many-to-many relationships if they are provided in the request
        if ($request->has('directors')) {
            $movie->directors()->sync($request['directors']);
        }

        if ($request->has('cast_members')) {
            $movie->cast_members()->sync($request['cast_members']);
        }

        if ($request->has('domains')) {
            $movie->domains()->sync($request['domains']);
        }

        if ($request->has('genres')) {
            $movie->genres()->sync($request['genres']);
        }

        if ($request->has('languages')) {
            $movie->languages()->sync($request['languages']);
        }

        // Return a success response with the created movie
        return response()->json(['message' => 'Movie created successfully', 'movie' => new moviesResources($movie)], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function show($movies)
    {
        //$movies->load('directors', 'cast_members', 'domains', 'genres', 'languages');
        $data = movies::with('directors', 'cast_members', 'domains', 'genres', 'languages')->findOrFail($movies);
        
        return response()->json(new moviesResources($data));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatemoviesRequest  $request
     * @param  \App\Models\movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatemoviesRequest $request, $movies)
    {
        \Log::info($request->all());
        
        // Find the movie by ID and eager load the relationships
        $data = movies::with('directors', 'cast_members', 'domains', 'genres', 'languages')->findOrFail($movies);

        // Update the movie's basic fields (title, release year, etc.)
        $data->update($request->validated());

        // Sync many-to-many relationships if they are present in the request
        if ($request->has('directors')) {
            $data->directors()->sync($request['directors']);
        }

        if ($request->has('cast_members')) {
            $data->cast_members()->sync($request['cast_members']);
        }

        if ($request->has('domains')) {
            $data->domains()->sync($request['domains']);
        }

        if ($request->has('genres')) {
            $data->genres()->sync($request['genres']);
        }

        if ($request->has('languages')) {
            $data->languages()->sync($request['languages']);
        }

        return response()->json(['message' => 'Movie updated successfully', 'movie' => new moviesResources($data)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function destroy($movies)
    {
        $data = movies::findOrFail($movies);
        $data->directors()->detach();
        $data->cast_members()->detach();
        $data->domains()->detach();
        $data->genres()->detach();
        $data->languages()->detach();
        $data->delete();

        return response()->json(['message' => 'Movie deleted successfully'], 200);
    }
}
