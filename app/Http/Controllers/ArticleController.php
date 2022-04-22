<?php

namespace App\Http\Controllers;

use App\Models\ArticleInfo;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $arts = ArticleInfo::all();
        // // return $arts;

        // return view('index', $arts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //顯示新增頁面
        if (session()->has('LoggedUser')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            $data = [
                'LoggedUserInfo' => $user,
            ];
            return view('article.add', $data);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // 新增文章
    public function store(Request $request)
    {
        // 檢驗文章內容
        // return $request->input();
        $request->validate([
            'title' => 'required|min:5|max:50',
            'content' => 'required|min:5',
        ]);

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('Image'), $filename);
            $data['image'] = $filename;
        }

        // 檢驗完成寫入資料庫
        $art = new ArticleInfo;
        $art->articleNo = date('YmdHis', time());
        $art->articleTitle = $request->title;
        $art->articleContent = $request->content;
        $art->imgUrl = 'public/Image/' . $data['image'];
        $art->userNo = 'admin';
        $query = $art->save();

        if ($query) {
            return back()->with('Success', '文章新增成功！');
        } else {
            return back()->with('Fail', '文章新增失敗！');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return view('article.update');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
