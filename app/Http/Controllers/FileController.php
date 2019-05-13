<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\File;
use File as FileManager;

class FileController extends Controller
{
   public function store(Request $request){
   	 $this->validate($request, [
		'title'=>'required',
    'description'=>'required',
		'file'=>'required|max:30000',
    ]);
	
   	    $FileInstance = new File();
        $FileInstance->title = $request->input('title');
        $FileInstance->description= $request->input('description');
      
        $FileInstance->path = $this->createpath($request);
        $FileInstance->save();
        
        return response()->json(["files"=> $FileInstance], 201);
   }

   public function updateFile( Request $request, $id){
   	$this->validate($request, [
		'title'=>'required',
    'description'=>'required',
		'file'=>'|max:300000',
    ]);

   	$FileInstance = file::find($id);
   	if ($FileInstance){

   		$FileInstance->title = $request->input('title');
        $FileInstance->description= $request->input('description');
        if ($request->hasFile('file')) {
        	FileManager::delete(public_path().$FileInstance->path);
        	$path = $this->createpath($request);
        	$FileInstance->path = $path;
        }
        $FileInstance->save();
        return response()->json(["files"=> $FileInstance, 'message'=>" the file with id 
    	$FileInstance->id  has been updated "], 201);

   	}
        
         return response()->json(['message'=>'the file with id 
    	$id cannot be found'], 404);
   }

        /*
        *****creating path parameter for the file
        */
      

      public function createpath(Request $request){

   	    $file = $request->file('file');
        $path='/files/';
        $name= sha1(Carbon::now()).'.'.$file->guessExtension();
        $file->move(public_path().$path, $name);

        return $path.$name;

   }
   

   public function getAllFiles(){
      $FileInstances = file::all();

      return response()->json($FileInstances, 201);

   }

 
  public function getFile($id){
     $FileInstance =file::find($id);
     if ($FileInstance) {
        return response()->json(['file'=>$FileInstance], 200);
     }

      return response()->json(['message'=>'file not found'], 200);

    }

    public function downloadFile($id)
    { 
      $FileInstance =file::find($id);
      $myFile = public_path().$FileInstance->path;
      $headers = ['Content-Type: application/pdf'];
      $newName = $FileInstance->title.time();




      return response()->file($myFile, $headers);
      //return response()->file($myFile, $headers);
    }
 

    public function DeleteFile(){

      $FileInstance = file::find($id);
    if ($FileInstance){
      FileManager::delete(public_path().$FileInstance->path);
      $FileInstance->delete();
      return response()->json(['message'=>"file deleted"], 200);
       }
       return response()->json(['message'=>'file not found'], 200);
     }
     
}
