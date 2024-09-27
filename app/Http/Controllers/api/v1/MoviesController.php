<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Resources\v1\moviesResources;
use App\Http\Resources\v1\MoviesCollection;
use App\Models\movies;
use App\Http\Requests\StoremoviesRequest;
use App\Http\Requests\UpdatemoviesRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $direction = $request->input('direction', 'asc'); // Default to 'asc' if not provided
        $orderby = $request->input('orderby', 'id');
        
        // Paginate the movies, e.g., 10 per page
        $movies = Movies::with(['directors', 'cast_members', 'domains', 'genres', 'languages'])
                            ->orderBy($orderby,$direction)
                            ->paginate(10);

        // Return JSON response with pagination info and movies
        return response()->json([
            'data' => new MoviesCollection($movies),
            'meta' => [
                'total' => $movies->total(),
                'pageSize' => $movies->perPage(),
                'current_page' => $movies->currentPage(),
                'last_page' => $movies->lastPage(),
                'sort'=> [
                    'active' => $orderby,
                    'direction' => $direction,
                ]
            ],
        ]);
    }

    // 'next_page_url' => $movies->nextPageUrl(),
                // 'prev_page_url' => $movies->previousPageUrl(),
                // 'from' => $movies->firstItem(),
                // 'to' => $movies->lastItem(),

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
