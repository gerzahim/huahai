<!-- jQuery 2.1.3 --><script src="{{ asset('assets/js/jquery-2.1.3.min.js') }}"></script><!-- Bootstrap 3.3.2 JS --><script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script><!-- validator.js javascript--><script src="{{ asset('assets/js/validator.min.js') }}"></script><script>    $(function(){        showListItems();        $('form').validator().on('submit', function (e) {            if (e.isDefaultPrevented()) {                $(this).removeClass('spinner');            } else {                $(this).addClass('spinner');            }        });    });    var i = 0;    function showListItems() {        $("ul li:hidden:first").fadeIn("slow", function() {            i=i+1;            var result = setTimeout(showListItems, 500);            if(i==8){                $('#box-footer').removeClass('hide');            }        });    }</script>