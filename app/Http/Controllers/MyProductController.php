<?php

namespace App\Http\Controllers;
// use DB;
// use Storage;
// use Validator;
// use App\Models\MyProduct;
// use App\Models\MyProductGallery;
// use Illuminate\Support\Str;
// use Illuminate\Http\Request;
// use App\Traits\RequestTraits;
// use App\Traits\PaginationTraits;
// use App\Models\MyProductSequence;
// use Intervention\Image\Facades\Image;
// use Symfony\Component\HttpFoundation\Response;
// use App\Http\Controllers\BaseController as BaseController;
use DB;
use Storage;
use Validator;
use App\Models\MyProduct;
use App\Models\MyProductGallery;
use App\Models\MyProductGalleries;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\RequestTraits;
use App\Traits\PaginationTraits;
use App\Models\MyProductSequence;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\BaseController as BaserevController;
use App\Models\MyProductFeatures;
use App\Models\MyProductSpecifications;
use App\Models\MyProductFeaturesCompareWith;
class MyProductController extends BaseController
{
    
    use RequestTraits;
    use PaginationTraits;
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     //$data = DB::table('my_products')->get();
    //     $data = DB::table('my_products')->where('is_deleted',false)->get();

    //     if ($data->isEmpty()){
    //         $this->setResponseCode(404);
    //         $this->apiResponse['message'] = 'Data not founded';
    //         $this->apiResponse['status'] = FALSE;
    //     }else{
    //         $this->setResponseCode(200);
    //         $this->apiResponse['message'] = 'all products retrieved successfully';
    //         $this->apiResponse['result'] = $data;
           
    
    //     }
    //     return $this->sendResponse();
    // }
    // public function index(Request $request)
    // {
    //     $perPage = $request->get('page_size', '');
    //     $page = $request->get('page', 1);
    //     $orderby = $request->get('orderby', 'desc');
    //     $search = $request->get('search', '');
        
    //     if (empty($perPage)) {
    //         $perPage = $this->perPage;
    //     }
        
    //     $columns = \DB::getSchemaBuilder()->getColumnListing('my_products');
    //     $total = DB::table('my_products')->where('is_deleted', false)->count();
        
    //     $offset = $this->getOffset($page, $perPage);
    //     $data = DB::table('my_products')
    //         ->where('is_deleted', false)
    //         ->offset($offset)
    //         ->limit($perPage)
    //         ->orderBy('created_at', $orderby)
    //         ->get();
        
    //     $pagination = $this->getPaginationFormate($total, $perPage, $page);
    //     $result = $this->getDataWithPagination($data, $pagination);
        
    //     $this->setResponseCode(200);
    //     $this->apiResponse['message'] = 'All products retrieved successfully';
    //     $this->apiResponse['result'] = $result;
        
    //     return $this->sendResponse();
    // }
    //public function index(Request $request)
// {
//     $perPage = $request->get('page_size', '');
//     $page = $request->get('page', 1);
//     $orderby = $request->get('orderby', 'desc');
//     $search = $request->get('search', '');
    
//     if (empty($perPage)) {
//         $perPage = $this->perPage;
//     }
    
//     $tableName = 'my_products';
//     $columns = \DB::getSchemaBuilder()->getColumnListing($tableName);
//     $columnsToSelect = array_diff($columns, ['created_at', 'updated_at','is_deleted']);
    
//     $total = DB::table($tableName)->where('is_deleted', false)->count();

//     $offset = $this->getOffset($page, $perPage);
//     $data = DB::table($tableName)
//         ->where('is_deleted', false)
//         ->offset($offset)
//         ->limit($perPage)
//         ->orderBy('created_at', $orderby)
//         ->get($columnsToSelect);

//     $pagination = $this->getPaginationFormate($total, $perPage, $page);
//     $result = $this->getDataWithPagination($data, $pagination);
    
//     $this->setResponseCode(200);
//     $this->apiResponse['message'] = 'All products retrieved successfully';
//     $this->apiResponse['result'] = $result;
    
//     return $this->sendResponse();
// }
public function index(Request $request)
{
    $perPage = $request->get('page_size', '');
    $page = $request->get('page', 1);
    $orderby = $request->get('orderby', 'desc');
    $search = $request->get('search', '');
    
    if (empty($perPage)) {
        $perPage = $this->perPage;
    }
    
    $tableName = 'my_products';
    $columns = \DB::getSchemaBuilder()->getColumnListing($tableName);
    $columnsToSelect = array_diff($columns, ['created_at', 'updated_at','is_deleted']);
    
    $query = DB::table($tableName)
        ->where('is_deleted', false);
    
    if (!empty($search)) {
        $query->where(function ($q) use ($columnsToSelect, $search) {
            foreach ($columnsToSelect as $column) {
                $q->orWhere($column, 'LIKE', '%'.$search.'%');
            }
        });
    }
    
    $total = $query->count();

    $offset = $this->getOffset($page, $perPage);
    $data = $query->offset($offset)
        ->limit($perPage)
        ->orderBy('created_at', $orderby)
        ->get($columnsToSelect);

    $pagination = $this->getPaginationFormate($total, $perPage, $page);
    $result = $this->getDataWithPagination($data, $pagination);
    
    $this->setResponseCode(200);
    $this->apiResponse['message'] = 'All products retrieved successfully';
    $this->apiResponse['result'] = $result;
    
    return $this->sendResponse();
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'files.*' => 'required|image|mimes:jpeg,png,jpg',
            'product_price'=>'required',
            'product_discount'=>'required',
        ]);
        $is_edit = false;
        $id = 0;
        if (isset($request->parent_id)) {
            $is_edit = true;
            $id = $request->parent_id;
        }
        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        }else{
            if ($is_edit) {
                $data = MyProduct::find($id);
            }else{
                $data = new MyProduct();
            }
            $data->name = $request->name;
            // $data->product_modelname = isset($request->product_modelname) ? $request->product_modelname : NULL;
            $data->product_price = $request->product_price;
            $data->product_discount = $request->product_discount;
            $data->save();
            $files = $request->file('files');
             if ($request->hasFile('files')) {
                $files = $request->file('files');
                // if(!Storage::disk('uploads')->exists('product_images')){
                //     Storage::disk('uploads')->makeDirectory('product_images');
                // }
                foreach ($files as $file) {
                    $filename = uniqid() .'.'. $file->getClientOriginalExtension();
                    $origalName = $file->getClientOriginalName();
                    $image_type = $file->getMimeType();
                    $image_ext = $file->getClientOriginalExtension();
                    $full_path = 'product_images/'.$filename;
                    $thumbnailPath = 'thumbnails/' . basename($file);
                    $file->storeAs('public/product_images', $filename);
                    $image = Image::make($file);
                    $image->fit(300, 200);
                    Storage::disk('public')->put($thumbnailPath, $image->stream().$file->getClientOriginalExtension());
                    $thumbnailFullPath = $thumbnailPath;
                    // $thumbnailUrl = Storage::disk('public')->url($thumbnailPath);
                    DB::Table('my_product_galleries')->insert([
                        'my_product_id'=>$data->id,
                        'image_name'=>$origalName,
                        'image_path'=>$full_path,
                        'image_thumbnail'=>$thumbnailFullPath,
                        'image_type'=>$image_type,
                        'type'=>'main_section',
                        'image_extension'=>$image_ext
                    ]);
                }
            }else {
                print_r('file not found');
            }
            $this->setResponseCode(201);
            $this->apiResponse['message'] ='My Product added successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }

    /**
     * Display the specified resource.
     */
   
     public function show(string $id)
    {
        $myproduct = DB::table('my_products')
            ->leftJoin('my_product_galleries', 'my_products.id', '=', 'my_product_galleries.my_product_id')
            ->select('my_products.*', 'my_product_galleries.image_path')
            ->where('my_products.id', $id)
            ->where('my_products.is_deleted', false)
            ->first();
    
        if (!$myproduct) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not found';
            $this->apiResponse['status'] = false;
        } else {
            $myproduct->image_path = DB::table('my_product_galleries')
                ->where('my_product_id', $id)
                ->where('type', 'main_section')
                ->where('is_deleted','false')
                ->pluck('image_path')
                 
                ->toArray();
    
            $this->setResponseCode(200);
            $this->apiResponse['message'] = 'Myproduct retrieved successfully';
            $this->apiResponse['result'] = $myproduct;
        }
    
        return $this->sendResponse();
    }
    
    // public function show(string $id)
    // {
    //     $myproduct = DB::table('my_products')
    //         ->leftJoin('my_product_galleries', 'my_products.id', '=', 'my_product_galleries.my_product_id')
    //         ->select('my_products.*',  'my_product_galleries.IMAGE_PATH')
    //         ->where('my_products.id', $id)
    //         ->where('my_products.is_deleted', false)
    //         ->first();
    
    //     if (!$myproduct) {
    //         $this->setResponseCode(404);
    //         $this->apiResponse['message'] = 'Data not found';
    //         $this->apiResponse['status'] = false;
    //     } else {
    //         $this->setResponseCode(200);
    //         $this->apiResponse['message'] = 'Myproduct retrieved successfully';
    //         $this->apiResponse['result'] = $myproduct;
    //     }
    
    //     return $this->sendResponse();
    // }
    


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $returnData = MyProduct::find($id);
        // print_r($returnData);
        // die("dsaads");
        if (is_null($returnData)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;
        } else {
            $returnData->is_deleted = TRUE;
            $returnData->save();
            $this->setResponseCode(200);
            $this->apiResponse['message'] = 'myproduct deleted successfully';
            $this->apiResponse['result'] = [];
        }
        return $this->sendResponse();
    }

    public function features(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'icon' => 'required',
            'description' => 'required',
            // 'mime_type' => 'required',
            'parent_id' => 'required',
            
        ]);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        }else{
            // $data = $request->all();
            // for ($i=0; $i < count($data['name']); $i++) { 
            //    $file = isset($data['icon'][$i]) ? $data['icon'][$i] : null;
            //    $parent_id = $data['parent_id'][$i];
            //    $name = $data['name'][$i];
            //    $description = $data['description'][$i];
        
            //    if ($file != 'undefined') {
            //         $filename = uniqid() .'.'. $file->getClientOriginalExtension();
            //         $origalName = $file->getClientOriginalName();
            //         $image_type = $file->getMimeType();
            //         $image_ext = $file->getClientOriginalExtension();
            //         $full_path = 'product_images/'.$filename;
            //         $file->storeAs('public/product_images', $filename);
            //    }else{
            //     $full_path = null;
            //    }
            //      DB::Table('my_product_features')->insert([
            //         'my_product_id'=>$parent_id,
            //         'title'=>$name,
            //         'icon_path'=>$full_path,
            //         'description'=>$description,
            //     ]);
            // }
            $data = $request->all();
            for ($i=0; $i < count($data['name']); $i++) { 
                $file = isset($data['icon'][$i]) ? $data['icon'][$i] : null;
                $parent_id = $data['parent_id'][$i];
                $name = $data['name'][$i];
                $id = $data['newid'][$i];
                $description = $data['description'][$i];
                $is_edit = false;
                $self_id = 0;
                if ($id) {
                    $is_edit = true;
                    $self_id = $id;
                }
                if ($file && $is_edit == false) {
                    $filename = uniqid() .'.'. $file->getClientOriginalExtension();
                    $full_path = 'product_images/'.$filename;
                    $file->storeAs('public/product_images', $filename);
                }
                if ($is_edit) {
                     DB::table('my_product_features')->where('id',$self_id)->update([
                        'my_product_id'=>$parent_id,
                        'title'=>$name,
                        'description'=>$description,
                    ]);
                
                }else{
                    DB::Table('my_product_features')->insert([
                    'my_product_id'=>$parent_id,
                    'title'=>$name,
                    'icon_path'=>$full_path,
                    'description'=>$description,
                ]);
                }
            }
            // foreach ($data as $item) {
            //     print_r($item);
                // $url = $item['icon'];
                // $parent_id = $item['parent_id'];
                // $name = $item['name'];
                // $description = $item['description'];
                // $file_mime = $item['mime_type'];
                // $fileContent = file_get_contents($url);
                // list($mime, $extension) = explode('/', $file_mime);
                // $filename = uniqid() .'.'. $extension;
                // $pathForDb ='product_icon/'.$filename;
                // if (!empty($fileContent)) {
                //     Storage::disk('public')->put('product_icon/'.$filename, $fileContent);
                // }
                // DB::Table('my_product_features')->insert([
                //     'my_product_id'=>$parent_id,
                //     'title'=>$name,
                //     'icon_path'=>$pathForDb,
                //     'description'=>$description,
                // ]);
            // }
            // die;
            $this->setResponseCode(201);
            $this->apiResponse['message'] ='Product Feature Added successfully';
            $this->apiResponse['result'] = [];
        }
        return $this->sendResponse();
    }

    public function uploadGallery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:slider,single',
            'files.*' => 'required|image|mimes:jpeg,png,jpg',
            'parent_id' => 'required',
        ]);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        }else{
            $files = $request->file('files');
             if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $file) {
                    $filename = uniqid() .'.'. $file->getClientOriginalExtension();
                    $origalName = $file->getClientOriginalName();
                    $image_type = $file->getMimeType();
                    $image_ext = $file->getClientOriginalExtension();
                    $full_path = 'product_images/'.$filename;
                    $file->storeAs('public/product_images', $filename);
                    // $thumbnailUrl = Storage::disk('public')->url($thumbnailPath);
                    DB::Table('my_product_galleries')->insert([
                        'my_product_id'=>$request->parent_id,
                        'image_name'=>$origalName,
                        'image_path'=>$full_path,
                        'image_thumbnail'=>'',
                        'image_type'=>$image_type,
                        'type'=>$request->type,
                        'image_extension'=>$image_ext
                    ]);
                }
            }else {
                print_r('file not found');
            }
            $this->setResponseCode(201);
            $this->apiResponse['message'] ='Image uploaded successfully';
            $this->apiResponse['result'] = [];
        }
        return $this->sendResponse();
    }

    public function productFAQ(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*.name' => 'required',
            '*.description' => 'required',
            '*.parent_id' => 'required',
        ]);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        }else{
            $data = $request->json()->all();
            DB::Table('my_product_faqs')->where('my_product_id',$data[0]['parent_id'])->delete();
            foreach ($data as $item) {
                $parent_id = $item['parent_id'];
                $name = $item['name'];
                $description = $item['description'];
        
                // DB::Table('my_product_faqs')->insert([
                //     'my_product_id'=>$parent_id,
                //     'title'=>$name,
                //     'description'=>$description,
                // ]);
                DB::table('my_product_faqs')->updateOrInsert(
                    ['my_product_id' => $parent_id, 'title' => $name],
                    ['description' => $description]
                );
            }
            
            $this->setResponseCode(201);
            $this->apiResponse['message'] ='Product FAQ Added successfully';
            $this->apiResponse['result'] = [];
        }
        return $this->sendResponse();
    }
    public function getuploadGallery($id,$type)
    {
        $data = DB::table('my_product_galleries')->where('is_deleted',false)->where('my_product_id',$id)->where('type',$type)->get();
        if (is_null($data)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;

        }else{
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Product Gallery get successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }
    
    public function getMultifeaturesProductAssign($id)
    {
        $data = DB::table('my_product_assing_features')->where('my_product_id',$id)->get();
        if ($data->isEmpty())  {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;
        }else{
            $this->setResponseCode(200);
            $this->apiResponse['message'] = 'Product Assign multifeatures retrieved successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }
    public function getProductFAQ($id)
    {
        $data = DB::table('my_product_faqs')->where('is_deleted',false)->where('my_product_id',$id)->get();
        if (is_null($data)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;

        }else{
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Product FAQ get successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }
    public function ProductSideBar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'icon' => 'required',
            'parent_id' => 'required',
        ]);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        }else{
            $data = $request->all();
            // for ($i=0; $i < count($data['name']); $i++) { 
            //    $file = isset($data['icon'][$i]) ? $data['icon'][$i] : null;
            //    $parent_id = $data['parent_id'][$i];
            //    $name = $data['name'][$i];
            //    if ($file) {
            //         $filename = uniqid() .'.'. $file->getClientOriginalExtension();
            //         $origalName = $file->getClientOriginalName();
            //         $image_type = $file->getMimeType();
            //         $image_ext = $file->getClientOriginalExtension();
            //         $full_path = 'product_images/'.$filename;
            //         $file->storeAs('public/product_images', $filename);
            //    }else{
            //     $full_path = null;
            //    }
            //      DB::Table('my_product_sidebars')->insert([
            //         'my_product_id'=>$parent_id,
            //         'title'=>$name,
            //         'icon_path'=>$full_path,
                    
            //     ]);
            // }
            for ($i=0; $i < count($data['name']); $i++) { 
                $file = isset($data['icon'][$i]) ? $data['icon'][$i] : null;
                $parent_id = $data['parent_id'][$i];
                $name = $data['name'][$i];
                $id = $data['newid'][$i];
                $is_edit = false;
                $self_id = 0;
                if ($id) {
                    $is_edit = true;
                    $self_id = $id;
                }
                if ($file && $is_edit == false) {
                     $filename = uniqid() .'.'. $file->getClientOriginalExtension();
                     $full_path = 'product_images/'.$filename;
                     $file->storeAs('public/product_images', $filename);
                }
                if ($is_edit) {
                     DB::table('my_product_sidebars')->where('id',$self_id)->update([
                         'my_product_id'=>$parent_id,
                         'title'=>$name,
                     ]);
                 }else{
                     DB::Table('my_product_sidebars')->insert([
                         'my_product_id'=>$parent_id,
                         'title'=>$name,
                         'icon_path'=>$full_path,
                     ]);
                 }  
             }
            // foreach ($data as $item) {
            //     print_r($item);
                // $url = $item['icon'];
                // $parent_id = $item['parent_id'];
                // $name = $item['name'];
                // $description = $item['description'];
                // $file_mime = $item['mime_type'];
                // $fileContent = file_get_contents($url);
                // list($mime, $extension) = explode('/', $file_mime);
                // $filename = uniqid() .'.'. $extension;
                // $pathForDb ='product_icon/'.$filename;
                // if (!empty($fileContent)) {
                //     Storage::disk('public')->put('product_icon/'.$filename, $fileContent);
                // }
                // DB::Table('my_product_features')->insert([
                //     'my_product_id'=>$parent_id,
                //     'title'=>$name,
                //     'icon_path'=>$pathForDb,
                //     'description'=>$description,
                // ]);
            // }
            // die;
            $this->setResponseCode(201);
            $this->apiResponse['message'] ='Product Sidebar Added successfully';
            $this->apiResponse['result'] = [];
        }
        return $this->sendResponse();
    }


    public function getproductSideBar(string $id)
    { {
            $myproduct = DB::table('my_product_sidebars')
            ->where('my_product_id', $id)
                ->where('is_deleted', false)
                ->get();

            if (!$myproduct) {
                $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not found';
                $this->apiResponse['status'] = false;
            } else {
                $this->setResponseCode(200);
                $this->apiResponse['message'] = 'Myproduct retrieved successfully';
                $this->apiResponse['result'] = $myproduct;
            }

            return $this->sendResponse();
        }
    }
    public function productAssingFeatures(Request $request)
{
    $validator = Validator::make($request->all(), [
        
        '*.parent_id' => 'required',
        '*.my_feature_id'=>'required'

    ]);
    if ($validator->fails()) {
        $this->setResponseCode(400);
        $this->apiResponse['message'] = $validator->messages()->first();
        $this->apiResponse['errors'] = $validator->errors();
        $this->apiResponse['status'] = FALSE;

    }else{
        $data = $request->json()->all();
        DB::Table('my_product_assing_features')->where('my_product_id',$data[0]['parent_id'])->delete();
        foreach ($data as $item) {
            $parent_id = $item['parent_id'];
            $my_feature_id = $item['my_feature_id'];
           
            DB::Table('my_product_assing_features')->insert([
                'my_product_id'=>$parent_id,
                'my_feature_id'=>$my_feature_id
            ]);
        }
        
        $this->setResponseCode(201);
        $this->apiResponse['message'] ='Product productAssingFeatures Added successfully';
        $this->apiResponse['result'] = [];
    }
    return $this->sendResponse();
}

    public function Multifeatures(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);

        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        }else{
          
                $name = $request->name;
                DB::Table('my_product_multi_features')->insert([
                    'name'=>$name
                ]);
            
            $this->setResponseCode(201);
            $this->apiResponse['message'] ='Product multifeatures Added successfully';
            $this->apiResponse['result'] = [];
        }
        return $this->sendResponse();
    }
 public function getMultifeatures(Request $request)
{
    $data = DB::table('my_product_multi_features')->where('is_deleted',false)->get();
    
    if ($data->isEmpty()){
        $this->setResponseCode(404);
        $this->apiResponse['message'] = 'Data not founded';
        $this->apiResponse['status'] = FALSE;
    }else{
        $this->setResponseCode(200);
        $this->apiResponse['message'] = 'Product multifeatures retrieved successfully';
        $this->apiResponse['result'] = $data;
       

    }
    return $this->sendResponse();
}

public function productyoutubelink(Request $request)

{
    $validator = Validator::make($request->all(), [
        'youtubelink' => 'required',
        'parent_id'=>'required'

    ]);

    if ($validator->fails()) {
        $this->setResponseCode(400);
        $this->apiResponse['message'] = $validator->messages()->first();
        $this->apiResponse['errors'] = $validator->errors();
        $this->apiResponse['status'] = FALSE;

    }else{
      
            $youtubelink = $request->youtubelink;
            $parent_id =$request->parent_id;
            // DB::Table('my_product_youtubelinks')->insert([
            //     'youtubelink'=> $youtubelink,
            //     ''=> $parent_id
            // ]);
            DB::table('my_product_youtubelinks')->updateOrInsert(
                ['product_id' => $parent_id],
                ['youtubelink' => $youtubelink]
            );
        
        $this->setResponseCode(201);
        $this->apiResponse['message'] ='Product Youtubelinks Added successfully';
        $this->apiResponse['result'] = [];
    }
    return $this->sendResponse();
}
    public function getyoutubelink(string $id)
    {
     
        {
            $myproduct = DB::table('my_product_youtubelinks')
                ->where('product_id', $id)
                ->where('is_deleted', false)
                ->first();
                
            if (!$myproduct) {
                $this->setResponseCode(404);
                $this->apiResponse['message'] = 'Data not found';
                $this->apiResponse['status'] = false;
            } else {
                $this->setResponseCode(200);
                $this->apiResponse['message'] = 'Myproduct retrieved successfully';
                $this->apiResponse['result'] = $myproduct;
            }
        
            return $this->sendResponse();
        }
        
    }
    public function getFeatures($id)
    {
        $data = DB::table('my_product_features')->where('is_deleted',false)->where('my_product_id',$id)->get();
        if (is_null($data)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;

        }else{
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Product features get successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();
    }

    public function productSpecification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image_position' => 'required',
            'image' => 'required',
            'parent_id' => 'required',
            'sub_title'=> 'required',
            'description' => 'required',
            'icon' => 'required',
        ]);
        // print_r($request->all());die;
        if ($validator->fails()) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = $validator->messages()->first();
            $this->apiResponse['errors'] = $validator->errors();
            $this->apiResponse['status'] = FALSE;

        }else{
            DB::beginTransaction();
            try {            
                // $data = $request->json()->all();
                // foreach ($data as $item) {
                //     $image_url = $item['image_url'];
                //     $parent_id = $item['parent_id'];
                //     $title = $item['title'];
                //     $image_position = $item['image_position'];
                //     $file_mime = $item['mime_type'];
                //     $dataNew = $item['data'];
                //     $fileContent = file_get_contents($image_url);
                //     list($mime, $extension) = explode('/', $file_mime);
                //     $filename = uniqid() .'.'. $extension;
                //     $pathForDb ='product_images/'.$filename;
                //     if (!empty($fileContent)) {
                //         Storage::disk('public')->put('product_images/'.$filename, $fileContent);
                //     }
                //     foreach ($dataNew as $item) {
                //         $sub_title = $item['sub_title'];
                //         $description = $item['description'];
                //         $icon_url = $item['icon_url'];
                //         $file_mimeSub = $item['mime_type'];
                //         $fileContentSub = file_get_contents($icon_url);
                //         list($mime, $extension) = explode('/', $file_mimeSub);
                //         $filenameS = uniqid() .'.'. $extension;
                //         $pathForDbIcon ='product_icon/'.$filenameS;
                //         if (!empty($fileContentSub)) {
                //             Storage::disk('public')->put('product_icon/'.$filenameS, $fileContentSub);
                //         }
                        // DB::Table('my_product_specifications')->insert([
                        //     'my_product_id'=>$parent_id,
                        //     'title'=>$title,
                        //     'sub_title'=>$pathForDb,
                        //     'description'=>$description,
                        //     'icon'=>$pathForDbIcon,
                        //     'image_url'=>$pathForDb,
                        //     'image_position'=>$image_position,
                        // ]);
                //     }
                // }
                $data = $request->all();
                // for ($i=0; $i < count($data['title']); $i++) { 
                //    $file = isset($data['image'][$i]) ? $data['image'][$i] : null;
                //    $title = $data['title'][$i];
                //    $parent_id = $data['parent_id'][$i];
                //    $image_position = $data['image_position'][$i];
                //    if ($file) {
                //        $filename = uniqid() .'.'. $file->getClientOriginalExtension();
                //        $pathForDb = 'product_images/'.$filename;
                //        $file->storeAs('public/product_images', $filename);
                //    }
                //    for ($j=0; $j < count($data['sub_title'][$i]); $j++) { 
                //         $fileSub = isset($data['icon'][$i][$j]) ? $data['icon'][$i][$j] : null;
                //         $description = $data['description'][$i][$j];
                //         $sub_title = $data['sub_title'][$i][$j];
                //         if ($fileSub) {
                //             $filename = uniqid() .'.'. $fileSub->getClientOriginalExtension();
                //             $pathForDbIcon = 'product_images/'.$filename;
                //             $fileSub->storeAs('public/product_images', $filename);
                //        }else{
                //         $pathForDbIcon = null;
                //        }
                //        $response = DB::Table('my_product_specifications')->insert([
                //             'my_product_id'=>$parent_id,
                //             'title'=>$title,
                //             'sub_title'=>$sub_title,
                //             'description'=>$description,
                //             'icon'=>$pathForDbIcon,
                //             'image_url'=>$pathForDb,
                //             'image_position'=>$image_position,
                //         ]);
                //    }
                // }
                for ($i=0; $i < count($data['title']); $i++) { 
                    $file = isset($data['image'][$i]) ? $data['image'][$i] : null;
                    $title = $data['title'][$i];
                    $parent_id = $data['parent_id'][$i];
                    $image_position = $data['image_position'][$i];
                    $id = $data['newid'][$i];
                    $is_edit = false;
                    $self_id = 0;
                    if ($id) {
                        $is_edit = true;
                        $self_id = $id;
                    }
                    if ($file && $is_edit == false) {
                        $filename = uniqid() .'.'. $file->getClientOriginalExtension();
                        $pathForDb = 'product_images/'.$filename;
                        $file->storeAs('public/product_images', $filename);
                    }
                    if ($is_edit) {
                         $dataTable = MyProductSpecifications::find($self_id);
                    }else{
                         $dataTable = new MyProductSpecifications();
                    }
                    $dataTable->my_product_id = $parent_id;
                    $dataTable->title = $title;
                    if (!$is_edit) {
                         $dataTable->image_url = $pathForDb;
                     }
                    $dataTable->image_position = $image_position;
                    $dataTable->save();
                    for ($j=0; $j < count($data['sub_title'][$i]); $j++) { 
                         $fileSub = isset($data['icon'][$i][$j]) ? $data['icon'][$i][$j] : null;
                         $description = $data['description'][$i][$j];
                         $sub_title = $data['sub_title'][$i][$j];
                         $id2 = $data['newid2'][$j];
                         $is_edit2 = false;
                         $self_id2 = 0;
                         if ($id) {
                             $is_edit2 = true;
                             $self_id2 = $id2;
                         }
                         if ($fileSub && $is_edit2 == false) {
                             $filename = uniqid() .'.'. $fileSub->getClientOriginalExtension();
                             $pathForDbIcon = 'product_images/'.$filename;
                             $fileSub->storeAs('public/product_images', $filename);
                        }else{
                         $pathForDbIcon = null;
                        }
                        if ($is_edit2) {
                             DB::table('my_products_subtitles')->where('id',$self_id2)->update([
                                 'sub_title' => $sub_title,
                                 'description' => $description,
                                 'my_subtitle_id'=>$dataTable->id,
                             ]);
                        }else{
                            DB::table('my_products_subtitles')->insert([
                             //'parent_id' => $response,
                             'sub_title' => $sub_title,
                             'description' => $description,
                             'icon' => $pathForDbIcon,
                             'my_subtitle_id'=>$dataTable->id,
                         ]);
                        }
                    }
                 }
                DB::commit();
                $this->setResponseCode(201);
                $this->apiResponse['message'] ='Product Specification Added successfully';
                $this->apiResponse['result'] = [];
            } catch (\Exception $ex) {
                DB::rollBack();
                $this->setResponseCode(500);
                $this->apiResponse['errors'] = $ex;
                $this->apiResponse['status'] = FALSE;
            }
        }
        return $this->sendResponse();
    }
//     public function getProductSpecification(string $id)
// {
 
//     {
//         $myproduct = DB::table('my_product_specifications')
//             ->where('my_product_id', $id)
//                 ->where('is_deleted', false)
//                 ->get();
            
//         if (!$myproduct) {
//             $this->setResponseCode(404);
//             $this->apiResponse['message'] = 'Data not found';
//             $this->apiResponse['status'] = false;
//         } else {
//             $this->setResponseCode(200);
//             $this->apiResponse['message'] = 'Myproduct retrieved successfully';
//             $this->apiResponse['result'] = $myproduct;
//         }
    
//         return $this->sendResponse();
//     }
    
// }
// 
// public function getProductSpecification(string $id)
// {
//     $myproduct = DB::table('my_product_specifications')
//         ->where('my_product_id', $id)
//         ->where('is_deleted', false)
//         ->get();
    
//     if (!$myproduct->isEmpty()) {
//         $formattedData = [
//             'features' => []
//         ];
        
//         $feature = [
//             'id' => null,
//             'my_product_id' => null,
//             'image_url' => null,
//             'title' => '',
//             'imagePosition' => '',
//             'subFeatures' => [],
//         ];
        
//         foreach ($myproduct as $product) {
//             $subFeature = [
//                 'name' => $product->sub_title,
//                 'description' => $product->description,
//                 'icon' => $product->icon,
//             ];
            
//             $feature['subFeatures'][] = $subFeature;
            
//             // Assign repetitive fields only once for the first iteration
//             if ($feature['id'] === null) {
//                 $feature['id'] = $product->my_product_id;
//                 $feature['my_product_id'] = $product->my_product_id;
//                 $feature['image_url'] = $product->image_url;
//                 $feature['title'] = $product->title;
//                 $feature['imagePosition'] = $product->image_position;
//             }
//         }
        
//         $formattedData['features'][] = $feature;
        
//         $this->setResponseCode(200);
//         $this->apiResponse['message'] = 'Myproduct retrieved successfully';
//         $this->apiResponse['result'] = $formattedData;
//     } else {
//         $this->setResponseCode(404);
//         $this->apiResponse['message'] = 'Data not found';
//         $this->apiResponse['status'] = false;
//     }

//     return $this->sendResponse();
// }
public function getProductSpecification(string $id)
{
    // $myproduct = DB::table('my_product_specifications')
    //     ->where('my_product_id', $id)
    //     ->where('is_deleted', false)
    //     ->get();
    $myproduct = MyProductSpecifications::with('subspecification')->where('my_product_id',$id)->where('is_deleted', false)->get();
    if (is_null($myproduct)) {
        // $formattedData = [
        //     'features' => []
        // ];

        // $feature = [
        //     'id' => $myproduct[0]->id,
        //     'my_product_id' => $myproduct[0]->my_product_id,
        //     'image_url' => $myproduct[0]->image_url,
        //     'title' => $myproduct[0]->title,
        //     'imagePosition' => $myproduct[0]->image_position,
        //     'subFeatures' => [],
        // ];

        // foreach ($myproduct as $product) {
        //     if ($product->title === $feature['title']) {
        //         $subFeature = [
        //             'id' => $product->id,
        //             'name' => $product->sub_title,
        //             'description' => $product->description,
        //             'icon' => $product->icon,
        //         ];

        //         $feature['subFeatures'][] = $subFeature;
        //     }
        // }

        // $formattedData['features'][] = $feature;
        $this->setResponseCode(404);
        $this->apiResponse['message'] = 'Data not found';
        $this->apiResponse['status'] = false;

    } else {
        $this->setResponseCode(200);
        $this->apiResponse['message'] = 'Myproduct retrieved successfully';
        $this->apiResponse['result'] = $myproduct;
    }

    return $this->sendResponse();
}
public function productSequnece(Request $request)
{
    $validator = Validator::make($request->all(), [
        // 'products' => 'required|array',
        '*.parent_id' => 'required',
        '*.order_id' => 'required'
    ]);
    if ($validator->fails()) {
        $this->setResponseCode(400);
        $this->apiResponse['message'] = $validator->messages()->first();
        $this->apiResponse['errors'] = $validator->errors();
        $this->apiResponse['status'] = false;
    } else {
        $products = $request->json()->all();
        foreach ($products as $product) {
            $parent_id = $product['parent_id'];
            $order_id = $product['order_id'];
            DB::table('myproduct_sequneceorders')
                ->updateOrInsert(
                    ['sequence_id' => $parent_id],
                    ['order_id' => $order_id]
                );
        }

        $this->setResponseCode(201);
        $this->apiResponse['message'] = 'Product Sequence added successfully';
        $this->apiResponse['result'] = [];
    }

    return $this->sendResponse();
}
public function getProductSequence(Request $request)
{
    $productSequences = DB::table('my_product_tablesequences')
        ->leftJoin('myproduct_sequneceorders', 'my_product_tablesequences.id', '=', 'myproduct_sequneceorders.sequence_id')
        ->select('my_product_tablesequences.*', 'myproduct_sequneceorders.*')
        ->orderBy('myproduct_sequneceorders.order_id')
        ->get();

    if ($productSequences->isEmpty()) {
        $this->setResponseCode(404);
        $this->apiResponse['message'] = 'No product sequences found';
        $this->apiResponse['result'] = [];
    } else {
        $this->setResponseCode(200);
        $this->apiResponse['message'] = 'Product sequences retrieved successfully';
        $this->apiResponse['result'] = $productSequences;
    }

    return $this->sendResponse();
}
public function getProductFeatureCompares(Request $request, $id)
{
  $productFeaturesCompares = MyProduct::whereNot('id',$id)->get();
    if ($productFeaturesCompares->isEmpty()) {
        $this->setResponseCode(404);
        $this->apiResponse['message'] = 'Product features compares not found for the specified parent ID.';
        $this->apiResponse['result'] = [];
    } else {
        $this->setResponseCode(200);
        $this->apiResponse['message'] = 'Product features compares retrieved successfully.';
        $this->apiResponse['result'] = $productFeaturesCompares;
    }

    return $this->sendResponse();
}
public function productFeaturesCompares(Request $request)
{
    $validator = Validator::make($request->all(), [
        
        '*.parent_id' => 'required',
        '*.my_product_with_id'=>'required'

    ]);
    if ($validator->fails()) {
        $this->setResponseCode(400);
        $this->apiResponse['message'] = $validator->messages()->first();
        $this->apiResponse['errors'] = $validator->errors();
        $this->apiResponse['status'] = FALSE;

    }else{
        $data = $request->json()->all();
        foreach ($data as $item) {
            $parent_id = $item['parent_id'];
            $my_product_with_id = $item['my_product_with_id'];
           
            DB::Table('my_product_features_compares')->insert([
                'my_product_id'=>$parent_id,
                'my_product_with_id'=>$my_product_with_id
            ]);
        }
        
        $this->setResponseCode(201);
        $this->apiResponse['message'] ='Product_features_compares Added Successfully';
        $this->apiResponse['result'] = [];
    }
    return $this->sendResponse();
}  
public function deleteGalleryImages(Request $request)
{ 
    // print_r($request->all());die;
    $validator = Validator::make($request->all(), [
        'path' => 'required',
    ]);

    if ($validator->fails()) {
        $this->setResponseCode(400);
        $this->apiResponse['message'] = $validator->messages()->first();
        $this->apiResponse['errors'] = $validator->errors();
        $this->apiResponse['status'] = FALSE;

    }else{
        $id = $request->path;
        $data = MyProductGalleries::where('is_deleted', false)
        ->where('image_path', $id)
        ->first();
        if ($data) {
            $data->update(['is_deleted'=> true]);
            $this->setResponseCode(200);
            $this->apiResponse['message'] = 'Image deleted successfully';
            $this->apiResponse['result'] = [];
        } else {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not found';
            $this->apiResponse['status'] = false;
        }
    }    
    return $this->sendResponse();
}
public function getProductPreview(string $id)
{
    try {
        // $data = MyProduct::with([
        //     'mainGallery',
        //     'features',
        //     'youtubelink',
        //     'sliderGallery',
        //     'specification',
        //     'specification.subspecification',
        //     'singleGallery',
        //     'review',
        //     'faq'
        //     ])->find($id);

        $getRelationalTable = DB::table('my_product_tablesequences')
            ->join('myproduct_sequneceorders','my_product_tablesequences.id', '=', 'myproduct_sequneceorders.sequence_id')
            ->orderBy('myproduct_sequneceorders.order_id')
            ->select('my_product_tablesequences.table')
            ->get();
            
        $orderedRelations =[];
        foreach ($getRelationalTable as  $value) {
            array_push($orderedRelations,$value->table);
        }
        
        $dataQuery = MyProduct::query();
     
        foreach ($orderedRelations as $orderBy) {
                $dataQuery->with([$orderBy]);
        }
       
        $data = $dataQuery->find($id);
  
        $compareData = [];
        $getCompareProductId = $this->compareProductFeatures($id);
        foreach ($getCompareProductId as $value) {
        $dataNN = $this->getProductF($value);
        array_push($compareData,$dataNN);
        }
      
        if (is_null($data)) {
            $this->setResponseCode(404);
            $this->apiResponse['message'] = 'Data not founded';
            $this->apiResponse['status'] = FALSE;

        }else{
            $data['compareProduct'] = $compareData;
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Product Data get successfully';
            $this->apiResponse['result'] = $data;
        }
        return $this->sendResponse();

    } catch (\Throwable $th) {
  
        $this->setResponseCode(500);
        $this->apiResponse['message'] = $th->getMessage();
        $this->apiResponse['status'] = FALSE;
        return $this->sendResponse();
    }
}   
public function productReview(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_name' => 'required',
        'rating' => 'required|numeric|max:5',
        'location' => 'required',
        'review' => 'required',
        'parent_id' => 'required',
    ]);

    if ($validator->fails()) {
        $this->setResponseCode(400);
        $this->apiResponse['message'] = $validator->messages()->first();
        $this->apiResponse['errors'] = $validator->errors();
        $this->apiResponse['status'] = FALSE;

    }else{
        $parent_id = $request->parent_id;
        $rating = $request->rating;
        $location = $request->location;
        $review = $request->review;
        $user_name = $request->user_name;


        $existData = DB::Table('my_product_reviews')->where('my_product_id',$parent_id)->where('user_name',$user_name)->exists();
        if ($existData) {
            $this->setResponseCode(400);
            $this->apiResponse['message'] = 'This user already given a product review';
            $this->apiResponse['errors'] = ['This user already given a product review'];
            $this->apiResponse['status'] = FALSE;
        }else{
            DB::Table('my_product_reviews')->insert([
                'my_product_id'=>$parent_id,
                'rating'=>$rating,
                'location'=>$location,
                'review'=>$review,
                'user_name'=>$user_name,
            ]);
            $this->setResponseCode(201);
            $this->apiResponse['message'] ='Product Review Added successfully';
            $this->apiResponse['result'] = [];
        }
        
        
    }
    return $this->sendResponse();
}
private function compareProductFeatures($mainProductId){
        
    $data = MyProductFeaturesCompareWith::
    join('my_products','my_product_features_compares.my_product_with_id', '=', 'my_products.id')->where('my_product_features_compares.my_product_id',$mainProductId)
    ->get();
    $newData = [];
   
    foreach ($data as $value) {
        if (!in_array($value->myProduct->id, $newData)) {
            array_push($newData,$value->myProduct->id);
        } 
        array_push($newData,$value->myProductWith->id);
    }

    return $newData;
}

private function getProductF($id){
    $data = MyProduct::with([
        'productImage',
        'assign_feature'
        ])->find($id);
        return $data;
}

}


