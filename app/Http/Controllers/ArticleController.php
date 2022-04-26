<?php

namespace App\Http\Controllers;

use App\Models\ArticleInfo;
use App\Models\MessageInfo;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
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
        $art->userNo = $request->userNo;
        if (isset($data['image'])) {
            $art->imgUrl = 'Image/' . $data['image'];
        } else {
            $art->imgUrl = null;
        }
        $query = $art->save();

        if ($query) {
            return redirect('/')->with('addSuccess', 'article successfully add!');
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
        // 顯示特定文章頁面
        $data = [
            'ArtLists' => ArticleInfo::where('articleNo', $id)
                ->leftJoin('userData', 'article.userNo', 'userData.userNo')->first(),
            'MesLists' => MessageInfo::where('articleNo', $id)
                ->leftJoin('userData', 'message.userNo', 'userData.userNo')->get(),
            'LoggedUserInfo' => [],
        ];

        if (session()->has('LoggedUser')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            $data['LoggedUserInfo'] = $user;
        }
        return view('article.show', $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        // 顯示特定文章修改頁面
        if (session()->has('LoggedUser')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            $artvalue = ArticleInfo::findOrFail($id);

            $data = [
                'LoggedUserInfo' => $user,
                'artvalue' => $artvalue,
            ];
            return view('article.update', $data);
        }

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
        //檢核修改內容
        $validatedData = $request->validate([
            'articleTitle' => 'required|min:5|max:50',
            'articleContent' => 'required|min:5',
        ]);

        $results = ArticleInfo::where('articleNo', $id);
        $results->update($validatedData);
        return redirect('/')->with('modifySuccess', 'article successfully modify!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //刪除文章＋刪除留言(關聯Article＆message)
        $artresult = ArticleInfo::findOrFail($id);
        $artresult->delete();

        return redirect('/')->with('delSuccess', 'article/message successfully deleted!');
    }
}
