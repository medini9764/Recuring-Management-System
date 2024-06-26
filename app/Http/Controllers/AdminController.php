<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function category()
	{
		$datas=DB::table('categories')
			->get();


		return view('category.category',compact('datas'));
	}
    public function addCategory(Request $request){
        try {
            DB::table('categories')->insert(
                [
                    'name' => $request->category_name,
                    'description' => $request->category_description,
                ]
            );
    
            return response()->json(['success' => true, 'message' => 'Category added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'There was an issue adding the category.']);
        }
    }
    public function editCategory(Request $request){
        try {
            DB::table('categories')
            ->where('id', $request->category_id)
            ->update(
                [
                    'name' => $request->category_name,
                    'description' => $request->category_description,
                ]
            );
    
            return response()->json(['success' => true, 'message' => 'Category added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'There was an issue adding the category.']);
        }
    }
    

}
