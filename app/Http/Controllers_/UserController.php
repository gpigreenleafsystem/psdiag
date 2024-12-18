<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
	    return view('users.index', ['users' => $model->paginate(5)]);
    }
    public function logout(){
	    $this->Auth::logout();
	    Session::flush();
	    redirect('/');}

    public function adduser(){
	    //return "From Add User";
	    return view('users.adduser');

    }
public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
	    'password' => ['required', 'string', 'min:8', 'confirmed'],
	   'usertype' => ['required', 'string', 'max:10'],
        ]);
}
public function createuser(Request $request){
	//dd($request->all());
	$name = $request->name;
	$email = $request->email;
	$password = $request->password;
	$usertype = $request->usertype;


	$user = new User();
	$user->name = $name;
	$user->email= $email;
	$user->password= Hash::make('$password');
	$user->usertype= $usertype;
	$user->save();

	return redirect()->to('/usermanagement')->with('success','User added sucessfully');
}
    public function edituser($id){
	    
	    $user=User::where('id','=',$id)->first();
	  // return $user ;
	   return view('users.edituser',compact('user'));
    }
public function updateuser(Request $request){
	$id=$request->id;
	$name = $request->name;
	$email = $request->email;
	$password = $request->password;
	$usertype = $request->usertype;

	User::where('id','=',$id)->update([
		'name'=>$name,
		'email'=>$email,
		'password'=>$password,
		'usertype'=>$usertype
	]);

	return redirect()->to('/usermanagement')->with('success','User updated sucessfully');
}
public function deleteuser($id){
	User::where('id','=',$id)->delete();
	return redirect()->to('/usermanagement')->with('success','User deleted sucessfully');

}

}
