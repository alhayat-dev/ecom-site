<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use function foo\func;

class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page', 'categories');
        $categories = Category::with(['section', 'parentcategory'])->get();
//        $categories = json_decode(json_encode($categories));
//        echo "<pre>"; print_r($categories); die();
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
            $categoryData = array();
            $getCategories = array();
            $message = "Category added successfully.";
        }else{
            $title = "Edit Category";
            $categoryData = Category::where('id', $id)->first();
            $getCategories = Category::with('subcategories')->where([
                'parent_id' => 0,
                'section_id' => $categoryData['section_id'],

            ])->get();
//            $getCategories = json_decode(json_encode($getCategories), true);
//            echo "<pre>"; print_r($getCategories); die();

            $category = Category::find($id);
            $message = "Category updated successfully.";

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
            $request->session()->flash("success_message", $message);
            return redirect('admin/categories');
        }
        $sections = Section::get();
        return view('admin.categories.add_edit_category')->with(compact('title', 'sections','categoryData','getCategories'));
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

    // Delete category image
    public function deleteCategoryImage($id)
    {
        $categoryImage = Category::select('category_image')->where('id', $id)->first();

        $categoryImagePath = 'images/category_images/';
        $fileName = $categoryImagePath.$categoryImage->category_image;
        if (file_exists($fileName)){
            unlink($fileName);
        }
        Category::where('id', $id)->update(['category_image' => '']);
        Session::flash("success_message", "Category Image has been deleted successfully.");
        return redirect('admin/categories');
    }

    public function deleteCategory($id)
    {
        Category::where('id', $id)->delete();
        Session::flash("success_message", "Category has been deleted successfully.");
        return redirect('admin/categories');
    }
}
