<?php namespace Inventory\Providers;

use Illuminate\Support\ServiceProvider;

class InvoicerServiceProvider extends ServiceProvider {

    protected $repositories = [
                            'Client', 'Vendor', 'User', 'Profile', 'Setting', 'InvoiceSetting', 'NumberSetting', 'TaxSetting',
                            'PaymentMethod', 'Currency', 'Courier', 'Template', 'Product', 'Expense','Estimate', 'EstimateItem',
                            'Invoice', 'InvoiceItem','Payment', 'Translation','EstimateSetting','EmailSetting', 'Role',
                            'Permission','ProductCategory','ExpenseCategory','Subscription'
                           ];

    public function register(){
    	//Loops through all repositories and binds them with their Eloquent implementation
        array_walk($this->repositories, function($repository){
            $this->app->bind('Inventory\Invoicer\Repositories\Contracts\\'.$repository.'Interface',
                'Inventory\Invoicer\Repositories\Eloquent\\'.$repository.'Repository'
            );
        });
    }
}
