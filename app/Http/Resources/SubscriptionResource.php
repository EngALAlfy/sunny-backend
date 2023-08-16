<?php
/*
 * Project: sunny-backend
 * File: SubscriptionResource.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            'name' => $this->name,
            'duration' => $this->duration,
            'price' => $this->price,
            'photo' => $this->photoName,
            'photoUrl' => $this->photoUrl,
            'pivot' => $this->when(!empty($this->pivot), $this->pivot),
            'benefits' => BenefitResource::collection($this->benefits),
        ];
    }
}
