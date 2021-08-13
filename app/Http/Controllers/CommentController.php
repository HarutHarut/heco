<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Comment;
use App\Models\User;
use App\Models\UserComents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(Request $request)
    {
        $bike_id = $request->get('bike_id');
        $bike = Bike::find($bike_id);
        $comment = Comment::create([
            'body' => $request->get('comment'),
            'from_id' => Auth::id(),
            'commentable_type' => Comment::class,
            'commentable_id' => $bike_id
        ]);

        $userComment = UserComents::create([
            'user_id' => Auth::id(),
            'commentable_id' => $bike_id,
            'comment_id' => $comment->id
        ]);

        Mail::send('emails.new_comment', [
            'bike' => $bike,
        ], function ($m) use ($request, $bike) {
            $m->to($bike->user->email)->subject('New Comment');
        });

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reply_comment(Request $request)
    {
        $reply = $request->get('reply');
        $comment = Comment::findOrFail($request->get('comment_id'));
        $user = User::find($comment->from_id);
        $newComment = Comment::create([
            'body' => $reply,
            'from_id' => Auth::id(),
            'parent_id' => $comment->id,
            'commentable_type' => Comment::class,
            'commentable_id' => $comment->commentable_id
        ]);

        $userComment = UserComents::create([
            'user_id' => Auth::id(),
            'commentable_id' => $comment->commentable_id,
            'comment_id' => $comment->id,
        ]);

        $bike_id = $request->get('bike_id');
        $bike = Bike::find($bike_id);
        Mail::send('emails.reply_comment', [
            'bike' => $bike,
            'user' => $user,
        ], function ($m) use ($request, $bike, $user) {
            $m->to($user->email)->subject(__('Reply Comment'));
        });

//        return redirect()->route('reply.comment', compact('reply', 'comment_id'));
        return response()->json($reply);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteParentComment(Request $request)
    {
        Comment::destroy($request->get('id'));
        Comment::where('parent_id', $request->get('id'))->where('from_id', Auth::id())->delete();
        UserComents::where('comment_id', $request->get('id'))->delete();
        return response()->json('success');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteComment(Request $request)
    {
        $comment_id = $request->get('comment_id');
        $answer_id = $request->get('answer_id');
        $comment = Comment::destroy($answer_id);
        UserComents::where('comment_id', $comment_id)->where('user_id', Auth::id())->delete();
        return response()->json('success');
    }
}
