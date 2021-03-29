$(document).ready(function () {
   
    get_order_list();
    // get_order_details();
    function get_order_list() {
        localStorage.removeItem("cart");
        localStorage.removeItem("product");
      //  var token = window.localStorage.getItem('token');
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/firstmenu/details',
            cache : false,
            processData: false
        }).done(function(response) {
            if(response.status == 1){
                var html = '';
                let data =response.cms_data.categoryviaproductList;
                let count = data.length;
                let lang = response.user_details;
                let result = [];
                 result = data;
               if(count > 0){
                    $(result).each(function (index,value) {
                        if(lang == 'en'){
                        html += '<div style="cursor: pointer;" class="col-lg-3 col-md-4  col-sm-6 ">\n' +
                            '                    <div class="center-text mb-30 product-item">\n' +
                            '                        <div class="ïmg-200x mlr-auto pos-relative"><img id="myImg'+value.id+'" class="product-img" src="cms_media/productimage/'+value.product_image_url+'" alt="'+value.en_product_title+'" data-id="'+value.id+'"></div>\n' +
                            '                            <h5 class="mb-20">'+value.en_product_title+'</h5>\n' +
                            '                            <h4 class="mt-5"><b>QR'+value.en_product_price+'</b></h4>\n' +
                            '                            <h6 class="mt-20"><button class="btn-brdr-primary plr-25 add_cart" data-select="'+value.id+'"><i class = "icon icon ion-ios-cart"></i> ADD CART</button></h6>\n' +
                            '                    </div>\n' +
                            '                </div>';
                        }
                        else{
                        html += '<div style="cursor: pointer;" class="col-lg-3 col-md-4  col-sm-6 ">\n' +
                            '                    <div class="center-text mb-30 product-item">\n' +
                            '                        <div class="ïmg-200x mlr-auto pos-relative"><img id="myImg'+value.id+'" class="product-img" src="cms_media/productimage/'+value.product_image_url+'" alt="'+value.ar_product_title+'" data-id="'+value.id+'"></div>\n' +
                            '                            <h5 class="mb-20">'+value.ar_product_title+'</h5>\n' +
                            '                            <h4 class="mt-5"><b>QR'+value.ar_product_price+'</b></h4>\n' +
                            '                            <h6 class="mt-20"><button class="btn-brdr-primary plr-25 add_cart" data-select="'+value.id+'"><i class = "icon icon ion-ios-cart"></i> إضافة عربة</button></h6>\n' +
                            '                    </div>\n' +
                            '                </div>';
                        }
                    });
                }else{
                    html += '<div class="col-md-6">\n' +
                            '                    <div class="sided-90x mb-30 ">\n' +
                            '                       <span>Not Available</span>\n' +
                            '                    </div>\n' +
                            '                </div>';
                }
                $('.categorylist').html(response.cms_datacategoryList);
                $("#categoryid"+response.categoryid).attr('class','active');
                $('.menu_id').html(response.menuoutput);
                $(".menu_id").val(response.cms_data.menufirstid).attr('selected','selected');
                $('#categoryviaproductList').html(html);
            }else{
                alert(response.message)
            }
        });
    }

       
    
    

  $(document).on('change','.menu_id',function(e){
        
        var id = $(this).val();
            $.ajax({
            type        : 'GET',
            url         : APP_URL + '/menuwise/details/'+id,
            cache : false,
            processData: false
        }).done(function(response) {
            if(response.status == 1){
                var html = '';
                let data =response.cms_data.categoryviaproductList;
                let count = data.length;
                let lang = response.user_details;
                let result = [];
                 result = data;
          
               if(count > 0){
                    $(result).each(function (index,value) {
                        if(lang == 'en'){
                        html += '<div style="cursor: pointer;" class="col-lg-3 col-md-4  col-sm-6 ">\n' +
                            '                    <div class="center-text mb-30 product-item">\n' +
                            '                        <div class="ïmg-200x mlr-auto pos-relative"><img id="myImg'+value.id+'" class="product-img" src="cms_media/productimage/'+value.product_image_url+'" alt="'+value.en_product_title+'" data-id="'+value.id+'"></div>\n' +
                            '                            <h5 class="mb-20">'+value.en_product_title+'</h5>\n' +
                            '                            <h4 class="mt-5"><b>QR'+value.en_product_price+'</b></h4>\n' +
                            '                            <h6 class="mt-20"><button class="btn-brdr-primary plr-25 add_cart" data-select="'+value.id+'"><i class = "icon icon ion-ios-cart"></i> ADD CART</button></h6>\n' +
                            '                    </div>\n' +
                            '                </div>';
                        }
                        else{
                        html += '<div style="cursor: pointer;" class="col-lg-3 col-md-4  col-sm-6 ">\n' +
                            '                    <div class="center-text mb-30 product-item">\n' +
                            '                        <div class="ïmg-200x mlr-auto pos-relative"><img id="myImg'+value.id+'" class="product-img" src="cms_media/productimage/'+value.product_image_url+'" alt="'+value.ar_product_title+'" data-id="'+value.id+'"></div>\n' +
                            '                            <h5 class="mb-20">'+value.ar_product_title+'</h5>\n' +
                            '                            <h4 class="mt-5"><b>QR'+value.ar_product_price+'</b></h4>\n' +
                            '                            <h6 class="mt-20"><button class="btn-brdr-primary plr-25 add_cart" data-select="'+value.id+'"><i class = "icon icon ion-ios-cart"></i> إضافة عربة</button></h6>\n' +
                            '                    </div>\n' +
                            '                </div>';
                        }
                    });
                }else{
                    html += '<div class="col-md-6">\n' +
                            '                    <div class="sided-90x mb-30 ">\n' +
                            '                       <span>Not Available</span>\n' +
                            '                    </div>\n' +
                            '                </div>';
                }

                $('.categorylist').html(response.cms_datacategoryList);
                $("#categoryid"+response.categoryid).attr('class','active');
                $('.menu_id').html(response.menuoutput);
                $(".menu_id").val(response.cms_data.menufirstid).attr('selected','selected');
                $('#categoryviaproductList').html(html);
            }else{
                alert(response.message)
            }
        });
        
    });

    $(document).on('click','.categoryid',function(e){
        
        var categoryid = $(this).data('select');
        
            $.ajax({
            type        : 'GET',
            url         : APP_URL + '/categorywise/details/'+categoryid,
            cache : false,
            processData: false
        }).done(function(response) {
            if(response.status == 1){
                var html = '';
                let data =response.cms_data.categoryviaproductList;
                let lang = response.user_details;
                let count = data.length;
                let result = [];
                 result = data;
           
               if(count > 0){
                    $(result).each(function (index,value) {
                        if(lang == 'en'){
                        html += '<div style="cursor: pointer;" class="col-lg-3 col-md-4  col-sm-6 ">\n' +
                            '                    <div class="center-text mb-30 product-item">\n' +
                            '                        <div class="ïmg-200x mlr-auto pos-relative"><img id="myImg'+value.id+'" class="product-img" src="cms_media/productimage/'+value.product_image_url+'" alt="'+value.en_product_title+'" data-id="'+value.id+'"></div>\n' +
                            '                            <h5 class="mb-20">'+value.en_product_title+'</h5>\n' +
                            '                            <h4 class="mt-5"><b>QR'+value.en_product_price+'</b></h4>\n' +
                            '                            <h6 class="mt-20"><button class="btn-brdr-primary plr-25 add_cart" data-select="'+value.id+'"><i class = "icon icon ion-ios-cart"></i> ADD CART</button></h6>\n' +
                            '                    </div>\n' +
                            '                </div>';
                        }
                        else{
                        html += '<div style="cursor: pointer;" class="col-lg-3 col-md-4  col-sm-6 ">\n' +
                            '                    <div class="center-text mb-30 product-item">\n' +
                            '                        <div class="ïmg-200x mlr-auto pos-relative"><img id="myImg'+value.id+'" class="product-img" src="cms_media/productimage/'+value.product_image_url+'" alt="'+value.ar_product_title+'" data-id="'+value.id+'"></div>\n' +
                            '                            <h5 class="mb-20">'+value.ar_product_title+'</h5>\n' +
                            '                            <h4 class="mt-5"><b>QR'+value.ar_product_price+'</b></h4>\n' +
                            '                            <h6 class="mt-20"><button class="btn-brdr-primary plr-25 add_cart" data-select="'+value.id+'"><i class = "icon icon ion-ios-cart"></i> إضافة عربة</button></h6>\n' +
                            '                    </div>\n' +
                            '                </div>';
                        }
                    });
                }else{
                    html += '<div class="col-md-6">\n' +
                            '                    <div class="sided-90x mb-30 ">\n' +
                            '                       <span>Not Available</span>\n' +
                            '                    </div>\n' +
                            '                </div>';
                }
                $('.categorylist').html(response.cms_datacategoryList);
                $("#categoryid"+response.categoryid).attr('class','active');
                $('#categoryviaproductList').html(html);
               // $(".categoryid").removeClass('active');
                //$("#categoryid"+categoryid).attr('class','active');
            }else{
                alert(response.message)
            }
        });
        
    });


$(document).on('click','.product_details',function(e){
        
        var productid = $(this).data('id');
        
        var url = APP_URL + '/product-details/' + encodeURIComponent(productid);
        window.location.href = url;
        
    });

$(document).on('keyup','.product_key',

debounce(
    function(e){
            var productkey = $(this).val();

            $.ajax({
            type        : 'GET',
            url         : APP_URL + '/searchproduct/'+productkey,
            cache : false,
            processData: false
        }).done(function(response) {
            if(response.status == 1){
                var html = '';
                let data =response.cms_data.categoryviaproductList;
                let lang = response.user_details;
                let count = data.length;
                let result = [];
                 result = data;
           
               if(count > 0){
                    $(result).each(function (index,value) {
                        if(lang == 'en'){
                        html += '<div style="cursor: pointer;" class="col-lg-3 col-md-4  col-sm-6 ">\n' +
                            '                    <div class="center-text mb-30 product-item">\n' +
                            '                        <div class="ïmg-200x mlr-auto pos-relative"><img id="myImg'+value.id+'" class="product-img" src="cms_media/productimage/'+value.product_image_url+'" alt="'+value.en_product_title+'" data-id="'+value.id+'"></div>\n' +
                            '                            <h5 class="mb-20">'+value.en_product_title+'</h5>\n' +
                            '                            <h4 class="mt-5"><b>QR'+value.en_product_price+'</b></h4>\n' +
                            '                            <h6 class="mt-20"><button class="btn-brdr-primary plr-25 add_cart" data-select="'+value.id+'"><i class = "icon icon ion-ios-cart"></i> ADD CART</button></h6>\n' +
                            '                    </div>\n' +
                            '                </div>';
                        }
                        else{
                        html += '<div style="cursor: pointer;" class="col-lg-3 col-md-4  col-sm-6 ">\n' +
                            '                    <div class="center-text mb-30 product-item">\n' +
                            '                        <div class="ïmg-200x mlr-auto pos-relative"><img id="myImg'+value.id+'" class="product-img" src="cms_media/productimage/'+value.product_image_url+'" alt="'+value.ar_product_title+'" data-id="'+value.id+'"></div>\n' +
                            '                            <h5 class="mb-20">'+value.ar_product_title+'</h5>\n' +
                            '                            <h4 class="mt-5"><b>QR'+value.ar_product_price+'</b></h4>\n' +
                            '                            <h6 class="mt-20"><button class="btn-brdr-primary plr-25 add_cart" data-select="'+value.id+'"><i class = "icon icon ion-ios-cart"></i> إضافة عربة</button></h6>\n' +
                            '                    </div>\n' +
                            '                </div>';
                        }
                    });
                }else{
                    html += '<div class="col-md-6">\n' +
                            '                    <div class="sided-90x mb-30 ">\n' +
                            '                       <span>Not Available</span>\n' +
                            '                    </div>\n' +
                            '                </div>';
                }
                if(productkey != ""){
                        $('#categoryviaproductList').html(html);
                }
                else{
                $('.categorylist').html(response.cms_datacategoryList);
                $("#categoryid"+response.categoryid).attr('class','active');
                $('.menu_id').html(response.menuoutput);
                $(".menu_id").val(response.cms_data.menufirstid).attr('selected','selected');
                $('#categoryviaproductList').html(html);
                }
                
            }else{
                alert(response.message)
            }
        });
            
    },750)


    );


function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

$(document).on('change','.language',function(e){
        
        var language = $(this).val();
        
                    $.ajax({
            type        : 'GET',
            url         : APP_URL + '/changelanguage/'+language,
            cache : false,
            processData: false
        }).done(function(response) {
            if(response.status == 1){
                 window.location.reload();;
            }else{
                alert(response.message)
            }
        });
       
    });

$(document).on('click','.add_cart',function(e){
        
        var storage = JSON.parse(window.localStorage.getItem("cart"));
  if(storage==null){
    storage = [];
  }
        var productid = $(this).data('select');
        
        //var data = {productid:productid};
  storage.push(productid);
       
window.localStorage.setItem("cart",JSON.stringify(storage));
       $('#test_id').html(storage.join(",")); 
       if(storage.length > 0){
        $('#item_count').css('display', 'flex');
        $('#item_count').html(storage.length);
       }
    });

$(document).on('click','.cartdetails',function(e){

        //var id = $(this).data('id');
        window.location.href = APP_URL+'/cartview';
    });

$(document).on('click','.product-img',function(e){
        var modal = document.getElementById("myModal");
        var imgid = $(this).data('id');
       
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
                        
modal.style.display = "block";
  modalImg.src = $('#myImg'+imgid).attr('src');
  captionText.innerHTML = $('#myImg'+imgid).attr('alt');
        
    });
$(document).on('click','.closes',function(e){
var modal = document.getElementById("myModal");
        modal.style.display = "none";
    });
});



//Date time formater

//Modal to cancel the order
