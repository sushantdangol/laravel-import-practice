<?php

namespace App\Http\Controllers;

use App\Imports\ProductPriceListImport;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductType;
use App\Models\Unit;
use Illuminate\Http\Request;
use stdClass;

class ProductController extends Controller
{
    public function index()
    {
        // ProductPrice::truncate();
        $months = config('general.months');

        $query = ProductPrice::query();

        if(request()->month) {
            $query->whereMonth('created_at', request()->month);
        } else {
            $query->whereMonth('created_at', date('m'));
        }
        
        $productIds = $query->pluck('product_id');

        $products = Product::query()->whereIn('id', $productIds)->get();

        return view('products.index',compact('products', 'months'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);
        
        if($request->hasFile('file')) {
            $file = $request->file('file');

            $array = (new ProductPriceListImport)->toArray($file);
            $rows = $array[0] ?? [];
            try{
                foreach($rows as $row) {
                    
                    $arrayKeys = array_keys($row);
                    $matches  = preg_grep ('/^price_(\w+)/i', $arrayKeys);
                    
                    $productCode = $row['code'];
                    $productName = $row['product_name'];
                    $colourName = $row['colour_name'];
                    $taxCode = $row['tax_code'];
                    $productUnit = $row['unit_of_measure'];
                    $productType = $row['type'];
                    $productCost = $row['cost'];
                    
                    $unit = Unit::query()
                        ->where('name', $productUnit)
                        ->first();
    
                    $unit = $unit ?: new Unit();
                    $unit->name = $productUnit;
                    $unit->save();
                    
                    $productTypeModel = ProductType::query()
                        ->where('name', $productType)
                        ->first();

                    $productTypeModel = $productTypeModel ?: new ProductType();
                    $productTypeModel->name = $productType;
                    $productTypeModel->save();
    
                    $product = Product::query()
                                ->whereNotNull('code')
                                ->where('code', $productCode)
                                ->first();
    
                    $product = $product ?: new Product();
                    $product->code = $productCode;
                    $product->name = $productName;
                    $product->colour = $colourName;
                    $product->tax_code  = $taxCode;
                    $product->unit_id = $unit->id;
                    $product->product_type_id = $productTypeModel->id;
                    $product->cost = $productCost;
                    $product->save();
                    
                    $pricesNew = [];

                    $productPriceNewModel = ProductPrice::query()
                            ->whereMonth('product_id', $product->id)
                            ->whereMonth('created_at', date('m'))
                            ->first();

                    if(!$productPriceNewModel) {
                        foreach(array_values($matches) as $match) {
                            $productPriceModel = new stdClass;
                            $productPriceModel->key = $match;
                            $productPriceModel->value = $row[$match];
                            $pricesNew[] = $productPriceModel;
                        }
                    } else {
                        $pricesNew[] = $productPriceNewModel->prices;
                    }

                    $productPriceNewModel = $productPriceNewModel ?: new ProductPrice();
                    $productPriceNewModel->product_id = $product->id;
                    $productPriceNewModel->prices = json_encode($pricesNew);
                    $productPriceNewModel->save();    
                }

                return redirect()->route('products.index');

            } catch(\Exception $e) {
                dd($e);
            }
        }
    }
}
