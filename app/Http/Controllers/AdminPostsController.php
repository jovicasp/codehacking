<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsRequest;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
//        $post9 = Post::find(9);
//        dd($post9->categories);

//        $post10 = Post::find(10);
//        dd($post10->categories);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->toArray();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsRequest $request)
    {
        $input = $request->all();
        $user = Auth::user();

//        $input['user_id'] = $user->id;
//        $post = Post::create($input);
        //GORNJA 2 REDA ZAMENJUJEMO SA DONJIM!!! -Pretpostavlja se da nikad admin ili neko drugi nece da pravi post za
        // nekog drugog usera, vec da ce ulogovani user da si pravi za sebe.
        $post = $user->posts()->create($input);

        if ($file = $request->file('photo')) {
            $name = $this->photoProcess($file);
            $photo = Photo::create(['path' => $name, 'imageable_id' => $post->id, 'imageable_type' => 'App\Models\Post']);
        }
        foreach ($request->categories as $id) {
            $post->categories()->attach($id);
        }
        Session::flash('created_post', 'The post ' . $post->title . ' has been created!');
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::pluck('name', 'id')->toArray();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostsRequest $request, $id)
    {
        //FOR UPDATE SOMEONE'S OTHER POST
        if (Auth::user()->role_id == 1) {
            $post = Post::findOrFail($id);
            $input = $request->all();
//            $user = Auth::user();
            $input['user_id'] = $post->user_id;
        } else {
            //FOR UPDATE YOUR OWN POST
            //GORNJA 4 REDA ZAMENJUJEMO SA DONJA 2-PREKO RELACIJA!!!	IPAK NE!
            // Ovo je moguce kada autorizovani user menja svoj post, ali NE FUNKCIONISE KAD ADMIN(mada to  ne bi  ni imao pravo)
            // PROBA DA MENJA TUDJI POST. ZATO MORAMO KAO GORE PRVO DA NADJEMO POST i id usera-vlasnika tog posta, PA ONDA OSTALO.
            $post = Auth::user()->posts()->whereId($id)->first();
        }
        $post->update($input);


        if ($file = $request->file('photo')) {
            $name = $this->photoProcess($file);
            if ($photo = $post->photos->first()) {
                $path = public_path() . $photo->path;
                if (File::exists($path)) {
                    unlink(public_path() . $photo->path);
                }
                $photo->update(['path' => $name]);
            } else {
                $photo = Photo::create(['path' => $name, 'imageable_id' => $post->id, 'imageable_type' => 'App\Models\Post']);
            }
        }
        $category_ids = $request->categories;
        if ($category_ids[0] === null) {
            $category_ids = [];
        }
        $post->categories()->sync($category_ids);
        Session::flash('updated_post', 'The post ' . $post->title . ' has been updated!');
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($photo = $post->photos->first()) {
            $photo->delete();                                       //DELETE FROM DB-TABLE-PHOTOS
            $path = public_path() . $photo->path;
            if (File::exists($path)) {
                unlink(public_path() . $photo->path);       //DELETE FILE FROM PUBLIC/IMAGES FOLDER
            }
        }
        $post->categories()->detach();
        Session::flash('deleted_post', 'The post  ' . $post->title . ' has been deleted!');
        $post->delete();
        return redirect(route('posts.index'));
    }
    public function photoProcess($file)
    {   $name = time() . "-" . $file->getClientOriginalName();
        $file->move('images', $name);
        return $name;    }

}