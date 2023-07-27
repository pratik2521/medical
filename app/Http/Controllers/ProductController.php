<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FormField;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Illuminate\Support\Str;
use DB;
use App\Traits\RequestTraits;
use App\Traits\PaginationTraits;

class ProductController extends BaseController
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
        
        $objId = $this->getObjectId('product');
        $tableArray = $this->getTableName($objId);
        $total = $this->getSearchCount('products',$tableArray,'product_id',$search,$objId);
        $data = $this->getAllData('products',$tableArray,'product_id',$objId,$offset,$perPage,$orderby,$search);
        $pagination = $this->getPaginationFormate($total,$perPage,$page);
        $result = $this->getDataWithPagination($data,$pagination);
  
        $this->setResponseCode(200);
        $this->apiResponse['message'] ='Product Data get successfully';
        $this->apiResponse['result'] = $result;
        
        return $this->sendResponse();
    }

    public function store(Request $request)
    {
        $groupIds = array();
        $requestData = $request->all();
        for ($i=0; $i < count($requestData); $i++) { 
            array_push($groupIds,$requestData[$i]['groupId']);
        }
        $rules = $this->validationRuleDynamically('product',$groupIds);
        $req_data = $this->getRequestData($requestData);
        $validator = Validator::make($req_data, $rules);
        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $data = $request->input();
            $tableName = "product";
            $returnData = new Product();
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
            $this->apiResponse['message'] ='Product Data insert successfully';
            $this->apiResponse['result'] = $returnData;
        }
        return $this->sendResponse();
    }

    public function show(string $id)
    {       
        $objId = $this->getObjectId('product');
        $tableArray = $this->getTableName($objId);
        $data = $this->getSingleData('products', $tableArray,'product_id', $objId,$id);
        if (is_null($data)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;

        }else{
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Product data get successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }

    public function update(Request $request, string $id)
    {
        $groupIds = array();
        $requestData = $request->all();
        for ($i=0; $i < count($requestData); $i++) { 
            array_push($groupIds,$requestData[$i]['groupId']);
        }
        $rules = $this->validationRuleDynamically('product',$groupIds);
        // $rules = $this->validationRuleDynamically('product');
        $requestData = $request->all();
        $req_data = $this->getRequestData($requestData);
        $validator = Validator::make($req_data, $rules);
        $objId = $this->getObjectId('product');
        $tableArray = $this->getTableName($objId);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $data = $request->input();
            $returnData = Product::find($id);
            if (is_null($returnData)) {
                $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;
            }else{
                $this->updateData('products',$tableArray,'product_id',$objId,$id,$requestData);
                $returnData = $this->getSingleData('products', $tableArray,'product_id', $objId,$id);
                $this->setResponseCode(200);
                $this->apiResponse['message'] ='Product Data updated successfully';
                $this->apiResponse['result'] = $returnData;
            }
        }
        return $this->sendResponse();
    }

    public function destroy(string $id)
    {
        $returnData = Product::find($id);
        if (is_null($returnData)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;
        }else{
            $returnData->is_deleted = TRUE;
            $returnData->save();
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Product Data deleted successfully';
            $this->apiResponse['result'] = [];
        }
        return $this->sendResponse();
    }

}
