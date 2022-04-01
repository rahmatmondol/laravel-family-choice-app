<?php

namespace App\Repositories;

use App\Models\Detail;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\File;
use App\Traits\Models\UploadFileTrait;
use App\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
  use UploadFileTrait;

  // dashboard
  public function getProductRequestData()
  {

    return  request()->except([
      'products',
      'attachments',
      'images',
      'image',
      'hot_deal_status',
      'hot_deal_price',
      'expire_date_hot_deal',
      'attribute_id',
    ]);
  }

  public function getFilteredProducts($request)
  {
    return  Product::withTranslation()

      ->with(['category.translations', 'brand.translations', 'reviews', 'details', 'productImages', 'branches.translations'])

      ->whenSearch($request->search)

      ->whenCategory($request->category_id)

      ->whenBrand($request->brand_id)

      ->whenFromPrice()

      ->whenToPrice()

      ->isActive($request->status)

      ->isFeatured($request->featured)

      ->isHotDeal($request->hot_deal)

      ->isOffer($request->is_offer)

      ->isOnSale($request->on_sale)

      ->WhenCreatedAt($request->created_at)

      // ->latest()

      ->with('productImages')

      ->paginate($request->perPage ?? 20);
  }

  public function createProduct($request)
  {

    $request_data = $this->getProductRequestData();

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'products/', '');
    } // end of if

    $request_data['is_offer'] = $request->is_offer ?? 0;
    $request_data['featured'] = $request->featured ?? 0;
    $request_data['on_sale'] = $request->on_sale ?? 0;
    $request_data['hot_deal_status'] = $request->hot_deal_status ?? 0;
    $request_data['new_arrival'] = $request->new_arrival ?? 0;
    $request_data['discount'] = $request->discount ?? 0;

    foreach (config('translatable.locales') as $locale) {
      $request_data[$locale]['slug'] = make_slug($request_data[$locale]['name']);
    }

    $product = Product::create($request_data);

    if ($request->attachments) {
      $this->insertImages($request->attachments, $product->id);
    }

    return true;
  }

  public function updateProduct($request, $product)
  {

    $product = Product::find($product->id);
    $request_data = $this->getProductRequestData();

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'products/', $product->image);
    } //end of if

    if ($request->attachments) {
      $this->insertImages($request->attachments, $product->id);
    } // end of if

    $request_data['is_offer'] = $request->is_offer ?? 0;
    $request_data['featured'] = $request->featured ?? 0;
    $request_data['on_sale'] = $request->on_sale ?? 0;
    $request_data['hot_deal_status'] = $request->hot_deal_status ?? 0;
    $request_data['new_arrival'] = $request->new_arrival ?? 0;
    $request_data['discount'] = $request->discount ?? 0;

    foreach (config('translatable.locales') as $locale) {
      $request_data[$locale]['slug'] = make_slug($request_data[$locale]['name']);
    }

    $product->fill($request_data);

    $product->save();

    return true;
  }

  function insertImages($attachments, $product_id)
  {
    $attachments = $this->MultipleUploadImages($attachments, 'product_images/');

    foreach ($attachments as $file_name) {
      $create = ProductImage::create([
        'product_id' => $product_id,
        'image' => $file_name,
      ]);
    }
  }

  public function deleteOneAttachment($id)
  {

    $attachment = ProductImage::find($id);
    $this->removeImage($attachment->image, 'product_images');
    $attachment->delete();

    return true;
  }

  public function deleteProduct($product)
  {

    if (!$product) {
      return redirect()->back();
    }

    // delete main image
    if ($product->image != 'default.png') {
      $this->removeImage($product->image, 'products');
    } //end of if

    // delete product attachments
    if ($attachments = $product->productImages) {
      foreach ($attachments as $attachment) {
        $this->deleteOneAttachment($attachment->id);
      }
    }

    $product->delete();

    return true;
  }

  public function copyProduct($product)
  {

    $clone = $product->replicate();
    $clone->push();


    $newImageName = \rand(1, 1000000) . $product->image;

    File::copy(public_path('uploads/products/' . $product->image), public_path('uploads/products/' . $newImageName));

    $copy = $clone->update([

      'ar' => [
        'name' => $product->translate('ar')->name . ' نسخة اخري  ' . rand(1, 100000),
        'slug' => make_slug($product->translate('ar')->name . ' نسخة اخري  ' . rand(1, 100000)),
        'description'  => $product->description,
        'short_description' => $product->short_description,
        'instruction' => $product->instruction,
        'ingredients' => $product->ingredients,
      ],
      'en' => [
        'name' => $product->translate('en')->name . ' another copy' . rand(1, 100000),
        'slug' => make_slug($product->translate('en')->name . ' another copy' . rand(1, 100000)),
        'description'  => $product->description,
        'short_description' => $product->short_description,
        'instruction' => $product->instruction,
        'ingredients' => $product->ingredients,
      ],
      'image' => $newImageName,
      'status' => $product->status,
    ]);



    foreach ($product->productImages as $img) {

      $newImageName = \rand(1, 1000000) . $img->image;

      File::copy(public_path('uploads/product_images/' . $img->image), public_path('uploads/product_images/' . $newImageName));

      $create = ProductImage::create([
        'product_id' => $clone->id,
        'image' => $newImageName,
        // 'image' => $img->image,
      ]);
    }

    //start  fill Specifications
    if ($details = $product->details) {
      foreach ($details as $key => $value) {
        Detail::create([
          'product_id' => $clone->id,
          'specification_id' => $value->specification_id,
          'ar' => [
            'name' => $value->translate('ar')->name,
          ],
          'en' => [
            'name' => $value->translate('en')->name,
          ],
        ]);
      }
    } //end   fill Specifications

    return redirect()->back();
  } // end of duplicate

  // client

  public function getProductById($productId)
  {
    $product = Product::findOrFail($productId);


    $product->load([
      'productImages',

      'reviews' => function ($q) {
        return $q->Active()->get();
      },
      'translations',
      'details.specification'
    ]);
    return $product;
  }

  public function getRelatedProducts($productId)
  {
    $product = Product::findOrFail($productId);

    return Product::withTranslation(app()->getLocale())
      ->with(['category.translations', 'brand.translations', 'productImages', 'reviews', 'details'])
      ->where('id', '!=', $product->id)
      ->where('category_id', $product->category_id)->limit(request('limit') ?? 3)->paginate();
  }

  public function getNewArrivalProducts()
  {
    return Product::withTranslation()
      ->with(['category.translations', 'brand.translations', 'productImages', 'reviews', 'details'])
      ->isActive(true)
      ->isNewArrival(true)
      ->latest()
      ->limit(10)
      ->get();
  }

  public function getFeaturedProducts()
  {
    return Product::withTranslation()
      ->with(['category.translations', 'brand.translations', 'productImages', 'reviews', 'details'])
      ->isActive(true)->isFeatured(true)
      ->latest()
      ->limit(10)
      ->get();
  }

  public function getHotDealProducts()
  {
    return Product::withTranslation()
      ->with(['category.translations', 'brand.translations', 'productImages', 'reviews', 'details'])
      ->isActive(true)
      ->isHotDeal(true)
      ->latest()
      ->limit(10)
      ->get();
  }
}
