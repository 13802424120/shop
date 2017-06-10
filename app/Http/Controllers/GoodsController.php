<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Brand;
use App\Goods;
use App\GoodsAttribute;
use App\GoodsStock;
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
        if ($request->isMethod('post')) {
            $goods = new Goods;
            $goods->name = $request->name;
            $goods->brand_id = $request->brand_id;
            $goods->price = $request->price;
            if ($request->hasFile('photo')) {
                $path = $request->photo->store('photo');
                $goods->logo = $path;
            }
            $goods->describe = $request->describe;
            $goods->is_putaway = $request->is_putaway;
            $goods->type_id = $request->type_id;
            $goods->sort_id = $request->sort_id;
            $goods->describe = $request->describe;
            if ($goods->save()) {
                $goods_id = $goods->id;
                $attr_value = $request->attribute_value;
                // 添加商品属性
                GoodsAttribute::insertGoodsAttribute($goods_id, $attr_value);
                return redirect('goods');
            }
        }
        $brand_data = Brand::all();
        $sort_data = Sort::getData();
        $type_data = Type::all();
        return view('goods.add',
            ['brand_data' => $brand_data, 'sort_data' => $sort_data, 'type_data' => $type_data]
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
        if ($request->isMethod('post')) {
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
                // 修改商品属性
                GoodsAttribute::modifyGoodsAttribute($request->all());
                return redirect('goods');
            }
        }
        $brand_data = Brand::all();
        $sort_data = Sort::getData();
        $type_data = Type::all();
        // 取出当前类型下所有的属性
        $attribute_data = DB::select('SELECT `a`.`id` attribute_id, `a`.`attribute_name`, `a`.`attribute_type`, `a`.`option_values`, `b`.`attribute_value`, `b`.`id` FROM `attributes` AS `a` LEFT JOIN `goods_attributes` AS `b` ON (`a`.`id` = `b`.`attribute_id` AND `b`.`goods_id` = ?) WHERE `type_id` = ? ORDER BY b.attribute_id ASC', [$id, $update->type_id]);
        return view('goods.edit',
            ['update' => $update,
                'brand_data' => $brand_data,
                'sort_data' => $sort_data,
                'type_data' => $type_data,
                'attribute_data' => $attribute_data
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
        GoodsAttribute::destroy($goods_attr_id);
        // 删除相关库存量数据
        GoodsStock::where('goods_id', $goods_id)->whereRaw('FIND_IN_SET('.$goods_attr_id.', goods_attribute_id)')->delete();
    }

    /**
     * 删除商品
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        // 删除商品库存量
        GoodsStock::where('goods_id', $id)->delete();
        // 删除商品属性
        GoodsAttribute::deleteGoodsAttribute($id);
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
        $goods_stock = GoodsStock::where('goods_id', $id)->get()->toArray();
        // 添加库存数据
        if ($request->isMethod('post')) {
            // 先删除原库存
            GoodsStock::where('goods_id', $id)->delete();
            // 再添加新库存
            GoodsStock::addGoodsStock($request->all());
            return redirect('goods');
        }

        // 根据商品id取出这件商品所有可选属性
        $attribute_data = DB::table('goods_attributes as a')
            ->select('a.id', 'a.attribute_value', 'b.attribute_name', 'b.attribute_type')
            ->leftJoin('attributes as b', 'a.attribute_id', 'b.id')
            ->where(['a.goods_id' => $id, 'b.attribute_type' => 2])
            ->get();
        // 处理二维数组转成三维数组，将属性相同的放在一起
        $goods_attr_data = [];
        foreach ($attribute_data as $v) {
            $goods_attr_data[$v->attribute_name][] = $v;
        }
        return view('goods.stock',
            ['goods_attr_data' => $goods_attr_data,
                'goods_stock' => $goods_stock
            ]
        );
    }
}
