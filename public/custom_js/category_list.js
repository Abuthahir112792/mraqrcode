
$('.loder_cla').removeClass('div_hide');

jQuery(document).ready( function() {

    $("#myTab a").click(function(e){
        e.preventDefault();
        $(this).tab('show');
    });

    if(location.hash) {
        $('a[href="'+location.hash+'"]').click();
        window.location.hash = '';
    }

    var category_list_tbl = getAjaxData('admin/all-category-list', {});
    
    category_list_tbl.then(function(data){
        $('#category_list_table').DataTable( {
            data: data,
            "order": [[ 0, "desc" ]],
            columns: [
                { title: "ID" },
                { title: "Category Date" },
                { title: "Category Image" },
                { title: "Category Name English" },
                { title: "Category Name Arabic" },
                { title: "Menu Name" },
                { title: "Category Status" },
                { title: "Action" },
            ],
            "columnDefs": [{
                targets: -1,
                render : function (data, type, row) {
                    return '<a style="background: #090c2f;" class="edit_category" title="Edit" data-id="'+data+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><br><a style="background: red;" class="delete-category" title="Delete" data-id="'+data+'"><i class="fa fa-trash" aria-hidden="true"></i></a>'    
                }
            },{
                targets: 0,
                "visible": false,
                "searchable": false,
            },{
                targets: 6,
                render : function (data, type, row) {
                    var checked = '';
                    var arr = data.split('-');
                    if(arr[0]== 'Active'){
                         checked = 'checked';
                    }
                    return '<label class="switch"><input type="checkbox" data-id="'+arr[1]+'" class="category_status_check" '+checked+'><span class="slider round"></span></label>'    
                }
            },{
                targets: 2,
                render : function (data, type, row) {
                    return '<img style="width: 80px;" src="'+APP_URL+'/cms_media/categoryimage/'+data+'" alt="image"/>'    
                }
            }]
        });
    });

    

    $(document).on('click','.edit_category',function(e){

        var id = $(this).data('id');
        $.ajax({
                type        : 'GET',
                url         : APP_URL + '/admin/category/details/'+id,
                cache : false,
                processData: false
            })
            .done(function(response) {
                if(response.status_code == 200){
                        resetIncomingCategory();
                        $("#category_update_id").val(id);
                        $('.menu_id').html(response.categorymenuoutput);
                        $(".menu_id").val(response.data.menu_id).attr('selected','selected');
                        $(".en_category_title").val(response.data.en_category_title);
                        $(".ar_category_title").val(response.data.ar_category_title);
                        $('#img_category').attr('src', APP_URL + '/cms_media/categoryimage/'+response.data.category_image_url);
                        $('#category_image_url').val(response.data.category_image_url);
                        $("input[name='category_status'][value='"+response.data.category_status+"']").prop('checked', true);
                        $("#incoming-category-modal").modal(); 
                }
            });
        return false;
    });

});
$('.loder_cla').addClass('div_hide');

$(document).on('click','#add-category-modal',function(e){
       resetIncomingCategory();
       $.ajax({
                type        : 'GET',
                url         : APP_URL + '/admin/categorymenu/details',
                cache : false,
                processData: false
            })
         .done(function(response) {
                
                   $('.menu_id').html(response);
                   $("#incoming-category-modal").modal(); 
                
            });
       
    });

    $(document).on('change','.category_status_check',function(e){
    
        $('.alert-status').html('');

        var id = $(this).data('id');
        var val = "Inactive";
        if(this.checked == true){
            val = "Active";
        }
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/admin/category-status-check/'+id+'/'+val,
            cache : false,
            processData: false
        })
        .done(function(response) {
            if(response.status_code == 200){
                $('.cus_alert_msg').append(
                  '<div class="alert alert-success">'+
                    response.msg+
                  '</div>'
                );
                setTimeout(function(){  $('.cus_alert_msg').html(''); }, 5000);
            }
        });
    });

    $(document).on("click",".menu_upload_imagetest",function(){
        $('#img_category').html("");
        $('#category_image_url').html("");
        $("#menuuploadFile").unbind("change");
            $("#menuuploadFile").trigger('click').on("change",function(){
        var total_file=document.getElementById("menuuploadFile").files.length;
        if(total_file > 0){
            for(var i=0;i<total_file;i++)
            {
                var imageType = event.target.files[i].type;
                if(imageType == "image/jpeg" || imageType == "image/jpg" || imageType == "image/gif" || imageType == "image/png")
                   
                $('#img_category').attr('src', URL.createObjectURL(event.target.files[i]));
                $('#category_image_url').val(event.target.files[i].name); 
            }    
        } 
        });
    });

    $(document).on('click','.delete-category',function(e){
        $("#delete_category_id").val($(this).data('id'));
        $("#delete-category-modal").modal();
        return false;
    });

    $(document).on('click','.delete-category-yes',function(e){
        var category_id = $("#delete_category_id").val();
        if(category_id != ''){
            return fetch(APP_URL+'/admin/delete/category/'+category_id,{
                method: 'GET', // *GET, POST, PUT, DELETE, etc.
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Accept" : "application/json",
                    "Authorization" : "Bearer "+localStorage.getItem('access_token'),
                },
                dataType: 'json'
            }).then(function(data){
                if(data.status == 200){
                    window.location.href = APP_URL+'/admin/category';
                        location.reload();
                }
            }).catch(function(error){
                boostNotify("Oops something wrong.", "danger");
            });
        }else{
            boostNotify("Oops something wrong.", "danger");
        }
    });


function resetIncomingCategory(){
    $("#category_update_id").val('');
    $(".en_category_title").val();
    $(".ar_category_title").val();
    $("option[name='menu_id'][value='']").prop('selected', true);                   
    $("input[name='category_status'][value='Active']").prop('checked', true);
}


