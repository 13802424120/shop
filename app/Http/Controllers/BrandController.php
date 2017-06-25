<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * 品牌列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lst()
    {
        $brand_data = Brand::paginate(10);
        return view('brand/lst', ['brand_data' => $brand_data]);
    }

    /**
     * 添加品牌
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            // 上传图片
            $request['logo'] = $request->hasFile('photo') ? $request->photo->store('photo') : null;
            $res = Brand::create($request->all());
            if ($res) {
                return redirect('brand/lst');
            }
        }
        return view('brand/add');
    }

    /**
     * 修改品牌
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $res = Brand::find($id);
        if ($request->isMethod('post')) {
            // 上传图片
            $request['logo'] = $request->hasFile('photo') ? $request->photo->store('photo') : null;
            if ($res->update($request->all())) {
                return redirect('brand/lst');
            }
        }
        return view('brand/edit', ['res' => $res]);
    }

    /**
     * 删除品牌
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function del(Request $request)
    {
        $id = $request->id;
        if (Brand::destroy($id)) {
            return redirect('brand/lst');
        }
    }
}
