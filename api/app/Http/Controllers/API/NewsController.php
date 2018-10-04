<?php

namespace App\Http\Controllers\API;

use App\News;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    /**
     * Получаем все новости (пагинация).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::paginate();
        return response()->json(['news' => $news]);
    }

    /**
     * Сохраняем новость.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $user = auth()->user();

        $newsData = $request->only(['title', 'body']);

        $news = new News;

        $news->fill($newsData);
        $news->user_id = $user->id;

        $news->save();

        return response()->json(['news' => $news]);
    }

    /**
     * Получаем новость (по id).
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return response()->json(['news' => $news]);
    }

    /**
     * Получаем комментарии к новости.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function getComments(News $news)
    {
        $comments = $news->comments;
        return response()->json(['comments' => $comments]);
    }

     /**
     * Сохраняем комментарий к новости.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function storeComment(Request $request, News $news)
    {
        $validated = $request->validate([
            'body' => 'required',
        ]);

        $user = auth()->user();

        $commentData = $request->only(['body']);

        $comment = new Comment($commentData);

        $comment->news_id = $news->id;
        $comment->user_id = $user->id;

        $comment->save();

        return response()->json(['comment' => $comment]);
    }

    /**
     * Обновляем новость.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $this->authorize('update', $news);

        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $newsData = $request->only(['title', 'body']);

        $news->update($newsData);

        return response()->json(['news' => $news]);
    }
}
