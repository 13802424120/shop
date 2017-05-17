<?php

namespace App\Http\Controllers;

use App\Goods;
use App\Sort;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    /**
     * 添加商品
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->has('goods_name')) {
//            $file = $request->file('photo');
//            dd($file);
            if ($request->hasFile('photo')) {
                $path = $request->photo->store('photo');
            }
            $goods = new Goods;
            $goods->goods_name = $request->goods_name;
            $goods->goods_price = $request->goods_price;
            $goods->goods_logo = $path;
            $goods->goods_describe = $request->goods_describe;
            $goods->goods_describe = $request->goods_describe;
            $goods->is_putaway = $request->is_putaway;
            $goods->goods_sort = $request->goods_sort;
            $goods->goods_describe = $request->goods_describe;
            if ($goods->save()) {
                return redirect('goods/lst');
            }
        }
        $sort_data = Sort::getData();
        return view('goods.add', ['sort_data' => $sort_data]);
    }

    /**
     * 商品列表
     */
    public function lst()
    {
        $goods_data = Goods::paginate(10);
        foreach ($goods_data as &$v) {
            $sort_name = Sort::where('id', $v->goods_sort)->value('sort_name');
            $v->sort_name = $sort_name;
        }

        return view('goods.lst', ['goods_data' => $goods_data]);
    }

    /**
     * 商品类型
     */
    public function type()
    {

    }

    /**
     * 商品规格
     */
    public function size()
    {

    }

    /**
     * 商品属性
     */
    public function property()
    {

    }
}
