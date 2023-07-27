<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\FormField;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Illuminate\Support\Str;
use DB;
use App\Traits\RequestTraits;
use App\Traits\PaginationTraits;

class EmployeeController extends BaseController
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
        $columns = \DB::getSchemaBuilder()->getColumnListing('employees');

        $offset = $this->getOffset($page,$perPage);
        $objId = $this->getObjectId('employee');
        $tableArray = $this->getTableName($objId);
        $total = $this->getSearchCount('employees',$tableArray,'employee_id',$search,$objId);
        $data = $this->getAllData('employees',$tableArray,'employee_id',$objId,$offset,$perPage,$orderby,$search);
       
        $pagination = $this->getPaginationFormate($total,$perPage,$page);
        $result = $this->getDataWithPagination($data,$pagination);
  
        $this->setResponseCode(200);
        $this->apiResponse['message'] ='Employee Data get successfully';
        $this->apiResponse['result'] = $result;
        
        return $this->sendResponse();
    }

   
    public function store(Request $request)
    {
        //
        $rules = $this->validationRuleDynamically('employee');
        $requestData = $request->all();
        $req_data = $this->getRequestData($requestData);
        $validator = Validator::make($req_data, $rules);
        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $data = $request->input();
            $tableName = "employee";
            $returnData = new Employee();
            $returnData->save();
            $parentId = $returnData->id;
            for ($i=0; $i < count($data); $i++) { 
                $groupId = $data[$i]['groupId'];
                $AssData = [];
                foreach ($data[$i]['data'] as $key => $value) {
                    $AssData[$key] = $value;
                }
                $this->insertData($tableName, $groupId, $AssData, $parentId);
            }

            $this->setResponseCode(201);
            $this->apiResponse['message'] ='Employee Data insert successfully';
            $this->apiResponse['result'] = $returnData;
        }
        return $this->sendResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {       
        $objId = $this->getObjectId('employee');
        $tableArray = $this->getTableName($objId);
        $data = $this->getSingleData('employees', $tableArray,'employee_id', $objId,$id);
        if (is_null($data)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;

        }else{
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Employees data get successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }

    /**
     * Show the form for editing the specified resource.
     */
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = $this->validationRuleDynamically('Employee');
        $requestData = $request->all();
        $req_data = $this->getRequestData($requestData);
        $validator = Validator::make($req_data, $rules);
        $objId = $this->getObjectId('Employee');
        $tableArray = $this->getTableName($objId);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $data = $request->input();
            $returnData = Employee::find($id);
            if (is_null($returnData)) {
                $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;
            }else{
                $this->updateData('employees',$tableArray,'employee_id',$objId,$id,$requestData);
                $returnData = $this->getSingleData('employees', $tableArray,'employee_id', $objId,$id);
                $this->setResponseCode(200);
                $this->apiResponse['message'] ='Employee Data updated successfully';
                $this->apiResponse['result'] = $returnData;
            }
        }
        return $this->sendResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $returnData = Employee::find($id);
        if (is_null($returnData)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;
        }else{
            $returnData->is_deleted = TRUE;
            $returnData->save();
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='EmployeeData deleted successfully';
            $this->apiResponse['result'] = [];
        }
        return $this->sendResponse();
    }
}
