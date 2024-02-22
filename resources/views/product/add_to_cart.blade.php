$('.btn-add-to-cart').click(function () {
    console.log($(this).data('id') + ' = ' + $('input[name=amount]').val());
    axios.post('{{ route('cart.store') }}', {
        product_id: $(this).data('id'),
        amount: $('input[name=amount]').val(),
    })
    .then(function () { // 請求成功時執行：
        swal('Success Add To Cart', '', 'success')
    }, function (error) { // 請求失敗時執行：

        console.log('error.response.status = ' + error.response.status);
        if (error.response.status === 422) {
            var html = '<div>';
            _.each(error.response.data.errors, function (errors) {
                _.each(errors, function (error) {
                    html += error + '<br>';
                })
            });
            html += '</div>';
            swal({content: $(html)[0], icon: 'error'});
        } else if(error.response.status === 500) {
            swal('Something Error', '', 'error');
        }

        @guest
            swal('Please Login', '', 'error');
        @endguest
    })
});
