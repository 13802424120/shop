<?php

namespace App\Http\Controllers\Admin;

use App\Sort;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SortController extends Controller
{
    /**
     * 分类列表
     */
    public function lst()
    {
        $sort_data = Sort::getTreeData();
        return view('sort.lst', ['sort_data' => $sort_data]);
    }

    /**
     * 添加分类
     * @param Request $request
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request['parent_id'] = $request->has('parent_id') ? $request->parent_id : 0;
            $res = Sort::create($request->all());
            if ($res) {
                return redirect('sort/lst');
            }
        }

        $sort_data = Sort::getTreeData();
        return view('sort.add', ['sort_data' => $sort_data]);
    }

    /**
     * 修改分类
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $res = Sort::find($id);
        if ($request->isMethod('post')) {
            if ($res->update($request->all())) {
                return redirect('sort/lst');
            }
        }

        $sort_data = Sort::getTreeData();
        // 取出当前分类的子分类
        $child_data = Sort::getChildData($id);
        return view('sort.edit', ['res' => $res,
            'sort_data' => $sort_data,
            'child_data' => $child_data,
        ]);
    }

    /**
     * 删除分类
     * @param Request $request
     */
    public function del(Request $request)
    {
        $id = $request->id;
        // 先找出所有子分类id
        $child_data = Sort::getChildData($id);
        array_unshift($child_data, (int)$id);
        if (Sort::destroy($child_data)) {
            return redirect('sort/lst');
        }
    }
}