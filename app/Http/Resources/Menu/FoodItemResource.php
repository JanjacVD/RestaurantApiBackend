<?php

namespace App\Http\Resources\Menu;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title' => $this->getTranslation('title', $request->lang),
            'descritpion' => $this->getTranslation('description', $request->lang),
            'price'=>$this->price,
            'order'=>$this->order,
            'alergens'=> AlergenResource::collection($this->whenLoaded('alergen'))
        ];
    }
}
