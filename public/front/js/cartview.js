$(document).ready(function () {
   
    get_cart_list();
    // get_order_details();
    function get_cart_list() {
        localStorage.removeItem("product");
      var storage = JSON.parse(window.localStorage.getItem("cart"));
      //$('#test_idsss').html(storage.join(",")); 
        if(storage.length > 0){
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/cartproduct/details/'+storage,
            cache : false,
            processData: false
        }).done(function(response) {
            if(response.status == 1){
                var html = '';
                let data =response.cartproductharray;
                let count = data.length;
                let lang = response.user_details;
                let total_aount = response.total_aount;
                let result = [];

                data.forEach(({id,...rest},index) => {
                    let check = result[id]
                    if(check ==undefined){
                    let temp = { [id]:{id,...rest,qty:1},...result }
                    result = temp
                    }
                    else
                    result[id].qty = result[id].qty +1  
                })
                 // result = data;
               if(count > 0){
                    Object.keys(result).forEach(function (value) {
                        var prodetail = JSON.parse(window.localStorage.getItem("product"));
                            if(prodetail==null){
                            prodetail = [];
                            }
                            var productid = result[value].en_product_title+'-QR '+result[value].en_product_price;
                            prodetail.push(productid);
                            window.localStorage.setItem("product",JSON.stringify(prodetail));
                            prodetail.join(",");
                            
                        html += '<div style="cursor: pointer;" class="col-md-12">\n' +
                            '                   <div class="list-group sc-cart-item-list">\n' +
                            '                    <div class="sc-cart-item list-group-item">\n' +
                            '                        <button type="button" class="sc-cart-remove product_delete" data-select="'+result[value].id+'"><i class = "icon icon ion-ios-trash"></i></button>\n' +
                            '                            <img class="img-responsive pull-left" src="cms_media/productimage/'+result[value].product_image_url+'" alt="Product Image">\n' +
                            '                            <h4 class="list-group-item-heading">'+`${lang=='en'?result[value].en_product_title : result[value].ar_product_title}`+'</h4>\n' +
                            '                            <input type="hidden" class="producttitle" data-id="'+result[value].id+'"  value="'+result[value].en_product_title+'-QR '+result[value].en_product_price+'">\n' +
                            '                            <div class="sc-cart-item-summary">\n' +
                            '                            QR <span class="sc-cart-item-price price" id="price'+result[value].id+'">'+result[value].en_product_price+'</span>\n' +
                            '                            <span class="price-span" id="price-span"> X </span>\n' +
                            '                            <input type="number" min="1" name="" class="sc-cart-item-qty qty" id="qty'+result[value].id+'" value="'+result[value].qty+'" data-id="'+result[value].id+'">\n' +
                            '                            <span class="price-span"> = </span>\n' +
                            '                            QR <span class="sc-cart-item-amount total" name="total" id="total'+result[value].id+'">'+result[value].en_product_price*result[value].qty+'</span>\n' +
                            '                    </div>\n' +
                            '                    </div>\n' +
                            '                    </div>\n' +
                            '                </div>';
                    });
                }else{
                    html += '<div class="col-md-6">\n' +
                            '                    <div class="sided-90x mb-30 ">\n' +
                            '                       <span>Not Available</span>\n' +
                            '                    </div>\n' +
                            '                </div>';
                }
                $('#cartproductList').html(html);
                $('#total_aount').html(total_aount);
            }else{
                alert(response.message)
            }
        });
    }
    else{
        window.location.href = APP_URL+'/home';
    }
    }


$(document).on('change','.language',function(e){
        
        var language = $(this).val();
        
                    $.ajax({
            type        : 'GET',
            url         : APP_URL + '/changelanguage/'+language,
            cache : false,
            processData: false
        }).done(function(response) {
            if(response.status == 1){
                 window.location.reload();
            }else{
                alert(response.message)
            }
        });
       
    });

$(document).on('click','.whatssend',function(e){
        var mobile_no = $('.mobile_no').val();
        var address = $('.address').val();
        var notes = $('.notes').val();
        var total_aount = $('.total_aount').html();
        var pickup = $('.select-slef-pickup').hasClass('delivery-method-active')?'TAKE AWAY': 'DINE-IN';
        var prodetail = JSON.parse(window.localStorage.getItem("product"));
        var product = prodetail.join(",");
        var productdetailsqtys = [];
        if(mobile_no=='')
        {
            $("input[name='mobile_no']").focus();
            $('#mobile_no_alert').css('display', 'flex');
            return false;
        }
        else if(address=='')
        {
            $("textarea[name='address']").focus();
            $('#address_alert').css('display', 'flex');
            return false;
        }
        else
        {
        for(var j=0;j<prodetail.length;j++){
            $(".producttitle").each(function() {
                    var productdetails = $(this).val();
                    var productdetailsid = $(this).attr("data-id");
                    if(prodetail[j] == productdetails){
                        var productqtys = $('#qty'+productdetailsid).val();
                         productdetailsqtys123 = productdetails+'-'+productqtys+'QTY';
                         productdetailsqtys.push(productdetailsqtys123);
                    }
                 });
        }
        var url = 'https://api.whatsapp.com/send?phone=97431326773&text='+productdetailsqtys.join(",")+' Address:'+address+' Mobile:'+mobile_no+' Notes:'+notes+' Total Amount: QR '+total_aount+' Pickup:'+pickup+' Please+confirm+via+reply.';
        window.open(url);
        }
    });

$(document).on('keyup','.mobile_no',function(e){
        $('#mobile_no_alert').css('display', 'flex');
        if($(this).val() != "")
        {
        $('#mobile_no_alert').css('display', 'none');
        }
    });

$(document).on('keyup','.address',function(e){
        $('#address_alert').css('display', 'flex');
        if($(this).val() != "")
        {
        $('#address_alert').css('display', 'none');
        }
    });

$(document).on('click','.clearall',function(e){
        localStorage.removeItem("cart");
        localStorage.removeItem("product");
        window.location.href = APP_URL+'/home';
    });

$(document).on('click','.product_delete',function(e){
        var product_id = $(this).data('select');
         
        var storage = JSON.parse(window.localStorage.getItem("cart"));
        var prodetail = JSON.parse(window.localStorage.getItem("product"));
                            
        let temp = storage.filter(it=>it!==product_id)
        window.localStorage.setItem("cart",JSON.stringify(temp))
        
        localStorage.removeItem(storage);
        localStorage.removeItem("product");
        get_cart_list();
    });

   let homeDelivery =$('.select-home-delivery')
    let selfPickUP =$('.select-slef-pickup')

    homeDelivery.click(function(){
        homeDelivery.addClass('delivery-method-active');
        selfPickUP.removeClass('delivery-method-active')
    })

    selfPickUP.click(function(){
        selfPickUP.addClass('delivery-method-active');
        homeDelivery.removeClass('delivery-method-active')
    })

    $(document).on('change','.qty',function(e){
            var qtyid = $(this).data('id');
            var price = $('#price'+qtyid).html();
            var qty = $('#qty'+qtyid).val();
            $('#total'+qtyid).html(price*qty);
            var sum = 0;
            $('span[name="total"]').each(function(){
            sum += +$(this).html();
            });
            $('.total_aount').html(sum);
    });

    $(document).on('keyup','.qty',function(e){
            var qtyid = $(this).data('id');
            var price = $('#price'+qtyid).html();
            var qty = $('#qty'+qtyid).val();
            $('#total'+qtyid).html(price*qty);
            var sum = 0;
            $('span[name="total"]').each(function(){
            sum += +$(this).html();
            });
            $('.total_aount').html(sum);
    });

});



//Date time formater

//Modal to cancel the order


// temp1.forEach(({id,...rest},index) => {
//     let check = result[id]
//     if(check ==undefined){
//     let temp = { [id]:{id,...rest,qty:1},...result }
//     result = temp
//     }
//     else
//     result[id].qty = result[id].qty +1  
// })