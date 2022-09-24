<?php

namespace App\Http\Resources\Menu;

use App\Models\Lang;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {   $translation = $request->lang;
        return [
            'title' => $this->getTranslations('title'),
            'items' => FoodItemResource::collection($this->whenLoaded('foodItem')),
            'order' => $this->order
        ];
    }
}
