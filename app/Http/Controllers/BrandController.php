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
            $brand = new Brand();
            $brand->brand_name = $request->brand_name;
            if ($request->hasFile('photo')) {
                $path = $request->photo->store('photo');
                $brand->logo = $path;
            }
            if ($brand->save()) {
                return redirect('brand');
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
        $update = Brand::find($id);
        if ($request->isMethod('post')) {
            $update->brand_name = $request->brand_name;
            if ($request->hasFile('photo')) {
                $path = $request->photo->store('photo');
                $update->logo = $path;
            }
            if ($update->save()) {
                return redirect('brand');
            }
        }
        return view('brand/edit', ['update' => $update]);
    }

    /**
     * 删除品牌
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        if (Brand::destroy($id)) {
            return redirect('brand');
        }
    }
}
