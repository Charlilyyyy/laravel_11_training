<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PostResource;
use App\Http\Requests\PostRequest;
use App\Repositories\PostRepository;

class HomeController extends Controller
{
    public function __construct(protected PostRepository $postRepository){
        $this->middleware('auth');
    }

    public function index($type = 'home'){
        $validTypes = ['home', 'my_posts', 'my_replies', 'my_bookmarks'];
        if (!in_array($type, $validTypes)) {
            return redirect()->route('home'); // Redirect to the default home route
        }

        $postPlural = Post::query();

        if ($type == 'home'){
            $postPlural = $postPlural->whereNull('parent_post_id');
        } elseif ($type == 'my_posts'){
            $postPlural = $postPlural->where('user_id',Auth::id())->whereNull('parent_post_id');
        } elseif ($type == 'my_replies'){
            $postPlural = $postPlural->where('user_id',Auth::id())->whereNotNull('parent_post_id');
        } elseif ($type == 'my_bookmarks'){
            $postPlural = $postPlural->whereHas('interactionPlural', function ($query) {
                $query->where('user_id',Auth::id());
            });
        }

        $posts = PostResource::collection($postPlural->orderByDesc('created_at')->paginate(10));

        $data = [
            'postPlural' => $posts,
            'type' => $type,
        ];

        return view('home', $data);
    }

    public function postDetail($id){
        $postSingular = Post::find($id);

        $childPostPlural = Post::where('parent_post_id',$id)->paginate(10);

        $data = [
            'postSingular' => $postSingular,
            'childPostPlural' => $childPostPlural,
        ];

        return view('details', $data);
    }

    public function postCreate(PostRequest $request, $id = null){
        $request->validated();

        $post = $this->postRepository->createPost($request->only('context'), $id);

        if ($post) {
            if ($id != null) {
                return Redirect::route('postDetail', [$id])->with('successMessage', 'Information successfully created!');
            } else {
                return Redirect::back()->with('successMessage', 'Information successfully created!');
            }
        } else {
            // In case the post creation failed
            return back()->with('failedMessage', 'Error occurred while creating the post')->withInput();
        }
    }

    public function postUpdate(PostRequest $request, $id){
        $request->validated();
        $updateSuccess = $this->postRepository->updatePost($id, $request->only('context'));
        if ($updateSuccess) {
            return Redirect::back()->with('successMessage', 'Information successfully updated!');
        } else {
            return back()->with('failedMessage', 'Error occurred while updating the post')->withInput();
        }
    }

    public function postDelete($id){
        $deleteSuccess = $this->postRepository->deletePost($id);
        if ($deleteSuccess) {
            return Redirect::back()->with('successMessage', 'Information successfully deleted!');
        } else {
            return back()->with('failedMessage', 'Error occurred while deleting the post');
        }
    }

    public function postInteract($id)
    {
        // dd($request->all());

        DB::beginTransaction();
        try {

            // check if dah ada record
            $checkInteraction = Interaction::where('post_id',$id)->where('user_id',Auth::id())->first();

            if($checkInteraction == null) {
                $interaction = Interaction::create([
                    'post_id' => $id,
                    'user_id' => Auth::id(),
                    'created_by' => Auth::id(),
                    'created_at' => new DateTime(),
                    'updated_by' => Auth::id(),
                    'updated_at' => new DateTime(),
                ]);
            } else {
                $checkInteraction->delete();
            }

            DB::commit();

            return Redirect::back()->with('successMessage', 'Information succesfully bookmarked!');

        } catch (\Exception $e) {
            //if ada error
            // dd($e);
            DB::rollback();

            Log::info(Route::currentRouteAction());
            Log::error($e);

            return back()->with('failedMessage', 'ERROR')->withInput();
        }
    }
}
