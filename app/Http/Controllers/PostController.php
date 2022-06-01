<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TimeRequest;

class PostController extends Controller
{
    public function add()
    {
        $time = new Carbon(Carbon::now());
        $today = $time->format('Y-m-d');
        return view('post.add', compact("time", "today"));
    }

    public function store(TimeRequest $request)
    {
        $input = $request->only('customer', 'location', 'product', 'start', 'end', 'action', 'transportation', 'fee', 'content',  'comment');

        $post = new Post();
        $post->customer = $input["customer"];
        $post->location = $input["location"];
        $post->product = implode(",", $input["product"]);
        $post->start = $_POST['date1']." ".$input["start"];
        $post->end = $_POST['date2']. " ".$input["end"];
        $post->action = implode("," , $_POST["action"]);
        $post->transportation = implode("," , $_POST["transportation"]);
        $post->fee = $input["fee"];
        $post->content = $input["content"];
        $post->comment = $input["comment"];
        $post->save();

        return redirect('/')->with('success', '日報を登録しました');
    }

    public function page(Request $request) {
        $day = $request->input('target');
        // $date = Post::whereDate('created_at', $day)->get();
        $date = Post::get();
        return view('post.page', compact("day", 'date'));
    }

}
