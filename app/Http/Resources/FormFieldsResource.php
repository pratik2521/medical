<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormFieldsResource extends JsonResource
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
            'uuid' => $this->uuid,
            'label_name' => $this->label_name,
            'input_name' => $this->input_name,
            'label_description' => $this->label_description,
            'field_type' => $this->field_type,
            'validation_rules' => $this->validation_rules,
            'field_values' => $this->field_values,
            'object_id' => $this->object_id,
            'object_name'=>$this->formObjectType->name,
            'group_id' => $this->group_id,
            'group_name' => $this->formObjectTypeGroup->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
