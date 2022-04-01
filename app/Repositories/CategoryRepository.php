<?php

namespace App\Repositories;

use App\Models\Category;
use App\Scopes\OrderScope;
use App\Traits\Models\UploadFileTrait;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
  use UploadFileTrait;

  public function getAllCategories($except = null)
  {
    return  Category::withTranslation()
      ->where('id', '!=', $except)
      ->withCount('children')
      ->with(['children', 'parent'])
      ->isActive(true)
      ->latest()
      ->get();
  }

  public function getHomeCategories()
  {
    return  Category::withTranslation()
      ->withCount('children')
      ->with(['children', 'parent'])
      ->showOnHomePage()
      ->isActive(true)
      ->latest()
      // ->limit(20)
      ->get();
  }

  public function getMainCategories()
  {
    return  Category::withTranslation()
      ->withCount('children')
      ->with(['children', 'parent'])
      ->WhereParent()
      ->isActive(true)
      ->latest()
      // ->limit(20)
      ->get();
  }

  public function getFilteredCategories($request)
  {
    return  Category::withoutGlobalScope(new OrderScope)->withTranslation()
      ->withCount('children')
      ->with(['children', 'parent'])
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate();
  }

  public function getCategoryById($categoryId)
  {
    return Category::findOrFail($categoryId);
  }


  public function createCategory($request)
  {

    $request_data = $request->except(['parameters']);

    $request_data['customer_id'] = empty($request_data['customer_id']) ? null : $request_data['customer_id'];

    if ($request->image) {

      $request_data['image'] = $this->uploadImages($request->image, 'categories/', '', '');
    } //end of if

    foreach (config('translatable.locales') as $locale) {
      $request_data[$locale]['slug'] = make_slug($request_data[$locale]['name']);
    }

    $category = Category::create($request_data);

    return   $category;
  }

  public function updateCategory($request, $category)
  {

    $request_data = $request->except(['parameters',]);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'categories/', $category->image);
    } //end of if

    foreach (config('translatable.locales') as $locale) {
      $request_data[$locale]['slug'] = make_slug($request_data[$locale]['name']);
    }
    $category->update($request_data);

    return true;
  }

  public function deleteCategory($category)
  {

    if (!$category) {
      return redirect()->back();
    }

    $this->removeImage($category->image, 'categories');
    $category->delete();
  }
}
