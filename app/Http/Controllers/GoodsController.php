<?php

namespace App\Http\Controllers;

use App\Brand;
use App\ExtendSort;
use App\Goods;
use App\GoodsAttr;
use App\Stock;
use App\Sort;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    /**
     * 商品列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lst()
    {
        $goods_data = DB::table('goods as a')
            ->select('a.*', 'b.brand_name', 'c.sort_name', DB::raw('GROUP_CONCAT(e.sort_name) as extend_sort_name'))
            ->leftJoin('brands as b', 'a.brand_id', 'b.id')
            ->leftJoin('sorts as c', 'a.sort_id', 'c.id')
            ->leftJoin('extend_sorts as d', 'a.id', 'd.goods_id')
            ->leftJoin('sorts as e', 'd.sort_id', 'e.id')
            ->groupBy('a.id')
            ->paginate(10);

        return view('goods.lst', ['goods_data' => $goods_data]);
    }

    /**
     * 添加商品
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            // 上传图片
            if ($request->hasFile('photo')) {
                $path = $request->photo->store('photo');
                $request['image'] = $path;
            }
            $res = Goods::create($request->all());
            if ($res) {
                $goods_id = $res->id;
                // 添加商品扩展分类
                if ($request->has('extend_sort_id')) {
                    $extend_sort_id = $request->extend_sort_id;
                    ExtendSort::insertExtendSort($goods_id, $extend_sort_id);
                }
                $attr_value = $request->attribute_value;
                // 添加商品属性
                GoodsAttr::insertGoodsAttr($goods_id, $attr_value);
                return redirect('goods');
            }
        }
        $brand_data = Brand::all();
        $sort_data = Sort::getData();
        $type_data = Type::all();
        return view('goods.add',
            ['brand_data' => $brand_data,
                'sort_data' => $sort_data,
                'type_data' => $type_data
            ]
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
        $res = Goods::find($id);
        if ($request->isMethod('post')) {
            // 上传图片
            if ($request->hasFile('photo')) {
                $path = $request->photo->store('photo');
                $request['image'] = $path;
            }
            if ($res->update($request->all())) {
                // 修改商品扩展分类
                if ($request->has('extend_sort_id')) {
                    // 先删除原扩展分类数据
                    ExtendSort::where('goods_id', $id)->delete();
                    $extend_sort_id = $request->extend_sort_id;
                    ExtendSort::insertExtendSort($id, $extend_sort_id);
                }
                // 修改商品属性
                GoodsAttr::modifyGoodsAttr($request->all());
                return redirect('goods');
            }
        }
        $brand_data = Brand::all();
        $sort_data = Sort::getData();
        $extend_sort_data = ExtendSort::where('goods_id', $id)->pluck('sort_id')->toArray();
        $type_data = Type::all();
        // 取出当前类型下所有的属性
        $attr_data = DB::select('SELECT `a`.`id` attrs_id, `a`.`attr_name`, `a`.`attr_type`, `a`.`option_values`, `b`.`attr_value`, `b`.`id` FROM `attributes` AS `a` LEFT JOIN `goods_attrs` AS `b` ON (`a`.`id` = `b`.`attr_id` AND `b`.`goods_id` = ?) WHERE `type_id` = ? ORDER BY b.attr_id ASC', [$id, $res->type_id]);
        return view('goods.edit',
            ['res' => $res,
                'brand_data' => $brand_data,
                'sort_data' => $sort_data,
                'extend_sort_data' => $extend_sort_data,
                'type_data' => $type_data,
                'attr_data' => $attr_data
            ]
        );
    }

    /**
     * 删除商品属性
     * @param Request $request
     */
    public function deleteGoodsAttr(Request $request)
    {
        $goods_attr_id = $request->goods_attr_id;
        $goods_id = $request->goods_id;
        GoodsAttr::destroy($goods_attr_id);
        // 删除相关库存量数据
        Stock::where('goods_id', $goods_id)->whereRaw('FIND_IN_SET(' . $goods_attr_id . ', goods_attr_id)')->delete();
    }

    /**
     * 删除商品
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        // 删除扩展分类
        ExtendSort::deleteExtendSort($id);
        // 删除商品库存量
        Stock::deleteStock($id);
        // 删除商品属性
        GoodsAttr::deleteGoodsAttr($id);
        if (Goods::destroy($id)) {
            return redirect('goods');
        }
    }

    /**
     * 商品库存量
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stock(Request $request)
    {
        // 接收商品id
        $id = $request->id;
        // 先取出这件商品已经设置过的库存量
        $goods_stock = Stock::where('goods_id', $id)->get()->toArray();
        // 添加库存数据
        if ($request->isMethod('post')) {
            // 先删除原库存
            Stock::where('goods_id', $id)->delete();
            // 再添加新库存
            Stock::addStock($request->all());
            return redirect('goods');
        }

        // 根据商品id取出这件商品所有可选属性
        $attribute_data = DB::table('goods_attrs as a')
            ->select('a.id', 'a.attr_value', 'b.attr_name', 'b.attr_type')
            ->leftJoin('attributes as b', 'a.attr_id', 'b.id')
            ->where(['a.goods_id' => $id, 'b.attr_type' => 2])
            ->get();
        // 处理二维数组转成三维数组，将属性相同的放在一起
        $goods_attr_data = [];
        foreach ($attribute_data as $v) {
            $goods_attr_data[$v->attr_name][] = $v;
        }
        return view('goods.stock',
            ['goods_attr_data' => $goods_attr_data,
                'goods_stock' => $goods_stock
            ]
        );
    }
}
