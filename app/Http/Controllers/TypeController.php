<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * 类型列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lst()
    {
        $type_data = Type::paginate(10);
        return view('type/lst', ['type_data' => $type_data]);
    }

    /**
     * 添加类型
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->has('type_name')) {
            $type = new Type();
            $type->type_name = $request->type_name;
            if ($type->save()) {
                return redirect('type');
            }
        }
        return view('type.add');
    }

    /**
     * 修改类型
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $update = Type::find($id);
        if ($request->has('type_name')) {
            $update->type_name = $request->type_name;
            if ($update->save()) {
                return redirect('type');
            }
        }
        return view('type/edit', ['update' => $update]);
    }

    /**
     * 删除类型
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        // 删除类型下的属性
        Attribute::deleteTypeAttribute($id);
        if (Type::destroy($id)) {
            return redirect('type');
        }
    }
}
