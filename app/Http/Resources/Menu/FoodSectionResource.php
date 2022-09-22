<?php

namespace App\Http\Resources\Menu;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodSectionResource extends JsonResource
{
    /**
     * 
     * 
     * 
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        return [
            'title' => $this->getTranslation('title',  $request->lang),
            'titles' => $this->when($request->lang = null,$this->getTranslations('title')),
            'categories' => FoodCategoryResource::collection($this->whenLoaded('foodCategory')),
            'order'=>$this->order
        ];
    }
}
