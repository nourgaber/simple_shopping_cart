<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CheckOutRequest;
use App\Repositories\CurrencyRepository;
use App\Repositories\OfferRepository;
use App\Repositories\ProductRepository;

class CartController extends Controller
{
    private $productRepository;
    private $offerRepository;
    private $currencyRepository;
    public function __construct(ProductRepository $productRepository, OfferRepository $offerRepository, CurrencyRepository $currencyRepository)
    {
        $this->productRepository = $productRepository;
        $this->offerRepository = $offerRepository;
        $this->currencyRepository = $currencyRepository;
    }

  
    public function checkout(CheckOutRequest $request){
        $requestedProductsIds = array_column($request->all()['products'],'id');
        $products = $this->productRepository->getProductsByIds($requestedProductsIds);
        $offers = $this->offerRepository->getOffersByProductsIds($requestedProductsIds);
        if(isset($request->all()['currency_id'])){
            $currency = $this->currencyRepository->getCurrencysByid($request->all()['currency_id']);
            $transtionFactor = $currency->transtion_factor;
        }else{
         $transtionFactor = 1;   
        }
        $usedOffers = array();
        $subTotal = 0;
        $totalBeforeTax = 0;
        foreach($request->all()['products'] as $product){
            $productDetails = $products->where('id', $product['id'])->first();
            $price = $productDetails->price * $transtionFactor;
            $offer = $productDetails->offer;
            if(!is_null($offer)){
                if(is_null($offer->main_product_id)){
                    $usedOffers[$offer->name]  = $price * $product['quantity'] * $offer->discount / 100;
                    $totalBeforeTax += $price * $product['quantity'] ;
                    $subTotal += $price * $product['quantity']  - $usedOffers[$offer->name];
                }else{
                   
                    if(in_array($offer->main_product_id, $requestedProductsIds)){
                        $mainProduct = array_filter($request->all()['products'] , function($product) use($offer){
                            return $product['id'] == $offer->main_product_id;
                         });
                        $numberOfDiscountProducts = intval($mainProduct[0]['quantity'] / $offer->main_product_quantity);
                        if($numberOfDiscountProducts >= $product['quantity']){
                            $usedOffers[$offer->name] = $price * $product['quantity'] * $offer->discount / 100;
                        }else{
                            $usedOffers[$offer->name] = $price * $numberOfDiscountProducts * $offer->discount / 100;
                        }
                        $totalBeforeTax += $price * $product['quantity'] ;
                        $subTotal += $price * $product['quantity']  - $usedOffers[$offer->name];
                    }
                }
            }else{
                $totalBeforeTax += $price * $product['quantity'] ;
                $subTotal += $price * $product['quantity'];
            }
        }
        $taxes = $totalBeforeTax * 14 / 100;
        $total = $subTotal + $taxes;
        return array('subTotal' => $totalBeforeTax  , 'Taxes' => $taxes , 'Discounts' => $usedOffers , 'Total' => $total);
    }


    }

