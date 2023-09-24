<?php
/*
 * Project: sunny-backend
 * File: PaymentTransactionResource.php
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

class PaymentTransactionResource extends JsonResource
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
            "value" => $this->value,
            "type" => $this->type,
            "member_id" => $this->user_id,
            "member" => new UserResource($this->user),
            "admin" => new UserResource($this->createdByUser),
            "payable_id" => $this->payable_id,
            "payable" => optional($this->payable)->toArray(),
            "note" => $this->note,
            "client_name" => $this->client_name,
            "client_email" => $this->client_email,
            "client_phone" => $this->client_phone,
            "created_at" => $this->created_at,
        ];
    }
}
