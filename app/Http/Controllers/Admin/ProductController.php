<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function products()
    {
        Session::put('page', 'products');
        $products = Product::with(['category' => function($query){
            $query->select('id', 'category_name');
        }, 'section' => function($query){
            $query->select('id', 'name');
        }])->get();
//        $products = json_decode(json_encode($products));
//        echo "<pre>"; print_r($products); die();
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die(); */
            if ($data['status'] == 'Active'){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status'=> $status]);
            return response()->json(['status'=> $status, 'product_id' => $data['product_id']]);
        }
    }

    public function deleteProduct($id)
    {
        Product::where('id', $id)->delete();
        Session::flash("success_message", "Product has been deleted successfully.");
        return redirect('admin/products');
    }

    public function addEditProduct(Request $request, $id=null)
    {
        if (is_null($id)){
            $title = "Add Product";
            $product = new Product;
        }else{
            $title = "Edit Product";
        }

        if ($request->isMethod('post')){
            $data = $request->all();

//            echo "<pre>";
//            $data = json_decode(json_encode($data), true);
//            print_r($data); exit();
            // Product Validation
            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
            ];

            $customMessage = [
                'category_id.required' => 'Category is required',
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Valid Product Name is required.',
                'product_code.required' => 'Product Code is required',
                'product_code.regex' => 'Valid Product Code is required.',
                'product_price.required' => 'Product Price is required',
                'product_price.regex' => 'Product Price should be numeric.',
                'product_color.required' => 'Product Color is required',
                'product_color.regex' => 'Valid Product Code is required',
            ];
            $this->validate($request, $rules, $customMessage);

        }
        // Filter Arrays

        $fabricArray = array('Cotton', 'Polyester', 'Wool');
        $sleeveArray = array('Full Sleeve', 'Half Sleeve', 'Short Sleeve', 'Sleeveless');
        $patternArray = array('Checked', 'Plain', 'Printed', 'Self', 'Solid');
        $occassionArray = array('Casual', 'Formal');
        $fitArray = array('Regular', 'Slim');

        // Sections with categories and sub-categories
        $categories = Section::with('categories')->get();
//        $categories = json_decode(json_encode($categories));
//        echo "<pre>"; print_r($categories); die();
        return view('admin.products.add_edit_product')->with(compact('title', 'fabricArray',
            'sleeveArray', 'patternArray', 'occassionArray', 'fitArray','categories'));
    }
}
