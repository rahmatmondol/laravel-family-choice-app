<?php

namespace App\Http\Resources;

use App\Http\Resources\CityResource;
use App\Http\Resources\StateResource;
use App\Http\Resources\RegoinResource;

use App\Http\Resources\SubjectResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{

    public function toArray($request)
    {
        return [

            'id'=>  $this->id ,
            'full_name'  => $this->full_name ,
            'email'  => $this->email ,
            'place'  => $this->place ,
            'description'  => $this->description ,
            'experience'  => $this->experience ,
            'price_per_hour'  => $this->price_per_hour ,
            'phone'  => $this->phone ,
            'image'  => $this->image_path ,
            'gender'  => $this->gender ,
            'teacher_type'  => $this->teacher_type ,
            'category'  => new CategoryResource($this->category),
            'subject'  =>  new SubjectResource($this->subject),
            'levels'=> LevelResource::collection($this->levels),
            'city'=> new CityResource($this->city),
            'state'=>  new StateResource($this->state),
            'regoin'=> new RegoinResource($this->regoin),
            'reveiw'=>ReviewResource::collection($this->reviews),
            'total_number_review'=>$this->total_number_review,
            'total_reveiw'=>number_format($this->reviews()->avg('review'),2),

        ];


    }

}
