<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\ExtendSort;
use App\Goods;
use App\GoodsAttr;
use App\Stock;
use App\Sort;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    /**
     * 商品列表
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
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            // 上传图片
            if ($request->hasFile('photo') && $request->photo->isValid()) {
                $extension = $request->photo->extension();
                $file_name = date("YmdHis") . '.' . $extension;
                $request['image'] = $request->photo->storeAs('images', $file_name);
            }
            $res = Goods::create($request->all());
            if ($res) {
                $goods_id = $res->id;
                // 添加商品扩展分类
                $extend_sort_id = $request->extend_sort_id;
                if (count($extend_sort_id) > 1) {
                    ExtendSort::insertExtendSort($goods_id, $extend_sort_id);
                }
                $attr_value = $request->attr_value;
                // 添加商品属性
                GoodsAttr::insertGoodsAttr($goods_id, $attr_value);
                return redirect('goods/lst');
            }
        }
        $brand_data = Brand::all();
        $sort_data = Sort::getTreeData();
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
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $res = Goods::find($id);
        if ($request->isMethod('post')) {
            // 上传图片
            if ($request->hasFile('photo') && $request->photo->isValid()) {
                // 先删除原图片
                Storage::delete($res->logo);
                $extension = $request->photo->extension();
                $file_name = date("YmdHis") . '.' . $extension;
                $request['image'] = $request->photo->storeAs('images', $file_name);
            }
            if ($res->update($request->all())) {
                // 修改商品扩展分类
                $extend_sort_id = $request->extend_sort_id;
                if (count($extend_sort_id) > 1) {
                    // 先删除原扩展分类数据
                    ExtendSort::where('goods_id', $id)->delete();
                    // 再添加新扩展分类数据
                    ExtendSort::insertExtendSort($id, $extend_sort_id);
                }
                // 修改商品属性
                GoodsAttr::modifyGoodsAttr($request->all());
                return redirect('goods/lst');
            }
        }
        $brand_data = Brand::all();
        $sort_data = Sort::getTreeData();
        $extend_sort_data = ExtendSort::where('goods_id', $id)->pluck('sort_id')->toArray();
        $type_data = Type::all();
        // 取出当前类型下所有的属性
        $attr_data = DB::table('attributes as a')
            ->select('a.id as attr_id', 'a.attr_name', 'a.attr_type', 'a.option_values', 'b.attr_value', 'b.id')
            ->leftJoin('goods_attrs as b', ['a.id' => 'b.attr_id', 'b.goods_id' => DB::raw($id)])
            ->where('type_id', $res->type_id)
            ->get();
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
    public function delGoodsAttr(Request $request)
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
     */
    public function del(Request $request)
    {
        $id = $request->id;
        $res = Goods::find($id);
        // 删除扩展分类
        ExtendSort::delExtendSort($id);
        // 删除商品库存量
        Stock::delStock($id);
        // 删除商品属性
        GoodsAttr::delGoodsAttr($id);
        if (Goods::destroy($id)) {
            // 删除图片
            Storage::delete($res->image);
            return redirect('goods/lst');
        }
    }

    /**
     * 商品库存量
     * @param Request $request
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
            return redirect('goods/lst');
        }

        // 根据商品id取出这件商品所有可选属性
        $attr_data = DB::table('goods_attrs as a')
            ->select('a.id', 'a.attr_value', 'b.attr_name', 'b.attr_type')
            ->leftJoin('attributes as b', 'a.attr_id', 'b.id')
            ->where(['a.goods_id' => $id, 'b.attr_type' => 2])
            ->get();
        // 处理二维数组转成三维数组，将属性相同的放在一起
        $goods_attr_data = [];
        foreach ($attr_data as $v) {
            $goods_attr_data[$v->attr_name][] = $v;
        }
        return view('goods.stock',
            ['goods_attr_data' => $goods_attr_data,
                'goods_stock' => $goods_stock
            ]
        );
    }
}
