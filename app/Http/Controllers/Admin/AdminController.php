<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page', 'dashboard');
        return view('admin.admin_dashboard');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required'
            ];

            $customMessages = [
                'email.required' => 'Email Address is required',
                'email.email' => 'Valid email is required',
                'password.required' => 'Password is required'
            ];

            $this->validate($request, $rules, $customMessages);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])){
                return redirect('admin/dashboard');
            }else{
                $request->session()->flash("error_message", "Invalid Email or Password");
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function settings()
    {
        Session::put('page', 'settings');
        $adminDetails = Admin::where("email", Auth::guard("admin")->user()->email)->first();
        return view('admin.admin_settings')->with(compact('adminDetails'));
    }

    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();
        if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
            echo "true";
        }else{
            echo "false";
        }
    }

    public function updateCurrentPassword(Request $request)
    {
        if ($request->isMethod('post')){
            $data = $request->all();
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
                if ($data['new_password'] == $data['confirm_password']){
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    $request->session()->flash("success_message", "Password has been changed successfully..");
                }else{
                    $request->session()->flash("error_message", "New password and confirm password mismatch.");
                }
            }else{
                $request->session()->flash("error_message", "Your current password is incorrect");
            }
            return redirect()->back();
        }
    }

    public function updateAdminDetails(Request $request)
    {
        Session::put('page', 'update-admin-details');
        if ($request->isMethod('post')){
            $data = $request->all();
            // Validation logic
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'image'
            ];

            $customMessage = [
                'admin_name.required' => 'Name is required',
                'admin_mobile.required' => 'Mobile number is required.',
                'admin_mobile.numeric' => 'Please enter the valid mobile number.',
                'admin_image.image' => 'Please upload the valid image file',
            ];
            $this->validate($request, $rules, $customMessage);

            // image validation

            if ($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate the new image
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/admin_images/admin_photos/'. $imageName;
                    // upload the image
                    Image::make($image_tmp)->save($imagePath);
                }elseif (!empty($data['current_admin_image'])){
                    $imageName = $data['current_admin_image'];
                }else{
                    $imageName = '';
                }
            }
            // update the admin details
            Admin::where('email', Auth::guard('admin')->user()->email)
                ->update([
                    'name' => $data['admin_name'],
                    'mobile' => $data['admin_mobile'],
                    'image' => $imageName,
                ]);
            $request->session()->flash("success_message", "Admin Details updated successfully.");
            return redirect()->back();
        }
        return view('admin.update_admin_details');
    }
}
