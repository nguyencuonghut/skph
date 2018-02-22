<?php
namespace App\Http\Controllers;

use App\Models\Description;
use Auth;
use Session;
use App\Models\Task;
use App\Models\Lead;
use App\Http\Requests;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Create a comment for tasks and leads
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function store(Request $request)
    {   
        $this->validate($request, [
            'description' => 'required'
        ]);

        $source = $request->type == "description" ? Description::find($request->id) : Lead::find($request->id);
        $comment = $source->addComment(['description' => $request->description, 'user_id' => auth()->user()->id]);
        event(new \App\Events\NewComment($comment));
        Session::flash('flash_message', 'Thêm bình luận thành công!'); //Snippet in Master.blade.php
        return redirect()->back();
    }

}
