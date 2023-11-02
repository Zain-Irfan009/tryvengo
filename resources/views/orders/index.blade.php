@extends('layout.index')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .sync-button{
        float: right;
    }
    .view{
        font-size: 10px !important;
    }
    .select2-container{
        width: 100% !important;
    }
    .size_button{
        font-size: 13px !important;
    }
    .btn_size{
        font-size: 12px !important;
    }
    .input-group > :not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback){
        margin-left: 2px !important;
    }
    .display_none
    {
        display: none;
    }
    .pop_up{
        display: none;
    }
    span.select2.select2-container.select2-container--default {
        width: 150px !important;
        padding: 2px;
        background-color: #fff;
        border: 1px solid #dadcde;
    }
    .theme-light{
        overflow-x: hidden;
    }
    .error-alert{
        background: #d94343 !important;
        color: white !important;
    }
    .error_icon{
        color: white !important;
    }

</style>
@section('content')
    @if(session()->has('message'))
        <div class="alert alert-important alert-success alert-dismissible "  role="alert" id="alertSuccess">
            <div class="d-flex">
                <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                </div>
                <div id="alertSuccessText">
                    {{ session()->get('message') }}
                </div>
            </div>
            {{--            <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>--}}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert  alert-error error-alert alert-dismissible "  role="alert" id="alertSuccess2">
            <div class="d-flex">
                <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon error_icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                </div>
                <div id="alertSuccessText">
                    {{ session()->get('error') }}
                </div>
            </div>
            {{--            <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>--}}
        </div>
    @endif


    <div class="page-header d-print-none">
        <div class="row g-2 align-items-center">
            <div class="col-md-3">

                <h1 class="page-title">
                    Orders
                </h1>
            </div>
            <div class="col-md-9">

                <div class="form-group">
                    <form action="{{route('orders.filter')}}" method="post">
                        @sessionToken
                        <div class="input-group">

                            <input placeholder="Enter Order Name,Customer Name" type="text" @if (isset($request)) value="{{$request->orders_filter}}" @endif name="orders_filter" id="question_email" autocomplete="off" class="form-control">
                            @if(isset($request))
                                <a href="{{URL::tokenRoute('home')}}" type="button" class="btn btn-secondary clear_filter_data mr-1 pl-4 pr-4">Clear</a>
                            @endif
                            <button type="submit" class="btn btn-primary mr-1 pl-4 pr-4">Filter</button>
                            <a href="{{URL::tokenRoute('sync.orders')}}" type="button" class="btn sync-button btn-primary size_button ml-1">Sync Orders</a>
                        </div>
                    </form>
                </div>


            </div>




        </div>
    </div>



    <div class="page-body">
        <div class="">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            @if (count($orders) > 0)
                                <table
                                    class="table table-vcenter card-table">
                                    <thead>
                                    <tr>

                                        <th>Order Num#</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th >Total Price</th>
                                        <th>Status</th>
                                        <th >Tryvengo Status</th>
                                        <th style="width: 20% !important;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($orders as $order)
                                        @php
                                                $tags=explode(',',$order->tags);
                                        @endphp
                                        <tr  class="product_detail" data-row_id="#varinat_details_{{$order->id}}">
                                            <td> {{$order->order_number}}</td>
                                            <td>{{$order->created_at->format('F d')}}</td>
                                            <td class="text-muted" >
                                                {{$order->shipping_name}}
                                            </td>



                                            <td>{{$order->currency}} {{$order->total_price}}</td>
                                            <td>
                                                @if($order->status==0)
                                                <span class="badge bg-danger">Not Pushed</span>
                                                @else
                                                    <span class="badge bg-success">Pushed</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if($order->tryvengo_status)
                                                <span class="badge bg-primary">{{$order->tryvengo_status}}</span>
                                                    @endif
                                            </td>
                                            <td>
                                            @if($order->status==0)
                                                <a href="{{URL::tokenRoute('send.order.delivery',$order->id)}}" class="btn btn-primary view">Pushed to Tryvengo</a>
                                            @endif
                                            </td>






                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h3 class="mx-3 my-3">No Orders Found</h3>
                            @endif

                            <div class="pagination">
                                {{ $orders->appends(\Illuminate\Support\Facades\Request::except('page'))->links("pagination::bootstrap-4") }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        $(document).ready(function (){
            setTimeout(function() { $(".alert-success").hide(); }, 2000);
            setTimeout(function() { $(".error-alert").hide(); }, 2000);
            $('.js-example').select2();
            $('.product_detail').click(function (){

                var row=$(this).data('row_id');
                $(row).toggle();

            });
            $('select[name=date]').on('change',function(){
                if($(this).val()=='custom')
                {
                    $('.date_range').removeClass('display_none');
                }else
                {
                    $('.date_range').addClass('display_none');
                }
            });

            $(".items").mouseover(function(){

                $(this).parents('.main_popup').find(".pop_up").css("display", "block");
            });
            $(".pop_up").mouseout(function(){
                $(this).parents('.main_popup').find(".pop_up").css("display", "none");
            });

            $('body').on('click','.single_check',function(){


                if($('.single_check:checked').length >0){

                    $('.export_btn').show();
                }

                var val = [];
                $('.single_check:checked').each(function(i){
                    val[i] = $(this).val();
                });


                var export_id= val.join(',');
                $('#export_id').val(export_id);

            });


            $('body').on('click','.submit_loader',function (){
                $('body').append('<div class="LockOn"> </div>');
            });
        })
    </script>
@endsection

