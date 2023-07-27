<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\FormField;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Illuminate\Support\Str;
use DB;
use App\Traits\RequestTraits;
use App\Traits\PaginationTraits;

class QuoteController extends BaseController
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
        $columns = \DB::getSchemaBuilder()->getColumnListing('quotes');
        $offset = $this->getOffset($page,$perPage);
        
        $objId = $this->getObjectId('quote');
        $tableArray = $this->getTableName($objId);
        $total = $this->getSearchCount('quotes',$tableArray,'quote_id',$search,$objId);
        $data = $this->getAllData('quotes',$tableArray,'quote_id',$objId,$offset,$perPage,$orderby,$search);
       
        $pagination = $this->getPaginationFormate($total,$perPage,$page);
        $result = $this->getDataWithPagination($data,$pagination);
  
        $this->setResponseCode(200);
        $this->apiResponse['message'] ='Quote Data get successfully';
        $this->apiResponse['result'] = $result;
        
        return $this->sendResponse();
    }

    public function store(Request $request)
    {
        $rules = $this->validationRuleDynamically('quote');
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
            $tableName = "quote";
            $returnData = new Quote();
            $returnData->save();
            $parentId = $returnData->id;
            for ($i=0; $i < count($data); $i++) { 
                $groupId = $data[$i]['groupId'];
                $AssData = [];
                foreach ($data[$i]['data'] as $key => $value) {
                    if($key == 'lead_id')
                    {
                        DB::table('lead_cont_informations')
                        ->where('lead_id', $value)
                        ->update(['is_convert' => 1]);
                    }
                    $AssData[$key] = $value;
                }
                $this->insertData($tableName, $groupId, $AssData, $parentId);
            }

            $this->setResponseCode(201);
            $this->apiResponse['message'] ='Quote Data insert successfully';
            $this->apiResponse['result'] = $returnData;
        }
        return $this->sendResponse();
    }

    public function show(string $id)
    {       
        $objId = $this->getObjectId('quote');
        $tableArray = $this->getTableName($objId);
        $data = $this->getSingleData('quotes', $tableArray,'quote_id', $objId,$id);
        if (is_null($data)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;

        }else{
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Quote data get successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }

    public function update(Request $request, string $id)
    {
        $rules = $this->validationRuleDynamically('Quote');
        $requestData = $request->all();
        $req_data = $this->getRequestData($requestData);
        $validator = Validator::make($req_data, $rules);
        $objId = $this->getObjectId('Quote');
        $tableArray = $this->getTableName($objId);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $data = $request->input();
            $returnData = Quote::find($id);
            if (is_null($returnData)) {
                $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;
            }else{
                $this->updateData('quotes',$tableArray,'quote_id',$objId,$id,$requestData);
                $returnData = $this->getSingleData('quotes', $tableArray,'quote_id', $objId,$id);
                $this->setResponseCode(200);
                $this->apiResponse['message'] ='Quote Data updated successfully';
                $this->apiResponse['result'] = $returnData;
            }
        }
        return $this->sendResponse();
    }

    public function destroy(string $id)
    {
        $returnData = Quote::find($id);
        if (is_null($returnData)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;
        }else{
            $returnData->is_deleted = TRUE;
            $returnData->save();
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Quote Data deleted successfully';
            $this->apiResponse['result'] = [];
        }
        return $this->sendResponse();
    }

}
