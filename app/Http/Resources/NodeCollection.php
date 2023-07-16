<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NodeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $timezone = $request->header('X-Header-Timezone');

        return [
            'timezone' => $timezone,
            'data' => $this->collection,
            // 'links' => [
            //     'self' => 'link-value',
            // ],
        ];
    }
}
