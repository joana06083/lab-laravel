<?php

namespace App\Http\Controllers;

use App\Models\MessageInfo;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 檢驗留言內容
        $request->validate([
            'content' => 'required|min:5',
        ]);

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('Image'), $filename);
            $data['image'] = $filename;
        }

        // 檢驗完成寫入資料庫
        $mes = new MessageInfo;
        $mes->messageNo = date('YmdHis', time());
        $mes->messageContent = $request->content;
        $mes->userNo = $request->userNo;
        $mes->articleNo = $request->articleNo;
        if (isset($data['image'])) {
            $mes->imgUrl = 'Image/' . $data['image'];
        } else {
            $mes->imgUrl = null;
        }
        $query = $mes->save();

        if ($query) {
            return redirect('/art/' . $request->articleNo)->with('Success', 'Message successfully add!');
        } else {
            return back()->with('Fail', 'Message failfully add!');
        }
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
            $mesInfo = MessageInfo::where('messageNo', $id)->first();

            $data = [
                'LoggedUserInfo' => $user,
                'mesInfo' => $mesInfo,
            ];
            return view('message.update', $data);
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
            'messageContent' => 'required|min:5',
        ]);
        $results = MessageInfo::where('messageNo', $id);
        $results->update($validatedData);

        if ($results) {
            return redirect('/art/' . $request->articleNo)->with('Success', 'Message successfully modify!');
        } else {
            return back()->with('Fail', 'Message failfully modify!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //刪除留言

        $result = MessageInfo::findOrFail($id);
        $result->delete();

        if ($result) {
            return redirect('/art/' . $request->articleNo)->with('Success', 'Message successfully deleted!');
        } else {
            return back()->with('Fail', 'Message failfully deleted!');
        }
    }
}
