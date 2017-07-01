<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            if ($request->hasFile('photo') && $request->photo->isValid()) {
                $extension = $request->photo->extension();
                $file_name = date("YmdHis") . '.' . $extension;
                $request['logo'] = $request->photo->storeAs('images', $file_name);
            }
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
            // 图片上传
            if ($request->hasFile('photo') && $request->photo->isValid()) {
                // 先删除原图片
                Storage::delete($res->logo);
                $extension = $request->photo->extension();
                $file_name = date("YmdHis") . '.' . $extension;
                $request['logo'] = $request->photo->storeAs('images', $file_name);
            }
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
        $res = Brand::find($id);
        if (Brand::destroy($id)) {
            // 删除图片
            Storage::delete($res->logo);
            return redirect('brand/lst');
        }
    }
}
