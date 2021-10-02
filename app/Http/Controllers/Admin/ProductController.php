<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Product\StoreProduct;
use App\Location;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share('pageTitle', __('menu.products'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_business_service'), 403);

        if(\request()->ajax()){
            $products = Product::all();

            return \datatables()->of($products)
                ->addColumn('action', function ($row) {
                    $action = '';

                    if ($this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_business_service')) {
                        $action.= '<a href="' . route('admin.products.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                          data-toggle="tooltip" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                    }

                    if ($this->user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_business_service')) {
                        $action.= ' <a href="javascript:;" class="btn btn-danger btn-circle delete-row"
                          data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';
                    }

                    return $action;
                })
                ->addColumn('image', function ($row) {
                    return '<img src="'.$row->product_image_url.'" class="img" width="50em" /> ';
                })
                ->editColumn('name', function ($row) {
                    return ucfirst($row->name);
                })
                ->editColumn('status', function ($row) {
                    if($row->status == 'active'){
                        return '<label class="badge badge-success">'.__("app.active").'</label>';
                    }
                    elseif($row->status == 'deactive'){
                        return '<label class="badge badge-danger">'.__("app.deactive").'</label>';
                    }
                })
                ->editColumn('location_id', function ($row) {
                    return ucfirst($row->location->name);
                })
                ->editColumn('price', function ($row) {
                    return $row->price;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'image', 'status'])
                ->toJson();
        }

        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_business_service'), 403);

        $locations = Location::orderBy('name', 'ASC')->get();

        return view('admin.products.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_business_service'), 403);

        $product = new product();
        $product->name = $request->name;
        $product->description = clean($request->description);
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->discount_type = $request->discount_type;
        $product->discount = $request->discount;
        $product->location_id = $request->location_id;
        $product->save();

        return Reply::dataOnly(['productID' => $product->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_business_service'), 403);

        $locations = Location::orderBy('name', 'ASC')->get();

        $images = [];
        if ($product->image) {
            foreach ($product->image as $image)
            {
                if(File::exists('user-uploads/product/'.$product->id.'/'.$image)==true )
                {
                    $reqImage['name'] = $image;
                    $reqImage['size'] = filesize(public_path('/user-uploads/product/'.$product->id.'/'.$image));
                    $reqImage['type'] = pathinfo(public_path('/user-uploads/product/'.$product->id.'/'.$image), PATHINFO_EXTENSION);
                    $images[] = $reqImage;
                }
            }
        }
        $images = json_encode($images);

        /* push all previous assigned services to an array */
        $selectedUsers = array();

        return view('admin.products.edit', compact('product', 'locations', 'images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProduct $request, $id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('update_business_service'), 403);

        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = clean($request->description);
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->discount_type = $request->discount_type;
        $product->location_id = $request->location_id;
        $product->status = $request->status;
        $product->save();

        return Reply::dataOnly(['productID' => $product->id, 'defaultImage' => $request->default_image ?? 0]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_business_service'), 403);

        Product::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }

    public function storeImages(Request $request)
    {
        if ($request->hasFile('file')) {
            $product = Product::where('id', $request->product_id)->first();
            $product_images_arr = [];

            foreach ($request->file as $fileData) {
                array_push($product_images_arr, Files::upload($fileData, 'product/'.$product->id));
            }
            $product->image = json_encode($product_images_arr);
            $product->default_image = $product_images_arr[0];
            $product->save();
        }

        return Reply::redirect(route('admin.products.index'), __('messages.createdSuccessfully'));
    }

    public function updateImages(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();

        $product_images_arr = [];
        $default_image_index = 0;

        if ($request->hasFile('file')) {
            if ($request->file[0]->getClientOriginalName() !== 'blob') {
                foreach ($request->file as $fileData) {
                    array_push($product_images_arr, Files::upload($fileData, 'product/'.$product->id));
                    if ($fileData->getClientOriginalName() == $request->default_image) {
                        $default_image_index = array_key_last($product_images_arr);
                    }
                }
            }
            if ($request->uploaded_files) {
                $files = json_decode($request->uploaded_files, true);
                foreach ($files as $file) {
                    array_push($product_images_arr, $file['name']);
                    if ($file['name'] == $request->default_image) {
                        $default_image_index = array_key_last($product_images_arr);
                    }
                }
                $arr_diff = array_diff($product->image, $product_images_arr);

                if (sizeof($arr_diff) > 0) {
                    foreach ($arr_diff as $file) {
                        Files::deleteFile($file, 'service/'.$product->id);
                    }
                }
            }
            else {
                if (!is_null($product->image) && sizeof($product->image) > 0) {
                    Files::deleteFile($product->image[0], 'service/'.$product->id);
                }
            }
        }

        $product->image = json_encode(array_values($product_images_arr));
        $product->default_image = sizeof($product_images_arr) > 0 ? $product_images_arr[$default_image_index] : null;
        $product->save();

        return Reply::redirect(route('admin.products.index'), __('messages.updatedSuccessfully'));
    }
}
