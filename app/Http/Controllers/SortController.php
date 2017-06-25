<?php

namespace App\Http\Controllers;

use App\Sort;
use Illuminate\Http\Request;

class SortController extends Controller
{
    /**
     * 分类列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lst()
    {
        $sort_data = Sort::getData();
        return view('sort.lst', ['sort_data' => $sort_data]);
    }

    /**
     * 添加分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request['parent_id'] = $request->has('parent_id') ? $request->parent_id : 0;
            $res = Sort::create($request->all());
            if ($res) {
                return redirect('sort/lst');
            };
        }

        $sort_data = Sort::getData();
        return view('sort.add', ['sort_data' => $sort_data]);
    }

    /**
     * 修改分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $update = Sort::find($id);
        if ($request->isMethod('post')) {
            // 顶级分类不允许选择上级分类
            if ($update->parent_id == 0 && $request->parent_id != 0) {
                return redirect('sort');
            }
            $update->parent_id = $request->parent_id;
            $update->sort_name = $request->sort_name;
            if ($update->save()) {
                return redirect('sort/lst');
            };
        }

        $sort_data = Sort::getData();
        return view('sort.edit', ['update' => $update, 'sort_data' => $sort_data]);
    }

    /**
     * 删除分类
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function del(Request $request)
    {
        $id = $request->id;
        $data = Sort::where('parent_id', $id)->get();
        // 父分类下有子分类不允许删除
        if (!$data->first()) {
            Sort::destroy($id);
        }
        return redirect('sort/lst');
    }
}