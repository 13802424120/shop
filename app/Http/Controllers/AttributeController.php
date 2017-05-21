<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Type;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * 属性列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lst(Request $request)
    {
        $code = $request->code;
        $attribute_data = Attribute::where('type_id', $code)->get();
        $type_data = Type::find($code);
        return view('attribute.lst',
            ['attribute_data' => $attribute_data, 'type_data' => $type_data]);
    }

    /**
     * 添加属性
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        $code = $request->code;
        if ($request->has('attribute_name')) {
            $attribute = new Attribute();
            $attribute->attribute_name = $request->attribute_name;
            $attribute->attribute_type = $request->attribute_type;
            $attribute->option_values = $request->option_values;
            $attribute->type_id = $request->type_id;
            if ($attribute->save()) {
                return redirect('attribute?code=' . $code);
            }
        }
        $type_data = Type::find($code);
        return view('attribute.add', ['type_data' => $type_data]);
    }

    /**
     * 修改属性
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $code = $request->code;
        $update = Attribute::find($id);
        if ($request->has('attribute_name')) {
            $update->attribute_name = $request->attribute_name;
            $update->attribute_type = $request->attribute_type;
            $update->option_values = $request->option_values;
            $update->type_id = $request->type_id;
            if ($update->save()) {
                return redirect('attribute?code=' . $code);
            }
        }
        $type_data = Type::find($code);
        return view('attribute/edit', ['update' => $update, 'type_data' => $type_data]);
    }

    /**
     * 删除属性
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        $code = $request->code;
        if (Attribute::destroy($id)) {
            return redirect('attribute?code=' . $code);
        }
    }

}
