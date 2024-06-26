<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

	protected $user;
	function __construct(User $user)
	{
		$this->user=$user;
	}

	public function viewProfile()
	{
		return view('user_profile');
    }

	public function updateProfile(Request $request)
	{

		$user_id=Auth::user()->id;
		$users=$this->user->findOrFail($user_id);
		
		$response=$users->fill([
			'name'=>$request->name,
			'email'=>$request->email,
			'contact_no'=>$request->contact_no,
			'batch'=>$request->batch,
			'password'=>$request->password?bcrypt($request->password):$users->password,
		])->save();
		
		if ($response==true){
			return 1;
		}else{
			return 0;
		}

	}
	public function uploadImage(Request $request){
		$data['user_id'] = Auth::user()->id;
		 // Validate the request
		 $validatedData = $request->validate([
			'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max size 2MB
		]);
        if($request['image']){
            //image upload to public folder
            $image['name'] = $request->file('image')->store('image', 'public');
            //image path save in image table
            //$new_logo = Image::create($image);
            $data ['image'] = $image['name'];
        }
		$users=$this->user->findOrFail($data['user_id']);
		$users->update(['image' => $data['image']]);

		return redirect()->back();
	}
}
