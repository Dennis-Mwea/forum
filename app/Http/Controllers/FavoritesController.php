<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    /**
     * FavoritesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Favorite a reply
     *
     * @param Reply $reply
     * @return bool
     */
    public function store(Reply $reply)
    {
        $reply->favorite(auth()->id());

        return back();
    }
}
