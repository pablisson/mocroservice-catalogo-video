<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
			'id' => $this->id,
			'name' => $this->name,
			'description' => $this->description,
			'created_at' => Carbon::make($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::make($this->updated_at)->format('Y-m-d H:i:s'),
			'deleted_at' => $this->deleted_at ? Carbon::make($this->deleted_at)->format('Y-m-d H:i:s') : null,
			'is_active' => $this->is_active,
		];
    }
}
