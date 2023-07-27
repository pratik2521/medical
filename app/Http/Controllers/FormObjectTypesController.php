<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\FormObjectType;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use App\Http\Resources\FormObjectResource;
use App\Traits\RequestTraits;
use App\Traits\PaginationTraits;

class FormObjectTypesController extends BaseController
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
        // $total = FormObjectType::where('is_active',true)->count();
        $total = FormObjectType::when(!empty($search), function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->where('is_active',true)->count();
        
        $data = FormObjectType::when(!empty($search), function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->where('is_active',true)->skip($offset)->take($perPage)->orderBy('id', $orderby)
        ->get();

        $data = FormObjectResource::collection($data);
        $pagination = $this->getPaginationFormate($total,$perPage,$page);
        $result = $this->getDataWithPagination($data,$pagination);
  
        $this->setResponseCode(200);
        $this->apiResponse['message'] ='Form object types get successfully';
        $this->apiResponse['result'] = $result;
        
        return $this->sendResponse();

    }

 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:form_object_types',
            'machine_name' => 'required'
        ]);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $data = new FormObjectType();
            $data->name = $request->name;
            $data->machine_name = $request->machine_name;
            $data->save(); 

            $this->setResponseCode(201);
            $this->apiResponse['message'] ='Form object type created successfully';
            $this->apiResponse['result'] = $data;

        }
        return $this->sendResponse();
    }


    public function show(string $id)
    {
        
        $data = FormObjectType::where('is_active',true)->find($id);
        if (is_null($data)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;

        }else{
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Form object type data get successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'machine_name' => 'required',
        ]);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $data = FormObjectType::find($id);
            if (is_null($data)) {
                $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;
    
            }else{
                $data->name = $request->name;
                $data->machine_name = $request->machine_name;
                $data->save(); 

                $this->setResponseCode(200);
                $this->apiResponse['message'] ='Form object type updated successfully';
                $this->apiResponse['result'] = $data;
            }
        }
        return $this->sendResponse();
    }


    public function destroy($id)
    {
        $FormObjectType = FormObjectType::find($id);
        if(!empty($FormObjectType)){
            $FormObjectType->delete();
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Form object type deleted successfully';
        }else{
            $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;
        }
        return $this->sendResponse();
    }


    public function getList()
    {

        $total = FormObjectType::where('is_active',true)->get();
        $data = FormObjectResource::collection($total);
        $this->setResponseCode(201);
        $this->apiResponse['message'] ='Form object types get successfully';
        $this->apiResponse['result'] = $data;
        
        return $this->sendResponse();

    }
}
