@extends('layout.index')
{{--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />

<style>
    .sync-button{
        float: right;
    }
    .view{
        font-size: 12px !important;
    }
    .select2-container{
        width: 100% !important;
    }
    .size_button{
        font-size: 12px !important;
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
    .fa-share-alt{
        margin-left: 5px;
        margin-top: 5px;
    }

    #alertSuccess{
        display:none;
    }
    #alertSuccess2{
        display:none;
    }

    .form-group{
        float:right;
    }

    table.dataTable.no-footer{
        border-bottom: 1px solid rgb(218 211 211 / 30%);
    }

    .page-header{
        display: block !important;
    }
   #example_length{
       margin-top: 12px;
       margin-left: 6px;
   }
   #example_filter{
       margin-bottom: 12px;
       margin-top: 12px;
       margin-right: 9px;
   }
</style>
@section('content')

    <div class="alert alert-important alert-success alert-dismissible "  role="alert" id="alertSuccess">
        <div class="d-flex">
            <div>
                <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
            </div>
            <div id="alertSuccessText">

            </div>
        </div>
        {{--            <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>--}}
    </div>

    <div class="page-header d-print-none">
        <div class="row g-2 align-items-center">
            <div class="col-md-6">

                <h1 class="page-title">
                    Orders
                </h1>
            </div>
            <div class="col-md-6">

                <div class="form-group">
{{--                    <form action="{{route('orders.filter')}}" method="post">--}}
{{--                        @sessionToken--}}
                        <div class="input-group">

{{--                            <input placeholder="Search" type="text" @if (isset($request)) value="{{$request->orders_filter}}" @endif name="orders_filter" id="question_email" autocomplete="off" class="form-control">--}}
{{--                            @if(isset($request))--}}
{{--                                <a href="{{URL::tokenRoute('home')}}" type="button" class="btn btn-secondary clear_filter_data mr-1 pl-4 pr-4">Clear</a>--}}
{{--                            @endif--}}
{{--                            <button type="submit" class="btn btn-primary mr-1 pl-4 pr-4">Filter</button>--}}
                            <a href="{{URL::tokenRoute('sync.orders')}}" type="button" class="btn sync-button btn-primary size_button ml-1">Sync Orders</a>



                        </div>
{{--                    </form>--}}
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
                                <table id="example"
                                       class="table table-vcenter card-table">
                                    <thead>
                                    <tr>
                                        <th><input class="form-check-input" id="checkAll" value=""  type="checkbox"></th>
                                        <th>Order Num#</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th >Total Price</th>
                                        <th >Payment Status</th>
                                        <th>Fulfillment Status</th>
                                        <th >Shipping Status</th>
                                        <th>Outside Shopify</th>
                                        <th class="w-1">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($orders as $order)
                                        @php
                                            $items=0;
                                            foreach($order->has_items as $lineitem){
                                                 $items+=$lineitem->quantity;
                                             }
                                            $tags=explode(',',$order->tags);
                                        @endphp
                                        <tr  class="product_detail" data-row_id="#varinat_details_{{$order->id}}">
                                            {{--                                    <td><input class="form-check-input single_check" value="{{$order->id}}"  type="checkbox"></td>--}}
                                            <td>
                                                @if($shop->status==1 && $order->status==0)
                                                    <input class="form-check-input single_check" value="{{$order->id}}"  type="checkbox">
                                                @endif
                                            </td>
                                            <td>{{$order->order_number}}</td>
                                            <td>{{\Carbon\Carbon::parse($order->order_created_at)->format('F d')}} </td>
                                            <td class="text-muted" >
                                                {{$order->shipping_name}}
                                            </td>
                                            <td>{{$order->currency}} {{$order->total_price}}</td>




                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h3 class="mx-3 my-3">No Orders Found</h3>
                            @endif

                            {{--                            <div class="pagination">--}}
                            {{--                                {{ $orders->appends(\Illuminate\Support\Facades\Request::except('page'))->links("pagination::bootstrap-4") }}--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script>

        $(document).ready(function (){
            $('#example').DataTable({
                "ordering": false
            });


            var val = [];
            $('body').on('click','.single_check',function(){



                if($('.single_check:checked').length >0){

                    $('.send_haligone_btn').show();
                }
                else{
                    $('.send_haligone_btn').hide();
                }
                // var val = [];
                $('.single_check:checked').each(function(i){
                    val.push($(this).val());
                    // val[i] = $(this).val();
                });
                console.log(val);

                var send_haligone= val.join(',');
                $('#send_haligone').val(send_haligone);

            });

            $("#checkAll").change(function(){

                if($('#checkAll').prop('checked')) {
                    $('.single_check').prop('checked', true)
                    $('.send_haligone_btn').show();
                    var val = [];
                    $('.single_check:checked').each(function(i){
                        val[i] = $(this).val();
                    });

                    var send_haligone= val.join(',');
                    $('#send_haligone').val(send_haligone);

                }else {
                    $('.single_check').prop('checked', false);
                    $('.send_haligone_btn').hide();
                    $('#send_haligone').val('');
                }
            });

            $('.send_haligone_btn').click(function (){
                $('#form1').submit();
            });


        });
    </script>
@endsection

