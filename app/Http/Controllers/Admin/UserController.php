<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\UserLoginOtp;
use App\Helpers\Helper;
use Session;
use Auth;

class UserController extends Controller
{   
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show Users List.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function usersListView()
    {   
        return view('admin.user.users_list');
    }

    public function usersList(){
        $data = [];
        $getUsers = User::where('id', Auth::user()->id)->orWhere('role','shop_keeper')->get()->toArray();
//$data = $getUsers;
        if(count($getUsers) > 0){
            foreach ($getUsers as $user) {
                
                $data[] = [$user['id'], $user['name'], $user['email'], $user['mobile_number'], $user['room_number'], Helper::encrypt($user['id'])];
            }
        }

        return response()->json($data);
    }

        public function addUserUpdate(Request $request){
        $id = Helper::decrypt($request->user_update_id);
        
        if($request->name == "")
        {
            $msg = 'Please enter name';
        }
        else if($request->email  == "")
        {
            $msg = 'Please enter email';
        }
        else if($request->mobile_number == "")
        {
            $msg = 'Please enter mobile_number';
        }
        else if($request->room_number == "")
        {
            $msg = 'Please enter address';
        }
        /*else if($request->password == "")
        {
            $msg = 'Please enter password';
        }
        else if($request->user__confirm_password == "")
        {
            $msg = 'Please enter confirm password';
        }
        else if($request->user_password != $request->user__confirm_password)
        {
            $msg = 'password mismatched';
        }*/
        else{
        
        User::where('id',$id)->update(["name"=> $request->name,"email"=> $request->email,"mobile_number"=> $request->mobile_number,"room_number"=> $request->room_number]);
             $msg = 'user Updated successfully.';
        }

         return back()->with('message', $msg);
    }

    public function getuserDetails($id){
        return Helper::getuserAllDetails($id);
    }

}
