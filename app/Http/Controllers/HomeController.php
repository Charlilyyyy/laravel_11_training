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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($type = 'home')
    {
        $postPlural = Post::select('id','content','parent_post_id','user_id','created_at','updated_at');

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

        $postPlural = $postPlural->orderByDesc('created_at')->paginate(10);

        $data = [
            'postPlural' => $postPlural,
            'type' => $type,
        ];

        return view('home', $data);
    }

    public function postDetail($id)
    {
        $postSingular = Post::find($id);

        $childPostPlural = Post::where('parent_post_id',$id)->paginate(10);

        $data = [
            'postSingular' => $postSingular,
            'childPostPlural' => $childPostPlural,
        ];

        return view('details', $data);
    }

    public function postCreate(Request $request, $id = null)
    {
        // dd($request->all());
        $request->validate([
            'context' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();
        try {

            $post = Post::create([
                'content' => $request->context,
                'parent_post_id' => $id ?? null,
                'user_id' => Auth::id(),
                'created_by' => Auth::id(),
                'created_at' => new DateTime(),
                'updated_by' => Auth::id(),
                'updated_at' => new DateTime(),
            ]);

            DB::commit();

            if($id != null) {
                return Redirect::route('postDetail',[$id])->with('successMessage', 'Information succesfully created!');
            } else {
                return Redirect::back()->with('successMessage', 'Information succesfully created!');
            }


        } catch (\Exception $e) {
            //if ada error
            // dd($e);
            DB::rollback();

            Log::info(Route::currentRouteAction());
            Log::error($e);

            return back()->with('failedMessage', 'ERROR')->withInput();
        }
    }

    public function postUpdate(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'context' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();
        try {

            $post = Post::where('id',$id)->update([
                'content' => $request->context,
                'updated_by' => Auth::id(),
                'updated_at' => new DateTime(),
            ]);

            DB::commit();

            return Redirect::back()->with('successMessage', 'Information succesfully updated!');

        } catch (\Exception $e) {
            //if ada error
            // dd($e);
            DB::rollback();

            Log::info(Route::currentRouteAction());
            Log::error($e);

            return back()->with('failedMessage', 'ERROR')->withInput();
        }
    }

    public function postDelete($id)
    {
        // dd($id);
        // dd($request->all());

        DB::beginTransaction();
        try {

            $post = Post::where('id',$id)->delete();

            DB::commit();

            return Redirect::back()->with('successMessage', 'Information succesfully deleted!');

        } catch (\Exception $e) {
            //if ada error
            // dd($e);
            DB::rollback();

            Log::info(Route::currentRouteAction());
            Log::error($e);

            return back()->with('failedMessage', 'ERROR')->withInput();
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

    //
}
