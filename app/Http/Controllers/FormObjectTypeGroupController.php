<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\FormObjectTypeGroup;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Validator;
use App\Http\Resources\FormObjectGroupResource;
use App\Traits\RequestTraits;
use App\Traits\PaginationTraits;

class FormObjectTypeGroupController extends BaseController
{
    use RequestTraits;
    use PaginationTraits;
    public function index(Request $request)
    {
        $perPage = $request->get('page_size', '');
        $page = $request->get('page', 1);
        $orderby = $request->get('orderby', 'desc');
        $search = $request->get('search', '');
        if (empty($perPage)) {
            $perPage = $this->perPage;
        }
        $offset = $this->getOffset($page,$perPage);
        // $total = FormObjectTypeGroup::where('is_active',true)->count();
        $total = FormObjectTypeGroup::when(!empty($search), function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->where('is_active',true)->count();
        
        $data = FormObjectTypeGroup::when(!empty($search), function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->where('is_active',true)->with('formObjectType')->skip($offset)->take($perPage)->orderBy('id', $orderby)
        ->get();
        $data = FormObjectGroupResource::collection($data);
        $pagination = $this->getPaginationFormate($total,$perPage,$page);
        $result = $this->getDataWithPagination($data,$pagination);
  
        $this->setResponseCode(200);
        $this->apiResponse['message'] ='Form object type groups get successfully';
        $this->apiResponse['result'] = $result;
        
        return $this->sendResponse();
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:form_object_type_groups',
            'form_object_types' => 'required|numeric',
            'machine_name'=>'required'
        ]);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $data = new FormObjectTypeGroup();
            $data->name = $request->name;
            $data->machine_name = $request->machine_name;
            $data->form_object_type_id = $request->form_object_types;
            $data->save(); 

            $this->setResponseCode(201);
            $this->apiResponse['message'] ='Form object type groups created successfully';
            $this->apiResponse['result'] = $data;

        }
        return $this->sendResponse();
    }


    public function show(string $id)
    {
        $data = FormObjectTypeGroup::where('is_active',true)->with('formObjectType')->find($id);
        if (is_null($data)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;

        }else{
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Form object type groups data get successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }


    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'form_object_types' => 'required|numeric',
            'machine_name'=>'required'
        ]);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $data = FormObjectTypeGroup::find($id);
            if (is_null($data)) {
                $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;
    
            }else{
                $data->name = $request->name;
                $data->form_object_type_id = $request->form_object_types;
                $data->machine_name = $request->machine_name;
                $data->save(); 

                $this->setResponseCode(200);
                $this->apiResponse['message'] ='Form object type groups updated successfully';
                $this->apiResponse['result'] = $data;
            }
        }
        return $this->sendResponse();
    }


    public function destroy(string $id)
    {
        $FormObjectType = FormObjectTypeGroup::find($id);
        if(!empty($FormObjectType)){
            $FormObjectType->delete();
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Form object type groups deleted successfully';
        }else{
            $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;
        }
        return $this->sendResponse();
    }

    public function getList(Request $request)
    {
        $objectType = $request->get('obect_type_id', '');
        $data = FormObjectTypeGroup::when(!empty($objectType), function ($query) use ($objectType) {
            return $query->where('form_object_type_id', $objectType );
        })
        ->where('is_active',true)->get();
        $data = FormObjectGroupResource::collection($data);
        $this->setResponseCode(200);
        $this->apiResponse['message'] ='Form object type groups get successfully';
        $this->apiResponse['result'] = $data;
        
        return $this->sendResponse();

    }
}
