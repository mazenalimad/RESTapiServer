<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class moviesResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            "id" => $this->id,
            "name" => $this->name,
            "released_at" => $this->released_at,
            "posterUrl" => $this->poster_url,
            "synopsis" => $this->synopsis,
            "duration" => $this->duration,
            "averageRating" => $this->average_rating,
            "url" => $this->url,
            "directors" => $this->directors->map(function ($director) {
                return [
                    "director" => $director->director_name,  // Assuming 'name' is the field for the director's name
                ];
            }),
            "castMembers" => $this->cast_members->map(function ($cast_member) {
                return [
                    "cast" => $cast_member->cast_name,  // Assuming 'name' is the field for the cast member's name
                ];
            }),
            "domains" => $this->domains->map(function ($domain) {
                return [
                    "domain" => $domain->domain_name,  // Assuming 'name' is the field for the domain's name
                ];
            }),
            "genres" => $this->genres->map(function ($genre) {
                return [
                    "genre" => $genre->genre_name,  // Assuming 'name' is the field for the genre's name
                ];
            }),
            "languages" => $this->languages->map(function ($language) {
                return [
                    "language" => $language->language_name,  // Assuming 'name' is the field for the language's name
                ];
            }),
        ];
    }
}
