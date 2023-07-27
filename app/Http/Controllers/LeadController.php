<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\FormField;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Illuminate\Support\Str;
use DB;
use App\Traits\RequestTraits;
use App\Traits\PaginationTraits;

class LeadController extends BaseController
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
        $columns = \DB::getSchemaBuilder()->getColumnListing('leads');
        $offset = $this->getOffset($page,$perPage);

        $objId = $this->getObjectId('lead');
        $tableArray = $this->getTableName($objId);
        $total = $this->getSearchCount('leads',$tableArray,'lead_id',$search,$objId);
        $data = $this->getAllData('leads',$tableArray,'lead_id',$objId,$offset,$perPage,$orderby,$search);

        $pagination = $this->getPaginationFormate($total,$perPage,$page);
        $result = $this->getDataWithPagination($data,$pagination);

        $this->setResponseCode(200);
        $this->apiResponse['message'] ='Lead Data get successfully';
        $this->apiResponse['result'] = $result;

        return $this->sendResponse();
    }

    public function store(Request $request)
    {
        $rules = $this->validationRuleDynamically('lead');
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
            $tableName = "lead";
            $returnData = new Lead();
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
            $this->apiResponse['message'] ='Lead Data insert successfully';
            $this->apiResponse['result'] = $returnData;
        }
        return $this->sendResponse();
    }

    public function show(string $id)
    {
        $objId = $this->getObjectId('lead');
        $tableArray = $this->getTableName($objId);
        $data = $this->getSingleData('leads', $tableArray,'lead_id', $objId,$id);
        if (is_null($data)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;

        }else{
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Lead data get successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }

    public function update(Request $request, string $id)
    {
        $rules = $this->validationRuleDynamically('lead');
        $requestData = $request->all();
        $req_data = $this->getRequestData($requestData);
        $validator = Validator::make($req_data, $rules);
        $objId = $this->getObjectId('lead');
        $tableArray = $this->getTableName($objId);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $data = $request->input();
            $returnData = Lead::find($id);
            if (is_null($returnData)) {
                $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;
            }else{
                $this->updateData('leads',$tableArray,'lead_id',$objId,$id,$requestData);
                $returnData = $this->getSingleData('leads', $tableArray,'lead_id', $objId,$id);
                $this->setResponseCode(200);
                $this->apiResponse['message'] ='Lead Data updated successfully';
                $this->apiResponse['result'] = $returnData;
            }
        }
        return $this->sendResponse();
    }

    public function destroy(string $id)
    {
        $returnData = Lead::find($id);
        if (is_null($returnData)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;
        }else{
            $returnData->is_deleted = TRUE;
            $returnData->save();
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Lead Data deleted successfully';
            $this->apiResponse['result'] = [];
        }
        return $this->sendResponse();
    }
    public function getLead(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'id' => 'required',
        ]);
         $id = $request->id;

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $returnData = Lead::find($id);
            if (is_null($returnData)) {
                $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;
            }else{

                DB::table('lead_cont_informations')
                ->where('lead_id', $id)
                ->update(['is_convert' => 1]);

                // $returnData->is_convert = 1;
                // $returnData->save();
                $this->setResponseCode(200);
                $this->apiResponse['message'] ='Status updated successfully';
                $this->apiResponse['result'] = [];
            }
        }
        return $this->sendResponse();
    }


    public function convertStatuesUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required'
        ]);
        $id = $request->id;
        $status = $request->status;
        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $returnData = Lead::find($id);
            if (is_null($returnData)) {
                $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;
            }else{
                $returnData->is_convert = $status;
                $returnData->save();
                $this->setResponseCode(200);
                $this->apiResponse['message'] ='Stauts updated successfully';
                $this->apiResponse['result'] = [];
            }
        }
        return $this->sendResponse();
    }


}
