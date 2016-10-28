<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Comment;
use App\Mailers\AppMailer;
use Illuminate\Support\Facades\Auth;
use App\Ticket;


class CommentsController extends Controller
{
    //

    public function postComment(Request $request, AppMailer $mailer){
        $this->validate($request, ['comment' => 'required']);

        $comment = Comment::create([
            'ticket_id' => $request->input('ticket_id'),
            'user_id' => Auth::user()->id,
            'comment' => $request->input('comment'),
            ]);
        if($comment->ticket->user-> !== Auth::user()->id){
            $mailer->sendTicketComments($comment->ticket->user, Auth::user(), $comment->ticket, $comment)
        }
        return redirect()->back()->with("status", "Your commenthas been submitted")
    }
}
