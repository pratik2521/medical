<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\FormObjectTypeGroup;
use App\Models\FormObjectType;
use Illuminate\Support\Facades\DB;
use App\Models\Lead;
use App\Models\FormField;

class BaseController extends Controller
{
        /**
     * API response code
     * @var int
     */
    private $responseCode = 200;
    public $perPage = 10;
    /**
     * This variable hold the api response object
     * @var array
     */
    protected $apiResponse = array(
        'response_code' => 200,
        'status' => TRUE,
        'message' => '',
        'result' => [],
    );

    /**
     * @return int
     */
    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    /**
     * @param int $responseCode
     */
    public function setResponseCode(int $responseCode): void
    {
        $this->responseCode = $responseCode;
    }

    /**
     * @return array
     */
    public function getApiResponse(): array
    {
        return $this->apiResponse;
    }

    /**
     * @param array $apiResponse
     */
    public function setApiResponse(array $apiResponse): void
    {
        $this->apiResponse = $apiResponse;
    }

    /**
     *
     * @return json output
     */
    protected function sendResponse()
    {
        $this->apiResponse['response_code'] = $this->responseCode;
        return response()->json($this->apiResponse, $this->responseCode);
    }

    public function addColumn(string $tableName, string $columnName, string $dataType)
    {
        if (!Schema::hasColumn($tableName, $columnName)) {
            Schema::table($tableName, function (Blueprint $table) use ($columnName,$dataType) {
                if ($dataType == 'integer') {
                    $table->bigInteger($columnName)->nullable();
                }elseif ($dataType == 'boolean') {
                    $table->boolean($columnName)->nullable();
                }else{
                    $table->string($columnName)->nullable();
                }
            });
        }
        return true;
    }

    public function updateColumn(string $tableName, string $newColumnName, string $oldColumnName){
        if ($newColumnName == $oldColumnName) {
            return true;
        }
        if(Schema::hasColumn($tableName, $oldColumnName)){
            Schema::table($tableName, function (Blueprint $table) use ($oldColumnName,$newColumnName) {
                $table->renameColumn($oldColumnName, $newColumnName);
            });
        }
        return true;
    }

    public function createNewTableIfexistAddColumn(string $parentTable, string $childTable, string $column, string $dataType = null){
        try {
            $tableName = $parentTable.'_'.$childTable;
            $foreignKeyName = $parentTable.'_id';
            $tableNameWithS = $parentTable.'s';
            if (!Schema::hasTable($tableName)) {
                Schema::create($tableName, function (Blueprint $table) use ($column,$foreignKeyName,$parentTable,$tableNameWithS,$dataType) {
                    $table->id();
                    $table->unsignedBigInteger($foreignKeyName);
                    if ($dataType == 'integer') {
                        $table->bigInteger($column)->nullable();
                    }elseif ($dataType == 'boolean') {
                        $table->boolean($column)->nullable();
                    }elseif ($dataType == 'date') {
                        $table->date($column)->nullable();
                    }else{
                        $table->string($column)->nullable();
                    }
                    $table->foreign($foreignKeyName)->references('id')->on($tableNameWithS)->onDelete('cascade');
                    $table->timestamps();
                });
            }else{
                if (!Schema::hasColumn($tableName, $column)) {
                    Schema::table($tableName, function (Blueprint $table) use ($column,$dataType) {
                        if ($dataType == 'integer') {
                            $table->bigInteger($column)->nullable();
                        }elseif ($dataType == 'boolean') {
                            $table->boolean($column)->nullable();
                        }elseif ($dataType == 'date') {
                            $table->date($column)->nullable();
                        }else{
                            $table->string($column)->nullable();
                        }
                    });
                }
            }
            return $tableName;
        } catch (\Throwable $th) {
            print_r($th->getMessage());die;
        }
    }

    public function removeColumn(string $tableName, string $column){

        Schema::table($tableName, function (Blueprint $table) use ($tableName, $column) {
            if (Schema::hasColumn($tableName, $column)) {
                $table->dropColumn($column);
            }
        });
        return true;
    }

    public function getObjectMachineName(int $id){
        $groupMachineName = FormObjectTypeGroup::find($id);
        return $groupMachineName?->machine_name;
    }

    public function getParentTableName(int $id){
        $objectMachineName = FormObjectType::find($id);

        return $objectMachineName?->machine_name;
    }

    public function moveData(string $oldTableName, string $newTableName, string $oldColumn, string $newColumn,int $objectId){
        $sourceData = DB::table($oldTableName)->pluck($oldColumn);
        $foreignKeyName = explode('_',$newTableName)[0].'_id';
        $getForeign = explode('_',$newTableName)[0].'s';
        $forIds = array();
        $leadsIds = DB::table($getForeign)->select('id')->get();
        foreach ($leadsIds as  $value) {
            array_push($forIds,$value->id?? null);
        }
        $ids = DB::table($newTableName)->select('id')->whereIn($foreignKeyName,$forIds)->get();
        for ($i=0; $i < count($ids); $i++) {
            DB::table($newTableName)->where('id', $ids[$i]->id)
            ->update([$newColumn => $sourceData[$i]?? null]);
        }
        return true;
    }

    public function isChange(string $oldColumn, string $newColumn){
        if($oldColumn == $newColumn){
            return false;
        }else{
            return true;
        }
    }

    public function insertData(string $parentTableName, int $groupId, array $data,int $parentId){
        $groupMachineName = FormObjectTypeGroup::select('machine_name')->find($groupId);
        if (empty($groupMachineName)) {
           return false;
        }
        $parentTable = $parentTableName.'s';
        $childTableName = $parentTableName.'_'.$groupMachineName->machine_name;
        $data[$parentTableName.'_id'] = $parentId;
        DB::table($childTableName)->insert($data);
        return true;
    }

    public function getSearchCount(string $parentTable,array $groupTable,string $joinColumn,string $search,int $objId){

        $columns = $this->getObjectColumnsWithPrifix($objId);
        $columnsWhere = $this->getObjectColumnsForWhereClouse($objId);
        $parentConnected = $parentTable.'.id';
        $query = DB::table($parentTable);
        foreach ($groupTable as $value) {
            $query->leftJoin($value, $parentConnected, '=', $value.'.'.$joinColumn);
        }
        $query->select($columns)
        ->when(!empty($search), function ($query) use ($search, $columnsWhere) {
            return $query->where(function ($query) use ($search, $columnsWhere) {
                foreach ($columnsWhere as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        })
        ->where($parentTable.'.is_deleted', false);
        $data = $query->count();
        return $data;
    }

    public function getAllData(string $parentTable,array $groupTable,string $joinColumn,int $objId, int $offset, int $perPage, string $orderby, string $search){

        $columns = $this->getObjectColumnsWithPrifix($objId);

        if($parentTable =='leads')
        {
            array_push($columns,"lead_cont_informations.is_convert as is_convert");
        }

        if($parentTable =='quotes')
        {
            array_push($columns,"quote_cont_informations.lead_id as lead_id");
        }
        $columnsWhere = $this->getObjectColumnsForWhereClouse($objId);
        $parentConnected = $parentTable.'.id';

        $columns = array_reverse($columns);
        array_push($columns, $parentConnected);
        $columns = array_reverse($columns);
        // array_push($columns,$parentConnected);
        $query = DB::table($parentTable);
        foreach ($groupTable as $value) {
            $query->leftJoin($value, $parentConnected, '=', $value.'.'.$joinColumn);
        }
        $query->select($columns)
        ->when(!empty($search), function ($query) use ($search, $columnsWhere) {
            return $query->where(function ($query) use ($search, $columnsWhere) {
                foreach ($columnsWhere as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        })
        ->where($parentTable.'.is_deleted', false)->skip($offset)->take($perPage)->orderBy('id', $orderby);
        $data = $query->get();
        if($parentTable == 'products')
        {
            for ($i=0; $i < count($data) ; $i++) {
                if (isset($data[$i]->pro_category)) {
                    $data[$i]->pro_category = $this->getCategoryName($data[$i]->pro_category);
                }
            }
        }
        return $data;
    }

    public function getSingleData(string $parentTable,array $groupTable,string $joinColumn,int $objId, int $primaryId){

        $columns = $this->getObjectColumnsWithPrifixSingle($objId);

        if($parentTable =='quotes')
        {
            array_push($columns,"quote_cont_informations.lead_id as lead_id");
        }

        $parentConnected = $parentTable.'.id';
        // array_push($columns,$parentConnected);
        $query = DB::table($parentTable);
        foreach ($groupTable as $value) {
            $query->leftJoin($value, $parentConnected, '=', $value.'.'.$joinColumn);
        }
        $query->select($columns)
        ->where($parentTable.'.is_deleted', false)->where($parentTable.'.id',$primaryId);
        $data = $query->get();
        if (count($data) <= 0) {
            $data = null;
        }
        return $data;
    }

    public function getObjectColumnsForWhereClouse($objId){
        $arr = [];
        $Data = FormField::select('input_name','table_name')->where('object_id',$objId)->get();
        foreach ($Data as $key => $value) {
            array_push($arr,($value->table_name.'.'.$value->input_name));
        }
        return $arr;
    }

    public function getObjectColumnsWithPrifix($objId){
        $arr = [];
        $Data = FormField::select('input_name','table_name','validation_rules')->where('object_id',$objId)->get();
        foreach ($Data as $key => $value) {
            $validation = json_decode($value->validation_rules);
            if(isset($validation->is_display_frontend) && $validation->is_display_frontend == true) {
                array_push($arr, ($value->table_name.'.'.$value->input_name.' as '.$this->getChildTable($value->table_name).'_'.$value->input_name));
            }
        }

        return $arr;
    }

    public function getObjectColumnsWithPrifixSingle($objId){
        $arr = [];
        $Data = FormField::select('input_name','table_name')->where('object_id',$objId)->get();
        foreach ($Data as $key => $value) {
                 array_push($arr, ($value->table_name.'.'.$value->input_name.' as '.$this->getChildTable($value->table_name).'_'.$value->input_name));
         }

        return $arr;
    }

    public function getObjectGroupTable($objId,$gropuId){
        $Data = FormField::select('table_name')->where('object_id',$objId)->where('group_id',$gropuId)->groupBy('table_name')->get();
        return $Data[0]->table_name;
    }

    public function updateData(string $parentTable,array $groupTable,string $joinColumn,int $objId, int $primaryId,array $req){
        for ($i=0; $i < count($req); $i++) {
            $gropuId = $req[$i]['groupId'];
            $tableName = $this->getObjectGroupTable($objId,$gropuId);
            $data = [];
            foreach ($req[$i]['data'] as $key => $value) {
                $data[$key] = $value;
            }
            if ($parentTable == "products") {
                $this->updateQueryForProduct($tableName,$primaryId,$joinColumn,$data);
            }else {
                $this->updateQuery($tableName,$primaryId,$joinColumn,$data);
            }
        }

        return true;
    }

    public function updateQuery(string $tableName, int $id, string $relationColumn,array $req){
        $data = DB::table($tableName)->where($relationColumn, $id)->update($req);
        if ($data) {
            return true;
        }
        return false;
    }

    public function updateQueryForProduct(string $tableName, int $id, string $relationColumn,array $req){
        $data = DB::table($tableName)->updateOrInsert([$relationColumn => $id], $req);
        if ($data) {
            return true;
        }
        return false;
    }

    public function getChildTable(string $childTableName){
        return explode('_',$childTableName)[1];
    }

    // for product sub-category
    public function getSearchQuery(string $tableName, string $search, int $objId){
        if (!empty($search) && $tableName == "product_categories") {
            $parentId = $this->getCategoryParent($search);
        }else {
            $parentId = null;
        }
        $columns = $this->getObjectColumnsForWhereClouse($objId);
        $query = DB::table($tableName);
        $query->select($columns)
        ->when(!empty($search), function ($query) use ($search, $columns) {
            return $query->where(function ($query) use ($search, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', $search . '%');
                }
            });
        })
        ->when(!empty($parentId), function ($query) use ($parentId) {
            return $query->orWhereIn('selectParentCategory', $parentId);
        })
        ->where('is_deleted', false);
        $data = $query->count();
        return $data;
    }

    public function getCategoryParent(string $search){
        $parentId = [];
        $query = DB::table('product_categories');
        $query->select('id')->where('is_deleted', false);
        $query->where('name', 'like', $search . '%');
        $data = $query->get();
        foreach ($data as $key => $value) {
            array_push($parentId,$value->id);
        }
        return $parentId;
    }

    public function getAllDataQuery(string $parentTable,int $offset, int $perPage, string $orderby, string $search, int $objId){
        if (!empty($search) && $parentTable == "product_categories") {
            $parentId = $this->getCategoryParent($search);
        }else {
            $parentId = null;
        }
        $columns = $this->getObjectColumnsForWhereClouse($objId);
        $parentConnected = $parentTable.'.id';
        $columns = array_reverse($columns);
        array_push($columns, $parentConnected);
        $columns = array_reverse($columns);
        $query = DB::table($parentTable);
        $query->select($columns)
        ->when(!empty($search), function ($query) use ($search, $columns) {
            return $query->where(function ($query) use ($search, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', $search . '%');
                }
            });
        })
        ->when(!empty($parentId), function ($query) use ($parentId) {
            return $query->orWhereIn('selectParentCategory', $parentId);
        })
        ->where('is_deleted',false)->skip($offset)->take($perPage)->orderBy('id', $orderby);
        $data = $query->get();
        for ($i=0; $i < count($data) ; $i++) {
            if (isset($data[$i]->selectParentCategory)) {
                $data[$i]->selectParentCategory = $this->getCategoryName($data[$i]->selectParentCategory);
            }
        }
        return $data;
    }

    public function getSingleDataQuery(string $tableName,int $objId, int $primaryId){
        $columns = $this->getObjectColumnsForWhereClouse($objId);
        $parentConnected = $tableName.'.id';
        $columns = array_reverse($columns);
        array_push($columns, $parentConnected);
        $columns = array_reverse($columns);
        $query = DB::table($tableName);
        $query->select($columns)
        ->where($tableName.'.is_deleted', false)->where($tableName.'.id',$primaryId);
        $data = $query->get();
        if (count($data) <= 0) {
            $data = null;
        }
        return $data;
    }

    public function getCategoryName(int $id){
        $data = '';
        $query = DB::table('product_categories');
        $query->select('name')
        ->where('is_deleted', false)->where('id',$id);
        $data = $query->first();
        return $data?->name;
    }
// end for product sub-category
}
