<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\FormField;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Illuminate\Support\Str;
use DB;
use App\Http\Resources\ProductCategoryResource;
use App\Traits\RequestTraits;
use App\Traits\PaginationTraits;

class ProductCategoryController extends BaseController
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
        $objId = $this->getObjectId('product_category');
        $tableName = $this->getTableName($objId);
        $total = $this->getSearchQuery($tableName[0],$search,$objId);
        $data = $this->getAllDataQuery($tableName[0],$offset,$perPage,$orderby,$search,$objId);
        $pagination = $this->getPaginationFormate($total,$perPage,$page);
        $result = $this->getDataWithPagination($data,$pagination);

        $this->setResponseCode(200);
        $this->apiResponse['message'] ='Product Categories Data get successfully';
        $this->apiResponse['result'] = $result;

        return $this->sendResponse();
    }

    public function store(Request $request)
    {
        $rules = $this->validationRuleDynamically('product_category');
        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);
        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $data = $request->input();
            $tableName = "product_categories";
            $returnData = new ProductCategory();
            foreach ($data as $key => $value) {
                $returnData[$key] = $value;
            }
            $returnData->save();

            $this->setResponseCode(201);
            $this->apiResponse['message'] ='Product Categories Data insert successfully';
            $this->apiResponse['result'] = $returnData;
        }
        return $this->sendResponse();
    }

    public function show(string $id)
    {
        $objId = $this->getObjectId('product_category');
        $tableName = $this->getTableName($objId);
        $data = $this->getSingleDataQuery($tableName[0],$objId,$id);
        if (is_null($data)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;

        }else{
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Product Category data get successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }

    public function update(Request $request, string $id)
    {
        $rules = $this->validationRuleDynamically('product_category');
        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);
        $objId = $this->getObjectId('product_category');
        $tableName = $this->getTableName($objId);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        } else {
            $data = $request->input();
            foreach ($data as $key => $value) {
                $returnData[$key] = $value;
            }
            $returnData = ProductCategory::find($id);
            if (is_null($returnData)) {
                $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not founded';
                $this->apiResponse['status'] = FALSE;
            }else{
                foreach ($data as $key => $value) {
                    $returnData[$key] = $value;
                }
                $returnData->save();
                $returnData = $this->getSingleDataQuery($tableName[0],$objId,$returnData->id);
                $this->setResponseCode(200);
                $this->apiResponse['message'] ='Lead Data updated successfully';
                $this->apiResponse['result'] = $returnData;
            }
        }
        return $this->sendResponse();
    }

    public function destroy(string $id)
    {
        $returnData = ProductCategory::find($id);
        $is_exist = ProductCategory::where('selectParentCategory',$id)->where('is_deleted',false)->get();     
        if (count($is_exist) > 0) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;
            return $this->sendResponse();
        }
        if (is_null($returnData)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;
        }else{
            $returnData->is_deleted = TRUE;
            $returnData->save();
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Product Category Data deleted successfully';
            $this->apiResponse['result'] = [];
        }
        return $this->sendResponse();
    }
    public function getProductCate()
    {
        $returnData = ProductCategory::where('selectParentCategory',null)->where('status','Active')->where('is_deleted',false)->get();
        if (is_null($returnData)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;
        }else{
            $data = ProductCategoryResource::collection($returnData);
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Product Category Data deleted successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }

    public function getProductCateAll()
    {
        $returnData = ProductCategory::where('is_deleted',false)->where('status','Active')->get();
        if (is_null($returnData)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;
        }else{
            $data = ProductCategoryResource::collection($returnData);
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Product Category Data deleted successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }
}
