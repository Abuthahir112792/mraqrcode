@extends('layouts.app')
@section('page_css')

@endsection
@section('title')
    YouGo | Dashboard
@stop
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js">
<style type="text/css">
    .header-sub-title {
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
#usersList td, #usersList th {
  border: 1px solid #ddd;
  padding: 8px;
}
</style>
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <h4 class="header-sub-title">Dashboard</h4>



            <!-- DashBoard Content -->

            <div class="row" style="margin:20px 0px">
                <div class="col-sm-3">
                    <div class="panel">
                    <div class="panel-heading">
                        <p class="card-text">Active Menu</p>
                        <h3 class="card-title"><?php echo $data['activemenu'];?></h3>
                    </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel">
                    <div class="panel-heading">
                        <p class="card-text">Active Category</p>
                        <h3 class="card-title order-pending-card-value"><?php echo $data['activecategory'];?></h3>
                    </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel">
                    <div class="panel-heading">
                        <p class="card-text">Active Product</p>
                        <h3 class="card-title"><?php echo $data['activeproduct'];?></h3>
                    </div>
                    </div>
                </div>
            </div>

      

        </div>
    </div>
@endsection

@section('page_js')

    <script>

        $(document).ready(function(){
            $('.loder_cla').addClass('div_hide');
        });

    </script>

@endsection
