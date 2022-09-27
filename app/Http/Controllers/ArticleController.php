<?php

namespace App\Http\Controllers;

use App\Models\ArticleInfo;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        // 設定預設值
        $limit = isset($request->limit) ? $request->limit : 10;

        $query = ArticleInfo::query();

        // 篩選欄位條件
        if (isset($request->filters)) {
            $filters = explode(',', $request->filters);
            foreach ($filters as $key => $filter) {
                list($criteria, $value) = explode(':', $filter);
                $query->where($criteria, 'like', "%$value%");
            }
        }

        //排列順序
        if (isset($request->sorts)) {
            $sorts = explode(',', $request->sorts);
            foreach ($sorts as $key => $sort) {
                list($criteria, $value) = explode(':', $sort);
                if ($value == 'asc' || $value == 'desc') {
                    $query->orderBy($criteria, $value);
                }
            }
        } else {
            $query->orderBy('articleNo', 'asc');
        }

        $articles = $query->paginate($limit);

        return response($articles, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 檢驗文章內容
        $request->validate([
            'articleTitle' => 'required|min:5|max:50',
            'articleTitle' => 'required|min:5',
        ]);

        //新增文章
        $article = ArticleInfo::create($request->all());

        if (Response::HTTP_CREATED == 201) {
            return response(Response::HTTP_CREATED . "Response:Success articleNo=$request->articleNo!!");
        }
        return $article['message'];
    }

    /**
     * Display the specified resource.
     *
     * @param ArticleInfo $article
     * @return \Illuminate\Http\Response
     */
    public function show(ArticleInfo $article)
    {
        //查詢特定文章
        return response($article, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ArticleInfo $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArticleInfo $article)
    {
        //修改文章
        $article->update($request->all());

        return response($article, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ArticleInfo $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticleInfo $article)
    {
        // 刪除文章
        $article->delete();

        // 刪除成功  狀態碼204
        if(Response::HTTP_NO_CONTENT==204){
            return response("Response:Success articleNo=$article->articleNo del!!");
        }
    }
}
