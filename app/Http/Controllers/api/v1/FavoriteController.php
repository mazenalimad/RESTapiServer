<?php

namespace App\Http\Controllers\api\v1;

use App\Models\favorite;
use App\Models\movies;
use App\Http\Requests\StorefavoriteRequest;
use App\Http\Resources\v1\MoviesCollection;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorites = favorite::where('user_id', request()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch movie details for each favorite movie
        $data = movies::with('directors', 'cast_members', 'domains', 'genres', 'languages')
            ->whereIn('id', $favorites->pluck('movie_id'))
            ->get();

        // Return the movie collection as JSON
        return response()->json(new MoviesCollection($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorefavoriteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorefavoriteRequest $request)
    {
        // Check if the movie exists to avoid saving non-existent movies as favorites
        $movie = movies::find($request->movie_id);

        if (!$movie) {
            return response()->json(['error' => 'Movie not found'], 404);
        }

        // Check if this movie is already in the user's favorites to avoid duplicates
        $existingFavorite = favorite::where('user_id', request()->user()->id)
            ->where('movie_id', $request->movie_id)
            ->first();

        if ($existingFavorite) {
            return response()->json(['error' => 'Movie already in favorites'], 409); // Conflict response
        }

        // Create a new favorite entry
        $favorite = new favorite;
        $favorite->user_id = request()->user()->id;  // Assign the logged-in user's ID
        $favorite->movie_id = $request->movie_id;    // Set the movie ID from the request
        $favorite->save();

        // Return a success response with the created favorite
        return response()->json([
            'message' => 'Favorite added successfully',
            'favorite' => $favorite
        ], 201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\favorite  $favorite
     * @return \Illuminate\Http\Response
     * 
     */
    public function destroy($movieId)
    {
        // Find the favorite associated with the given movie ID
        $favorite = Favorite::where('user_id', request()->user()->id)
                        ->where('movie_id', $movieId)
                        ->delete();


        if (!$favorite) {
            return response()->json(['message' => 'Favorite not found'], 404);
        }
        

        return response()->json(['message' => 'Favorite removed successfully'], 200);
    }
}
