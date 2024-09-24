<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MoviesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($movie) {
                return [
                    "id" => $movie->id,
                    "name" => $movie->name,
                    "released_at" => $movie->released_at,
                    "posteUrl" => $movie->poster_url,
                    "synopsis" => $movie->synopsis,
                    "duration" => $movie->duration,
                    "averageRating" => $movie->average_rating,
                    "url" => $movie->url,

                    // Access related directors, cast members, etc.
                    "directors" => $movie->directors->map(function ($director) {
                        return [
                            "director" => $director->director_name,
                        ];
                    }),

                    "castMembers" => $movie->cast_members->map(function ($cast_member) {
                        return [
                            "cast" => $cast_member->cast_name,
                        ];
                    }),

                    "genres" => $movie->genres->map(function ($genre) {
                        return [
                            "genre" => $genre->genre_name,
                        ];
                    }),

                    "languages" => $movie->languages->map(function ($language) {
                        return [
                            "language" => $language->language_name,
                        ];
                    }),
                ];
            }),
        ];
    }
}
