<?php

namespace App\Http\Resources;

// use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Stichoza\GoogleTranslate\GoogleTranslate;

class NodeResource extends JsonResource
{
    // array<string, mixed>

    /**
     * Transform the resource into an array.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $timezone = $request->header('X-Header-Timezone', 'America/Caracas');
        // dump($request);
        // dd($request->all());

        $created_at = $this->created_at->setTimezone($timezone)->format('d/F/Y H:i');
        $updated_at = $this->updated_at->setTimezone($timezone)->format('d/F/Y H:i');

        $title = $this->title;
        if ($request->hasHeader('X-Header-Lang')) {
            $tr = new GoogleTranslate();
            $title = $tr
                ->setSource('en')
                ->setTarget($request->header('X-Header-Lang'))
                ->translate($this->title);
        }

        return [
            'id' => $this->id,
            'title' => $title,
            // 'created_at' => $this->created_at,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            // 'parent' => $this->parent()->pluck('id', 'title'),
            // 'parent' => $this->parent()->get(),
            'parent' => $this->parent()->pluck('id'),
            'children' => $this->children()->pluck('id'),
        ];
    }
}
