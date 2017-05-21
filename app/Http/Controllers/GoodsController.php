<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Goods;
use App\Sort;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    /**
     * 商品列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lst()
    {
        $goods_data = Goods::paginate(10);
        foreach ($goods_data as $v) {
            $sort_name = Sort::where('id', $v->sort_id)->value('sort_name');
            $brand_name = Brand::where('id', $v->brand_id)->value('brand_name');
            $v->sort_name = $sort_name;
            $v->brand_name = $brand_name;
        }

        return view('goods.lst', ['goods_data' => $goods_data]);
    }

    /**
     * 添加商品
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->has('name')) {
            $goods = new Goods;
            $goods->name = $request->name;
            $goods->brand_id = $request->brand_id;
            $goods->price = $request->price;
            if ($request->hasFile('photo')) {
                $path = $request->photo->store('photo');
                $goods->logo = $path;
            }
            $goods->describe = $request->describe;
            $goods->describe = $request->describe;
            $goods->is_putaway = $request->is_putaway;
            $goods->sort_id = $request->sort_id;
            $goods->describe = $request->describe;
            if ($goods->save()) {
                return redirect('goods');
            }
        }
        $brand_data = Brand::all();
        $sort_data = Sort::getData();
        return view('goods.add',
            ['brand_data' => $brand_data, 'sort_data' => $sort_data]
        );
    }

    /**
     * 修改商品
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $update = Goods::find($id);
        if ($request->has('name')) {
            $update->name = $request->name;
            $update->brand_id = $request->brand_id;
            $update->price = $request->price;
            if ($request->hasFile('photo')) {
                $path = $request->photo->store('photo');
                $update->logo = $path;
            }
            $update->describe = $request->describe;
            $update->describe = $request->describe;
            $update->is_putaway = $request->is_putaway;
            $update->sort_id = $request->sort_id;
            $update->describe = $request->describe;
            if ($update->save()) {
                return redirect('goods');
            }
        }
        $brand_data = Brand::all();
        $sort_data = Sort::getData();
        return view('goods.edit',
            ['update' => $update, 'brand_data' => $brand_data, 'sort_data' => $sort_data]
        );
    }

    /**
     * 删除商品
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        if (Goods::destroy($id)) {
            return redirect('goods');
        }
    }
}
