
$('.loder_cla').removeClass('div_hide');

jQuery(document).ready( function() {
    var usersList = getAjaxData('admin/users-list', {});
    
    usersList.then(function(data){
        console.log(data);
        $('#usersList').DataTable( {
            data: data,

            "order": [[ 0, "desc" ]],
            columns: [
                { title: "ID" },
                { title: "Name" },
                { title: "Email" },
                { title: "Mobile Number" },
                { title: "Address" },
                { title: "Action" },
                
            ],
            "columnDefs": [{
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
                },{
                targets: -1,
                render : function (data, type, row) {
                    return '<a style="background: #090c2f;" class="edit_user" title="Edit" data-id="'+data+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'    
                }
            }]/*,
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'excel',
                    filename: 'User History',
                    title:'',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4 ]
                    }
                },
                {
                    extend: 'print',
                    title: '',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4 ]
                    }
                }
            ]*/
        });
    });

    

    $(document).on('click','.edit_user',function(e){

        var id = $(this).data('id');
        $.ajax({
                type        : 'GET',
                url         : APP_URL + '/admin/user/details/'+id,
                cache : false,
                processData: false
            })
            .done(function(response) {
                if(response.status_code == 200){
                        resetIncomingUser();
                        $("#user_update_id").val(id);
                        $(".name").val(response.data.name);
                        $(".email").val(response.data.email);
                        $(".mobile_number").val(response.data.mobile_number);
                        $(".room_number").val(response.data.room_number);
                        $(".password").val(response.data.password);
                        $("#incoming-user-modal").modal(); 
                }
            });
        return false;
    }); 

});
$('.loder_cla').addClass('div_hide');
function resetIncomingUser(){
    $("#user_update_id").val('');
    $(".name").val('');
    $(".email").val('');
    $(".mobile_number").val('');
    $(".room_number").val('');
    $(".password").val('');
}