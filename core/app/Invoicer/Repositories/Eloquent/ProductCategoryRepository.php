<?php namespace Inventory\Invoicer\Repositories\Eloquent;
use Inventory\Invoicer\Repositories\Contracts\ProductCategoryInterface;
class ProductCategoryRepository extends BaseRepository implements ProductCategoryInterface{
    public function model() {
        return 'Inventory\Models\ProductCategory';
    }
    public function categorySelect(){
        $categories = $this->all();
        $categoryList = array();
        foreach($categories as $category)
        {
            $categoryList[$category->uuid] = $category->name;
        }
        return $categoryList;
    }
}