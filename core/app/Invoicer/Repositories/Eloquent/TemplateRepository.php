<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\TemplateInterface;

class TemplateRepository extends BaseRepository implements TemplateInterface{

    public function model() {
        return 'Inventory\Models\Template';
    }

    public function getTemplate($name){
    	$template = $this->model();
    	return $template::where('name', $name)->first();
    }
}