<?php

namespace Modules\Users\App\Resources;

use App\Http\Resources\FileManagemer;
use Dash\Models\FileManagerModel;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {

        $user_type = $this->user_type;
        $data = [];
        if ($user_type == 'dooner') {
            $data['full_name']     = $this->full_name;
            $data['first_name']     = $this->first_name;
            $data['last_name']      = $this->last_name;
        } elseif ($user_type == 'charity') {
            $userId = auth('api')->id();
            $files = FileManagerModel::where('user_id', $userId)->get();
            $data['charity_name']  = $this->charity_name;
            $data['charity_name_translations']  = array_map(function ($item) {
                return [
                    'locale' => $item['locale'],
                    'charity_name' => $item['charity_name']
                ];
            }, $this->translations->toArray());

            // $data['attachments']   =   FileManagemer::collection($this->files);
            $data['attachments']   =   FileManagemer::collection($files);
        }
        $data = array_merge($data, [
            "id"                => $this->id,
            "email"             => $this->email,
            "mobile"            => $this->mobile,
            "account_status"    => $this->account_status,
            "user_type"         => $this->user_type,
            "photo"             => $this->photo == null ? url('/storage/user.svg') :  $this->photo,
            "country" =>  [
                'id' => $this?->country?->id,
                'name' => $this?->country?->name
            ],
        ]);
        return $data;
    }
}
