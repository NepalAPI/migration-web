<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Nrna\Services\PostService;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @var PostService
     */
    private $post;

    /**
     * constructor
     * @param PostService $post
     */
    public function __construct(PostService $post)
    {
        $this->middleware('auth');
        $postId = \Route::current()->getParameter('post');
        if ($postId && auth()->user()->id !== $post->find($postId)->user->id) {
            $this->middleware('permission:manage-all-content');
        }

        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $posts = $this->post->all($request->all());

        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created.
     *
     * @param  PostRequest $request
     * @return Response
     */
    public function store(PostRequest $request)
    {
        if ($this->post->save($request->all())) {
            return redirect()->route('post.index', getQueryParams($request->fullUrl()))->with(
                'success',
                'Post saved successfully.'
            );
        };

        return redirect('post')->with('error', 'There is some problem saving post.');
    }

    /**
     * Display the specified post.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $post = $this->post->find($id);

        if (is_null($post)) {
            return redirect()->route('post.index')->with('error', 'Post not found.');
        }

        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $post = $this->post->find($id);
        if (is_null($post)) {
            return redirect()->route('post.index')->with('error', 'Post not found.');
        }

        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  PostRequest $request
     * @return Response
     */
    public function update($id, PostRequest $request)
    {
        $post = $this->post->find($id);
        if (is_null($post)) {
            return redirect()->route('post.index')->with('error', 'Post not found.');
        }
        if ($this->post->update($id, $request->all())) {
            return redirect()->route('post.index', getQueryParams($request->fullUrl()))->with(
                'success',
                'Post successfully updated!'
            );
        }

        return redirect('post')->with('error', 'Problem updating Post!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int    $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        if ($this->post->delete($id)) {
            return redirect()->route('post.index', getQueryParams($request->fullUrl()))->with(
                'success',
                'Post successfully deleted!'
            );
        }

        return redirect('post')->with('error', 'Error deleting Post !');
    }
}
