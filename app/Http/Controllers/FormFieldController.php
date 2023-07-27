<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\FormField;
use App\Models\FormObjectType;
use App\Models\FormObjectTypeGroup;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Http\Resources\FormFieldsResource;
use App\Traits\RequestTraits;
use App\Traits\PaginationTraits;

class FormFieldController extends BaseController
{
    use RequestTraits;
    use PaginationTraits;

    public function index(Request $request)
    {
        $perPage = $request->get('page_size', '');
        $page = $request->get('page', 1);
        $orderby = $request->get('orderby', 'desc');
        $search = $request->get('search', '');
        $obejctType = $request->get('objectType', '');
        if (!empty($search)) {
            $objectIdArr = $this->getObjectId($search);
            $gropupIdArr = $this->getGroupId($search);
        }else {
            $objectIdArr = null;
            $gropupIdArr = null;
        }
        if (empty($perPage)) {
            $perPage = $this->perPage;
        }
        $offset = $this->getOffset($page,$perPage);
        $total = FormField::when(!empty($search), function ($query) use ($search) {
            return $query->where(function ($query) use ($search) {
                $query->where('label_description', 'like', '%' . $search . '%')
                    ->orWhere('label_name', 'like', '%' . $search . '%')
                    ->orWhere('field_type', 'like', '%' . $search . '%');
            });
        })
        ->when(!empty($objectIdArr), function ($query) use ($objectIdArr) {
            return $query->orWhereIn('object_id', $objectIdArr);
        })
        ->when(!empty($gropupIdArr), function ($query) use ($gropupIdArr) {
            return $query->orWhereIn('group_id', $gropupIdArr);
        })
        ->when(!empty($obejctType), function ($query) use ($obejctType) {
            return $query->where('object_id', $obejctType);
        })
        ->where('is_deleted',false)->count();

        $data = FormField::when(!empty($search), function ($query) use ($search) {
            return $query->where(function ($query) use ($search) {
                $query->where('label_description', 'like', '%' . $search . '%')
                    ->orWhere('label_name', 'like', '%' . $search . '%')
                    ->orWhere('field_type', 'like', '%' . $search . '%');
            });
        })
        ->when(!empty($obejctType), function ($query) use ($obejctType) {
            return $query->where('object_id', $obejctType);
        })
        ->when(!empty($objectIdArr), function ($query) use ($objectIdArr) {
            return $query->orWhereIn('object_id', $objectIdArr);
        })
        ->when(!empty($gropupIdArr), function ($query) use ($gropupIdArr) {
            return $query->orWhereIn('group_id', $gropupIdArr);
        })
        ->where('is_deleted',false)->with('formObjectType')->with('formObjectTypeGroup')->skip($offset)->take($perPage)->orderBy('id', $orderby)
        ->get();

        $pagination = $this->getPaginationFormate($total,$perPage,$page);
        $result = $this->getDataWithPagination($data,$pagination);

        $this->setResponseCode(200);
        $this->apiResponse['message'] ='Form Fields get successfully';
        $this->apiResponse['result'] = $result;

        return $this->sendResponse();
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data_type' => 'required',
            'field_type' => 'required',
            'form_object_type_id' => 'required',
            'form_object_type_group_id' => 'required',
            'validation_rules' => 'required',
            'label_name' => [
                'required',
                Rule::unique('form_fields')->where(function ($query) use ($request) {
                    return $query->where('object_id', $request->form_object_type_id)
                                 ->where('group_id', $request->form_object_type_group_id);
                }),
            ],
        ]);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $jsonData = json_encode($request->validation_rules);
            $field_values = json_encode($request->field_values);
            $objectId = $request->form_object_type_id;
            $objectGroupId = $request->form_object_type_group_id;
            $dataType = $request->data_type;
            $parentTableName  = $this->getParentTableName($objectId);
            $newColumnName = Str::camel($request->label_name);

            if ($parentTableName == "product_category") {
                $this->addColumn('product_categories',$newColumnName,$dataType);
                $newTableName = "product_categories";
            }else{
                $chaldTableName  = $this->getObjectMachineName($objectGroupId);
                $newTableName = $this->createNewTableIfexistAddColumn($parentTableName,$chaldTableName,$newColumnName,$dataType);
            }

            $data = new FormField();
            $inputName = $newColumnName;
            $data->label_name = $request->label_name;
            $data->label_description = $request->label_description;
            $data->field_type = $request->field_type;
            $data->object_id = $objectId;
            $data->group_id = $objectGroupId;
            $data->validation_rules = $jsonData;
            $data->field_values = $field_values;
            $data->input_name = $inputName;
            $data->table_name = $newTableName;
            $data->save();

            $this->setResponseCode(201);
            $this->apiResponse['message'] ='Form Field created successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }

    public function show(string $id)
    {
        $data = FormField::where('is_deleted',false)->with('formObjectType')->with('formObjectTypeGroup')->find($id);
        if (is_null($data)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;

        }else{
            $this->setResponseCode(200);
            $data['validation_rules'] =json_decode($data->validation_rules);
            $data['field_values'] =json_decode($data->field_values);
            $data = new FormFieldsResource($data);

            $this->apiResponse['message'] ='Form field data get successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'label_description' => 'required',
            'field_type' => 'required',
            'form_object_type_id' => 'required',
            'form_object_type_group_id' => 'required',
            'validation_rules' => 'required',
            'label_name' => [
                'required',
                Rule::unique('form_fields')->where(function ($query) use ($request,$id) {
                    return $query->where('object_id', $request->form_object_type_id)
                        ->where('group_id', $request->form_object_type_group_id)
                        ->whereNot('id', $id);
                }),
            ],
        ]);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $jsonData = json_encode($request->validation_rules);
            $field_values = json_encode($request->field_values);
            $inputName = Str::camel($request->label_name);
            $data = FormField::find($id);
            
            if (is_null($data)) {
                $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;

            }else {
                $objectId = $request->form_object_type_id;
                $objectGroupId = $request->form_object_type_group_id;
    
                $parentTableName  = $this->getParentTableName($objectId);
                $chaldTableName  = $this->getObjectMachineName($objectGroupId);
                $newColumnName = Str::camel($request->label_name);
                $oldTableName = $data['table_name'];
                $oldColumnName = $data['input_name'];
                $oldGroupId = $data['group_id'];
                $oldObjectId = $data['object_id'];
                
                $isChangeObject = $this->isChange($oldObjectId,$objectId);
                $isChangeGroup = $this->isChange($oldGroupId,$objectGroupId);
                $newTableName = '';
                if ($isChangeObject || $isChangeGroup) {
                    $newTableName = $this->createNewTableIfexistAddColumn($parentTableName,$chaldTableName,$newColumnName);
                    $successfully = $this->moveData($oldTableName,$newTableName,$oldColumnName,$newColumnName,$objectId);
                    if ($successfully) {
                        $this->removeColumn($oldTableName,$oldColumnName);
                    }
                }else{
                    $this->updateColumn($oldTableName,$newColumnName,$oldColumnName);
                    $newTableName = $oldTableName;
                }

                $data->label_name = $request->label_name;
                $data->label_description = $request->label_description;
                $data->field_type = $request->field_type;
                $data->object_id = $objectId;
                $data->group_id = $objectGroupId;
                $data->validation_rules = $jsonData;
                $data->field_values = $field_values;
                $data->table_name = $newTableName;
                $data->input_name = $newColumnName;
                $data->save();

                $this->setResponseCode(200);
                $this->apiResponse['message'] ='Form Field updated successfully';
                $this->apiResponse['result'] = $data;
            }
        }
        return $this->sendResponse();
    }

    public function destroy(string $id)
    {
        $FormField = FormField::find($id);
        if(!empty($FormField)){
            $FormField->delete();
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Form Fields deleted successfully';
        }else{
            $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;
        }
        return $this->sendResponse();
    }

    public function getForm(Request $request)
    {
        $objectType = $request->get('obect_type_id', '');
        $groupId = $request->get('group_id', '');

        if (empty($objectType)) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = 'Object Type id is required';
            $this->apiResponse['status'] = FALSE;
        }else {
            $data = FormField::where('is_deleted',false)->where('object_id',$objectType)
            ->when($groupId, function ($query) use ($groupId) {
                return $query->where('group_id', $groupId);
            })
            ->with('formObjectType')->with('formObjectTypeGroup')->get();
            if (is_null($data)) {
                $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;

            }else{
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['validation_rules'] =json_decode($data[$i]->validation_rules);
                    $data[$i]['field_values'] =json_decode($data[$i]->field_values);
                }
                $this->setResponseCode(200);
                $this->apiResponse['message'] ='Form field data get successfully';
                $this->apiResponse['result'] = $data;
            }
        }
        return $this->sendResponse();

    }
    public function getObjectId(string $search){
        $objectId = [];
        $data = FormObjectType::select('id')->where('is_active',true)
        ->where('name', 'like', $search . '%')->get();
        foreach ($data as $key => $value) {
            array_push($objectId,$value->id);
        }
        return $objectId;
    }
    public function getGroupId(string $search){
        $groupdId = [];
        $data = FormObjectTypeGroup::select('id')->where('is_active',true)
        ->where('name', 'like', $search . '%')->get();
        foreach ($data as $key => $value) {
            array_push($groupdId,$value->id);
        }
        return $groupdId;
    }
}
