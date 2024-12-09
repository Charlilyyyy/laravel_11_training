<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;

class PostRepository
{
    public function createPost(array $data, $parentId = null){
        DB::beginTransaction();
        try {
            $post = Post::create([
                'content' => $data['context'],
                'parent_post_id' => $parentId ?? null,
                'user_id' => Auth::id(),
                'created_by' => Auth::id(),
                'created_at' => new DateTime(),
                'updated_by' => Auth::id(),
                'updated_at' => new DateTime(),
            ]);

            DB::commit();

            return $post;

        } catch (Exception) {
            DB::rollback();

            Log::info('Error in PostRepository@createPost');
            Log::error($e);

            return null;
        }
    }

    public function updatePost($id, array $data){
        DB::beginTransaction();
        try {
            $post = Post::where('id', $id)->update([
                'content' => $data['context'],
                'updated_by' => Auth::id(),
                'updated_at' => new DateTime(),
            ]);
            DB::commit();
            return $post > 0; // Return true if update was successful
        } catch (Exception) {
            DB::rollback();
            Log::info('Error in PostRepository@updatePost');
            Log::error($e);
            return false;
        }
    }

    public function deletePost($id){
        DB::beginTransaction();
        try {
            $post = Post::where('id', $id)->delete();
            DB::commit();
            return $post > 0; // Return true if delete was successful
        } catch (Exception) {
            DB::rollback();
            Log::info('Error in PostRepository@deletePost');
            Log::error($e);
            return false;
        }
    }
}
