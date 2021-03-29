
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

    var menu_list_tbl = getAjaxData('admin/all-menu-list', {});
    
    menu_list_tbl.then(function(data){
        $('#menu_list_table').DataTable( {
            data: data,
            "order": [[ 0, "desc" ]],
            columns: [
                { title: "ID" },
                { title: "Menu Date" },
                { title: "Menu Name (English)" },
                { title: "Menu Name (Arabic)" },
                { title: "Menu Status" },
                { title: "Action" },
            ],
            "columnDefs": [{
                targets: -1,
                render : function (data, type, row) {
                    return '<a style="background: #090c2f;" class="edit_menu" title="Edit" data-id="'+data+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><br><a style="background: red;" class="delete-menu" title="Delete" data-id="'+data+'"><i class="fa fa-trash" aria-hidden="true"></i></a>'    
                }
            },{
                targets: 0,
                "visible": false,
                "searchable": false,
            },{
                targets: 4,
                render : function (data, type, row) {
                    var checked = '';
                    var arr = data.split('-');
                    if(arr[0]== 'Active'){
                         checked = 'checked';
                    }
                    return '<label class="switch"><input type="checkbox" data-id="'+arr[1]+'" class="menu_status_check" '+checked+'><span class="slider round"></span></label>'    
                }
            }]
        });
    });

    

    $(document).on('click','.edit_menu',function(e){

        var id = $(this).data('id');
        $.ajax({
                type        : 'GET',
                url         : APP_URL + '/admin/menu/details/'+id,
                cache : false,
                processData: false
            })
            .done(function(response) {
                if(response.status_code == 200){
                        resetIncomingMenu();
                        $("#menu_update_id").val(id);
                        $(".en_menu_title").val(response.data.en_menu_title);
                        $(".ar_menu_title").val(response.data.ar_menu_title);
                        $("input[name='menu_status'][value='"+response.data.menu_status+"']").prop('checked', true);
                        $("#incoming-menu-modal").modal(); 
                }
            });
        return false;
    });

});
$('.loder_cla').addClass('div_hide');

$(document).on('click','#add-menu-modal',function(e){
       resetIncomingMenu();
       $("#incoming-menu-modal").modal(); 
       
    });

    $(document).on('change','.menu_status_check',function(e){
    
        $('.alert-status').html('');

        var id = $(this).data('id');
        var val = "Inactive";
        if(this.checked == true){
            val = "Active";
        }
        $.ajax({
            type        : 'GET',
            url         : APP_URL + '/admin/menu-status-check/'+id+'/'+val,
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


    $(document).on('click','.delete-menu',function(e){
        $("#delete_menu_id").val($(this).data('id'));
        $("#delete-menu-modal").modal();
        return false;
    });

    $(document).on('click','.delete-menu-yes',function(e){
        var menu_id = $("#delete_menu_id").val();
        if(menu_id != ''){
            return fetch(APP_URL+'/admin/delete/menu/'+menu_id,{
                method: 'GET', // *GET, POST, PUT, DELETE, etc.
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Accept" : "application/json",
                    "Authorization" : "Bearer "+localStorage.getItem('access_token'),
                },
                dataType: 'json'
            }).then(function(data){
                if(data.status == 200){
                    window.location.href = APP_URL+'/admin/menu';
                        location.reload();
                }
            }).catch(function(error){
                boostNotify("Oops something wrong.", "danger");
            });
        }else{
            boostNotify("Oops something wrong.", "danger");
        }
    });

    

function resetIncomingMenu(){
    $("#menu_update_id").val('');
    $(".en_menu_title").val();
    $(".ar_menu_title").val();
    $("input[name='menu_status'][value='Active']").prop('checked', true);
}


