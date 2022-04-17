<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Traits\AuthenticateCustomer;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
  use AuthenticateCustomer;
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */

  public function toArray($request)
  {

    $tokenResult = $this->createAuthToken($this);
    return [

      'id' => $this->id,
      'full_name' => $this->full_name,
      'email' => $this->email,
      'phone' => $this->phone,
      'image' => $this->image_path,
      'firebaseToken' => $this->firebaseToken,
      'gender' => (string) $this->gender,
      'lat' => (string) $this->lat,
      'lng' => (string) $this->lng,

      'city' => new CityResource($this->city),
      'created_at' => (string) $this->created_at,

      // auth data
      'verified' => (bool) $this->verified,
      'access_token' =>  $tokenResult->accessToken,
      'token_type' =>  'Bearer',
      'expires_at' =>  Carbon::parse(
        $tokenResult->token->expires_at
      )->toDateTimeString()

    ];
  }
}
