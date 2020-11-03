<?php

namespace App\Http\Controllers;

use Str;
use App\{Post, Tag, Category};
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(6);
        return view('posts.index',compact('posts'));
    }
    
    public function show(Post $post)
    {
        $posts = Post::where('category_id', $post->category_id)->latest()->limit(3)->get();
        return view('posts.show', compact('post', 'posts'));
    }
    
    //Input data
    public function create()
    {
        return view('posts.create',[
            'post' => new Post(),
            'tags' => Tag::get(),
            'categories' => Category::get(),    
        ]);
    }
    
    public function store(PostRequest $request)
    {
        //Validasi data
        $kirim = $request->all();
        
        //Assign title to slug
        $kirim['slug'] = Str::slug($request->title);

        $thumbnail = $request->file('thumbnail') ? $request->file('thumbnail')->store("images/posts") : null;

        $kirim['thumbnail'] = $thumbnail;
        $kirim['category_id'] = $request->category;

        //send data to database
        $post = auth()->user()->posts()->create($kirim);    
        $post->tags()->attach($request->tags);

        //alert success
        session()->flash('success','The post was created');

        return redirect('posts');
    }

    //Edit and Update
    public function edit(Post $post)
    {
        return view('posts.edit',[
            'post' => $post,
            'tags' => Tag::get(),
            'categories' => Category::get(),
            ]);
    }

    public function update(Post $post, PostRequest $request)
    {
        //policy
        $this->authorize('update', $post);

        //Validasi data
        $kirim = $request->all();

        if ($request->file('thumbnail')) {
            \Storage::delete($post->thumbnail);
            $thumbnail = $request->file('thumbnail')->store("images/posts");
        }else{
            $thumbnail = $post->thumbnail;
        }

        $kirim['thumbnail'] = $thumbnail;
        $kirim['category_id'] = $request->category;

        //Update data
        $post->update($kirim);
        $post->tags()->sync($request->tags);

        //Alert success
        session()->flash('success','The post was updated');
        
        return redirect('posts');
    }

    //Delete data
    public function destroy(Post $post)
    {
        //Policy
        $this->authorize('delete', $post);

        \Storage::delete($post->thumbnail);
        $post->tags()->detach();
        $post->delete();

        session()->flash("error", "The post was destroyed");

        return redirect('posts');
    }
}
