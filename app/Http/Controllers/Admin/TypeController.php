<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{
    /**
     * 类型列表
     */
    public function lst()
    {
        $type_data = Type::paginate(10);
        return view('type/lst', ['type_data' => $type_data]);
    }

    /**
     * 添加类型
     * @param Request $request
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $res = Type::create($request->all());
            if ($res) {
                return redirect('type/lst');
            }
        }
        return view('type.add');
    }

    /**
     * 修改类型
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $res = Type::find($id);
        if ($request->isMethod('post')) {
            if ($res->update($request->all())) {
                return redirect('type/lst');
            }
        }
        return view('type/edit', ['res' => $res]);
    }

    /**
     * 删除类型
     * @param Request $request
     */
    public function del(Request $request)
    {
        $id = $request->id;
        // 删除类型下的属性
        Attribute::delTypeAttribute($id);
        if (Type::destroy($id)) {
            return redirect('type/lst');
        }
    }
}
