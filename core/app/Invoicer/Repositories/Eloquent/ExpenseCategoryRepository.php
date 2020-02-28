<?php namespace Inventory\Invoicer\Repositories\Eloquent;
use Inventory\Invoicer\Repositories\Contracts\ExpenseCategoryInterface;
class ExpenseCategoryRepository extends BaseRepository implements ExpenseCategoryInterface{
    public function model() {
        return 'Inventory\Models\ExpenseCategory';
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