<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MongoDB\Driver\Session;

class AdminController extends Controller
{
    public function dashboard()
    {
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
                Session::flash("error_message", "Your current password is incorrect");
            }
            return redirect()->back();
        }
    }
}
