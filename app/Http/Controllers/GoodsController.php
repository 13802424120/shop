<?php

namespace App\Http\Controllers;

use App\Goods;
use App\Sort;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    /**
     * 商品列表
     */
    public function lst()
    {
        $goods_data = Goods::paginate(10);
        foreach ($goods_data as &$v) {
            $sort_name = Sort::where('id', $v->sort)->value('sort_name');
            $v->sort_name = $sort_name;
        }

        return view('goods.lst', ['goods_data' => $goods_data]);
    }

    /**
     * 添加商品
     * @param Request $request
     */
    public function add(Request $request)
    {
        if ($request->has('name')) {
            $goods = new Goods;
            $goods->name = $request->name;
            $goods->price = $request->price;
            if ($request->hasFile('photo')) {
                $path = $request->photo->store('photo');
                $goods->logo = $path;
            }
            $goods->describe = $request->describe;
            $goods->describe = $request->describe;
            $goods->is_putaway = $request->is_putaway;
            $goods->sort = $request->sort;
            $goods->describe = $request->describe;
            if ($goods->save()) {
                return redirect('goods/lst');
            }
        }
        $sort_data = Sort::getData();
        return view('goods.add', ['sort_data' => $sort_data]);
    }

    /**
     * 修改商品
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $update = Goods::find($id);
        if ($request->has('name')) {
            $update->name = $request->name;
            $update->price = $request->price;
            if ($request->hasFile('photo')) {
                $path = $request->photo->store('photo');
                $update->logo = $path;
            }
            $update->describe = $request->describe;
            $update->describe = $request->describe;
            $update->is_putaway = $request->is_putaway;
            $update->sort = $request->sort;
            $update->describe = $request->describe;
            if ($update->save()) {
                return redirect('goods/lst');
            }
        }
        $sort_data = Sort::getData();
        return view('goods.edit', ['update' => $update, 'sort_data' => $sort_data]);
    }

    /**
     * 删除商品
     * @param Request $request
     */
    public function delete(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->id;
            if (Goods::destroy($id)) {
                return redirect('goods/lst');
            }
        }
    }
}
