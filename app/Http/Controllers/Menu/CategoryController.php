<?php

namespace App\Http\Controllers\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location\Stores;
use App\Models\Location\Brands;
use App\Models\UserRoles;
use App\Models\User;
use App\Models\Menu\Category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;


class CategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public $tabList;

    function __construct() {
        $this->middleware('auth');
        $this->tabList['tab'] = Helper::$menutab;
        $this->tabList['selected'] = 'category';
    }

    public function getIndex(Request $request) {

        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('category_view', $request)) !== true) {
              return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getCategoryListPaging($request);
        $total_page = Category::getCategoryCount();
        $table_header = array('Name','Parent Category', 'Store Name', 'Brand Name','Action');
        $return = view('menu.category.index', ['tabList' => $this->tabList,'count' => $total_page, 'results' => $results, 'tbl_header' => $table_header]);
        return $return;
    }

    public function Create(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('category_create', $request)) !== true) {
            return redirect()->action($return);
        }
        
        $categoryList = Category::getCategoryDropDownList();
        $storeList = Stores::getStoreDropDownList();


        $data=[
            'store_list'=>$storeList,
            'category_list' => $categoryList,
            'tabList' => $this->tabList,
        ];
        $view = view('menu.category.create',$data);
        return $view;
    }

    public function postStore(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('category_create', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $rules = array(
            'name' => 'required|min:3',
            'store' => 'required',
            'brand' => 'required'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $category = new Category();
        $parentId = $request->input('parent', null);
        $category->parent = Category::getCategoryByIds(array($parentId), ['name']);
        $category->name = $request->input('name', null);
        $storeId = $request->input('store', null);
        $category->store = Stores::getStoresByIds(array($storeId), ['name']);
        $brandId = $request->input('brand', null);
        $category->brand = Brands::getBrandsByIds(array($brandId), ['name']);
        $category->description = $request->input('description', null);
        $category->created_by = Auth::user()->_id;
        $category->updated_by = Auth::user()->_id;
        $category->status = 'disable';
        $category->save();
        $request->session()->flash('status', 'Category ' . $category->name . ' created successfully!');
        return redirect()->action('Menu\CategoryController@getIndex');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('category_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $category_data = Category::find($id);
        if(!is_array($category_data->parent)){
            $category_data->parent = array();
        }
        
        if (empty($category_data)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('CategoryController@getIndex');
        }

        $storeIdList = array_column($category_data->store, '_id'); 
        $storeId = array_pop($storeIdList); 

        $categoryList = Category::getCategoryDropDownList();
        unset($categoryList[$id]);
        $storeList = Stores::getStoreDropDownList();
        $brandsOfSelectedStore = Brands::getBrandByStoreId($storeId);
        foreach ($brandsOfSelectedStore as $brand) {
            $list[$brand['_id']] = $brand['name'];
        }
        $brandsOfSelectedStore = $list;

        $view = view('menu.category.edit', ['tabList' => $this->tabList,'category_data' => $category_data,'store_list'=>$storeList, 'brand_list' => $brandsOfSelectedStore,'category_list' => $categoryList]);
        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function postUpdate(Request $request, $id) {
        if (($return = UserRoles::hasAccess('category_update', $request)) !== true) {
            return redirect()->action($return);
        }



        $rules = array(
            'name' => 'required|min:3',
            'store' => 'required',
            'brand' => 'required'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $category = Category::find($id);
        $parentId = $request->input('parent', null);
        $category->parent = Category::getCategoryByIds(array($parentId), ['name']);
        $category->name = $request->input('name', null);
        $storeId = $request->input('store', null);
        $category->store = Stores::getStoresByIds(array($storeId), ['name']);
        $brandId = $request->input('brand', null);
        $category->brand = Brands::getBrandsByIds(array($brandId), ['name']);
        $category->description = $request->input('description', null);
        $category->updated_by = Auth::user()->_id;
        $category->save();
        $request->session()->flash('status', 'Category ' . $category->name . ' Updated successfully!');
        return redirect()->action('Menu\CategoryController@getIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDestroy(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('category_delete', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $category = Category::find($id);
        $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');
        if(file_exists($dest.$category->logo)){
         //   @unlink($dest.$category->logo);
        }
        $category->status = 'disable';
        $category->deleted_at = Carbon::now();
        $category->updated_by = Auth::user()->_id;
        $category->save();
        $request->session()->flash('status', 'Successfully deleted the Category!');
        return redirect()->action('Menu\CategoryController@getIndex');
    }

    public function getUpdateStatus(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('category_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $category = Category::find($id);
        $category->updated_at = Carbon::now();
        $category->updated_by = Auth::user()->_id;
        $category->status = $category->status == 'enable' ? 'disable' : 'enable';
        $category->save();
        $request->session()->flash('status', $category->name . ' status changed to ' . $category->status . ' Successfully!');
        return redirect()->action('Menu\CategoryController@getIndex');
    }

    public function getCategoryListPaging(Request $request) {

        $page_no = $request->has('page') ? $request->input('page') : 1;
        $search_value = $request->has('search') ? $request->input('search') : '';
        $search_field = $request->has('search_by') ? $request->input('search_by') : 'name';
        $limit = $request->has('limit') ? (int) $request->input('limit') : 10;
        $search = array(); //this have  as Key=search field and value= search value
        if (!is_numeric($limit)) {
            return "limit should be numeric";
        }
        if (!empty($search_value)) {
            $search['key'] = $search_field;
            $search['value'] = $search_value;
        }
        $sort_by = $request->has('sort_by') ? $request->input('sort_by') : '_id';
        $sort_dir = $request->has('sort_dir') ? $request->input('sort_dir') : 'desc';
        $results = Category::categoryList($sort_by, $sort_dir, $search, true)->paginate($limit);
        return $results;
    }

}
