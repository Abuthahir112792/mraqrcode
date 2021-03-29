@extends('layouts.app')
@section('page_css')

@endsection
<style type="text/css">
    .header-sub-title {
        overflow: hidden;
    border-left: 10px solid #00AAFF !important;
    font-weight: 700;
    background: #252c35;
    border-top: 1px solid #ececec;
    border-bottom: 1px solid #ececec;
    display: inline-block;
    margin-bottom: 10px;
    padding: 12px 7px;
    width: 100%;
    font-size: 16px;
    color: #fff !important;
    border-right: 1px solid #ececec;
}

.statusorder {
  float: right;
}

@media screen and (max-width: 500px) {
  .header-sub-title label {
    float: none;
    display: block;
    text-align: left;
  }
  
  .statusorder {
    float: none;
  }
}
</style>
</script>
<!-- <style>
.statusorders {
 display: block;
}
</style> -->
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="header-sub-title ">
                <div class="pull-left">
            <h4 style="margin-top: 9px;">Menu</h4>
        </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @if (Session::has('message'))
                       <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $message)
                                <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- BASIC TABLE -->
                    <div class="panel">
                        <div class="panel-body">
                            <div class="bs-example">
                                <ul id="myTab" class="nav nav-pills">
                                    <button class="btn btn-success" id="add-menu-modal"><i class="fa fa-plus" aria-hidden="true"></i> Add Menu</button>   
                                    
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" >
                                        <table id="menu_list_table" class="display" width="100%">
                                            
                                        </table>  
                                          
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END BASIC TABLE -->
                </div>
            </div>
        </div>
    </div>
    <div id="incoming-menu-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Menu Details</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.addMenuUpdate') }}" method="post" id="incoming_croduct_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Menu Name (English) :</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control en_menu_title" name="en_menu_title"
                                id="en_menu_title" placeholder="Enter Menu Name (English)" require/>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Menu Name (Arabic) :</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control ar_menu_title" name="ar_menu_title"
                                id="ar_menu_title" placeholder="Enter Menu Name (Arabic)" require/>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Menu Status :</label>
                            <div class="col-md-8">
                                <label class="radio-inline">
                                  <input type="radio" name="menu_status" value="Active" checked="checked">Active
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="menu_status"  value="Inactive">Inactive
                                </label>
                            </div>
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                          </div>

                          <input type="hidden" name="menu_update_id" id="menu_update_id" >
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div id="delete-menu-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_menu_id" id="delete_menu_id" >
                    <p>Are you sure want to delete this menu?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger delete-menu-yes">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancelnotification_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-body canceltheorder" id="canceltheorder">

                </div>
                <div class="modal-footer border-0 p-0">
                    <a href="{{route('admin.menu')}}"  class="btn btn-link text-dark text-decoration-none">OK</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page_js')
<script type="text/javascript" src="{{asset('custom_js/menu_list.js')}}"></script>
<script>
    
</script>
@endsection