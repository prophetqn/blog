<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule as ValidationRule;

class AdminPostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::paginate(10)
        ]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store()
    {
        Post::create(array_merge($this->validatePost(), [
            'user_id' => auth()->id(),
            'slug' => Str::slug(request('title')),
            'thumbnail' => request()->file('thumbnail')->store('thumbnail')
        ]));

        return redirect('/')->with('success', 'You created a post!');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'post' => $post
        ]);
    }

    public function update(Post $post)
    {
        $attributes = $this->validatePost($post);

        $attributes['slug'] = Str::slug($attributes['title']);

        if (isset($attributes['thumbnail'])) {
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnail');
        }

        $post->update($attributes);

        return back()->with('success', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('success', 'Post deleted!');
    }

    protected function validatePost(?Post $post = null): array
    {
        if (! isset($post)) {
            $post = new Post();
        }

        return request()->validate([
            'category_id' => ['required', ValidationRule::exists('categories', 'id')],
            'title' => 'required',
            'thumbnail' => $post->exists() ? 'image' : 'required|image',
            'excerpt' => 'required',
            'body' => 'required'
        ]);
    }
}
