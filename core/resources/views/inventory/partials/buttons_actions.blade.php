<h3 class="box-title pull-right">
    <div class="box-tools">
        <a href="{{ route('product_category.index') }}" class="btn btn-info btn-xs" style="margin-right: 10px;"><i class="fa fa-bars"></i> {{trans('application.categories')}}</a>&nbsp;

        <a href="{{ route('checkin') }}" class="btn btn-primary btn-xs"> <i class="fa fa-arrow-down"></i> Check-In Products</a> &nbsp;
        <a href="{{ route('checkout') }}" class="btn btn-primary btn-xs"> <i class="fa fa-arrow-up"></i> Check-Out Products</a>&nbsp;
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-xs"> <i class="fa fa-plus-circle"></i> Add Products</a>&nbsp;
        <a href="{{ route('transactions') }}" class="btn btn-primary btn-xs"> <i class="fa fa-plus-circle"></i> Transactions</a>&nbsp;


    </div>
</h3>
