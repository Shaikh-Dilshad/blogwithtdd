<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Blog;
class BlogController extends Controller
{
    public function create(){
        return view('blogs.create');
    }

   
    public function store(Request $req){
        
        $imageName = time().'.'.$req->image->extension();
        $req->image->move(public_path('blogsimg'),$imageName);
        
        $blog = new Blog;
        $blog->id = $req->id;
        $blog->image = $imageName;
        $blog->title = $req->title;
        $blog->description = $req->description;
        $blog->save();
        return response($blog , 201);
        }
 public function list(){
       $blogs = Blog::get();
        return response($blogs , 200);
    }
    public function edit($id){
        $blogs = Blog::find($id);
        return view('blogs.edit',['edit'=>$blogs]);

    }

    public function update(Request $req , $id){
        $blogs = Blog::find($id);
        if(isset($req->image)){
        $imageName = time().'.'.$req->image->extension();
        $req->image->move(public_path('blogsimg'),$imageName);
        $oldimage =  $blogs->image;
        File::delete(public_path('blogsimg') . '/' . $oldimage);
        $blogs->image = $imageName;
    }
        $blogs->title = $req->title;
        $blogs->description = $req->description;
         $redirect =  $blogs->save();
        return response($blogs , 201);
       
    }

    public function destroy($id){
        $delete = Blog::find($id);
        $oldimage = $delete->image;
        File::delete(public_path('blogsimg') . '/' . $oldimage);

        $delete->delete();
        return response($delete,204);
    }
}
