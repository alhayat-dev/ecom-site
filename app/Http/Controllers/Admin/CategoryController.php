<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page', 'categories');
        $categories = Category::get();
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }

            Category::where('id', $data['category_id'])->update([
                'status' => $status
            ]);
            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id=null)
    {
        if (is_null($id)){
            $title = "Add Category";
            $category = new Category();
        }else{
            $title = "Edit Category";
        }

        if ($request->isMethod('POST')){
            $data = $request->all();
            // Validation logic
            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
                'category_image' => 'image'
            ];

            $customMessage = [
                'category_name.required' => 'Category Name is required',
                'section_id.required' => 'Section is required',
                'category_name.regex' => 'Valid Category Name is required.',
                'url.required' => 'Category URL is required',
                'admin_image.image' => 'Please upload the valid image file',
            ];
            $this->validate($request, $rules, $customMessage);

            if ($request->hasFile('category_image')){
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate the new image
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/category_images/'. $imageName;
                    // upload the image
                    Image::make($image_tmp)->save($imagePath);
                    // Save the category image
                    $category->category_image = $imageName;
                }
            }

            if (empty($data['description'])){
                $data['description'] = "";
            }
            if (empty($data['meta_description'])){
                $data['meta_description'] = "";
            }
            if (empty($data['category_name'])){
                $data['category_name'] = "";
            }
            if (empty($data['meta_title'])){
                $data['meta_title'] = "";
            }
            if (empty($data['meta_keywords'])){
                $data['meta_keywords'] = "";
            }

            $category->category_name = $data['category_name'];
            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->meta_description = $data['meta_description'];
            $category->status = 1;
            $category->save();
            $request->session()->flash("success_message", "Category added successfully.");
            return redirect('admin/categories');
        }
        $sections = Section::get();
        return view('admin.categories.add_edit_category')->with(compact('title', 'sections'));
    }

    public function appendCategoryLevel(Request $request)
    {
        if ($request->ajax()){
            $data = $request->all();

//            echo "<pre>"; print_r($data); die();

            $getCategories = Category::with('subcategories')->where([
                'section_id' => $data['section_id'],
                'parent_id' => 0,
                'status' => 1
            ])->get();

            $getCategories = json_decode(json_encode($getCategories), true);
//            echo "<pre>"; print_r($getCategories); die();
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }
}
