<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){

        $blogs = Blog::get();

        return view('pages.blog.index', compact('blogs'));
    }

    public function create(){

        return view('pages.blog.create');
    }

    public function store(StoreBlogRequest $request){

        //1) GET DATA
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'token' => md5($request->title.'+'.date('d/m/Y H:i:s')),
            'is_active' => 1,
        ];

        $image = $request->file('image');

        if ($image != null) {
            
            $folder = '/blog';

            if (!is_dir(storage_path('/app/public').$folder)) {
                
                mkdir(storage_path('/app/public').$folder, 0777, true);
            }

            $ext = '.'.$image->guessExtension();
            $path = $folder.'/'.$data['token'].$ext;

            move_uploaded_file($image, storage_path('/app/public').$path);

            $data['image'] = $path;
        }
        //2) STORE DATA

        $blog = new Blog($data);
        $blog->save();

        //3) RETURN REDIRECT

        return redirect( route('blog.index') )->with('status', 'success')->with('message', 'Entrada del blog creada.');
    }
    

    public function changeState(Request $request){

        $blog = Blog::where('token', $request->token)->first();

        if ($blog->is_active == 1) {
            
            $blog = Blog::where('token', $request->token)->update(['is_active' => 0]);
            return response()->json(['status' => 'success', 'message' => 'Entrada inactiva.']);
        }else{
            
            $blog = Blog::where('token', $request->token)->update(['is_active' => 1]);
            return response()->json(['status' => 'success', 'message' => 'Entrada activa.']);
        }

        

    }


    public function edit($token){

        $blog = Blog::where('token', $token)->first();

        return view('pages.blog.edit', compact('blog'));
    }

    public function update(UpdateBlogRequest $request){

        //1) GET DATA
        $blog = Blog::where('token', $request->token)->first();
        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        $image = $request->file('image');

        if ($image != null) {
            
            $folder = '/blog';

            if (!is_dir(storage_path('/app/public').$folder)) {
                
                mkdir(storage_path('/app/public').$folder, 0777, true);
            }

            if (is_file(storage_path('/app/public').$blog->image)) {
                
               unlink(storage_path('/app/public').$blog->image);
            }

            $ext = '.'.$image->guessExtension();
            $path = $folder.'/'.$blog->token.$ext;

            move_uploaded_file($image, storage_path('/app/public').$path);

            $data['image'] = $path;
        }
        //2) UPDATE DATA

        $blog = Blog::where('token', $request->token)->update($data);

        //3) RETURN REDIRECT

        return redirect( route('blog.index') )->with('status', 'success')->with('message', 'Entrada del blog editada.');
    }

    public function delete(Request $request){

        $blog = Blog::where('token', $request->token)->delete();

        return redirect( route('blog.index') )->with('status', 'success')->with('message', 'Entrada del blog eliminada.');
    }


    public function preview($token){

        $blog = Blog::where('token', $token)->first();

        return view('pages.blog.preview', compact('blog'));
    }
}
