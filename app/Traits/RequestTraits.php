<?php
namespace App\Traits;
use App\Models\FormObjectType;
use App\Models\FormField;

trait RequestTraits
{
    public function getRequestData($requestData){
        $data = [];
        for ($i=0; $i < count($requestData); $i++) {
            foreach ($requestData[$i]['data'] as $key => $value) {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    public function validationRuleDynamically($modelName,$groupId = null){
        $objId = $this->getObjectId($modelName);
        $rules = [];
        $data = FormField::select('validation_rules','input_name')->where('is_deleted',false)->where('object_id',$objId)
        ->when($groupId, function ($query) use ($groupId) {
            return $query->whereIn('group_id', $groupId);
        })
        ->with('formObjectType')->with('formObjectTypeGroup')->get();
        for ($i=0; $i < count($data); $i++) {
            $data[$i]['validation_rules'] =json_decode($data[$i]->validation_rules);
            $data[$i]['field_values'] =json_decode($data[$i]->field_values);
            $isR = $data[$i]['validation_rules']->is_required ? 'required|' : '';
            $isM = $data[$i]['validation_rules']->min ? ('min:'.$data[$i]['validation_rules']->min.'|'): ' ';
            $isMa = $data[$i]['validation_rules']->max ? ('max:'.$data[$i]['validation_rules']->max.'|') : ' ';
            $isN= $data[$i]['validation_rules']->is_numeric? 'numeric|' :' ';
            $isC = $data[$i]['validation_rules']->is_character ? 'regex:/^[A-Za-z0-9]+$/':' ' ;

            $rules[$data[$i]['input_name']] =  $isR.$isM.$isMa.$isN.$isC;
        }
        return $rules;
    }

    public function getObjectId($objectName){
        $objId = FormObjectType::select('id')->where('machine_name', '=', $objectName)->first()->id;
        return $objId;
    }

    public function getTableName($objectId){
        $Data = FormField::select('table_name')->where('object_id',$objectId)->groupBy('table_name')->get();
        $data = [];
        foreach ($Data as $key => $value) {
            array_push($data,$value->table_name);
        }
        return $data;
    }
}
