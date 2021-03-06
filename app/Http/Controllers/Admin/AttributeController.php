<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    /**
     * 属性列表
     */
    public function lst(Request $request)
    {
        $code = $request->code;
        $attr_data = Attribute::where('type_id', $code)->get();
        $type_data = Type::find($code);
        return view('attribute.lst',
            ['attr_data' => $attr_data, 'type_data' => $type_data]);
    }

    /**
     * 添加属性
     * @param Request $request
     */
    public function add(Request $request)
    {
        $code = $request->code;
        if ($request->isMethod('post')) {
            if ($request->has('option_values')) {
                $request['option_values'] = $request->option_values;
            }
            if (Attribute::create($request->all())) {
                return redirect('attribute/lst?code=' . $code);
            }
        }
        $type_data = Type::find($code);
        return view('attribute.add', ['type_data' => $type_data]);
    }

    /**
     * 修改属性
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $code = $request->code;
        $res = Attribute::find($id);
        if ($request->isMethod('post')) {
            if ($request->has('option_values')) {
                $request['option_values'] = $request->option_values;
            }
            if ($res->update($request->all())) {
                return redirect('attribute/lst?code=' . $code);
            }
        }
        $type_data = Type::find($code);
        return view('attribute/edit', ['res' => $res, 'type_data' => $type_data]);
    }

    /**
     * 删除属性
     * @param Request $request
     */
    public function del(Request $request)
    {
        $id = $request->id;
        $code = $request->code;
        if (Attribute::destroy($id)) {
            return redirect('attribute/lst?code=' . $code);
        }
    }

    /**
     * 根据类型ID获取属性值
     * @param Request $request
     * @return mixed
     */
    public function getAttr(Request $request)
    {
        $type_id = $request->type_id;
        $data = Attribute::where('type_id', $type_id)->get();
        return $data;
    }
}
