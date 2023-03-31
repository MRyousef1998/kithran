@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

@section('title')
    تقرير الصندوق - مورا سوفت للادارة الفواتير
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقرير
                الصندوق</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>خطا</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- row -->
<div class="row">

    <div class="col-xl-12">
        <div class="card mg-b-20">


            <div class="card-header pb-0">

                <form action="/product_report_serch" method="POST" role="search" autocomplete="off">
                    {{ csrf_field() }}


                    <div class="col-lg-3">
                        <label class="rdiobox">
                            <input checked name="rdio" type="radio" value="1" id="type_div"> <span>بحث بنوع
                                الدفعات</span></label>
                    </div>


                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                        <label class="rdiobox"><input name="rdio" value="2" type="radio"><span>بحث برقم الدفعة
                            </span></label>
                    </div><br><br>

                    <div class="row">

                        <div class="col-lg-3 mg-t-20 mg-lg-t-0" id="type">
                            <p class="mg-b-10">تحديد نوع الدفعة</p><select class="form-control select2" name="type"
                                required>
                                <option value="{{ $type ?? 'حدد نوع الدفعات' }}" selected>
                                    {{ $type ?? 'حدد نوع الدفعات' }}
                                </option>

                                <option value="1">مدفوعات</option>
                                <option value="2">مقبوضات</option>
                                <option value="3">مصاريف خارجية</option>

                            </select>
                        </div><!-- col-4 -->


                        <div class="col-lg-3 mg-t-20 mg-lg-t-0" id="invoice_number">
                            <p class="mg-b-10">البحث برقم الدفعة</p>
                            <input type="text" class="form-control" id="product_id" name="product_id">

                        </div><!-- col-4 -->

                        <div class="col-lg-3" id="start_at">
                            <label for="exampleFormControlSelect1">من تاريخ</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" value="{{ $start_at ?? '' }}"
                                    name="start_at" placeholder="YYYY-MM-DD" type="text">
                            </div><!-- input-group -->
                        </div>

                        <div class="col-lg-3" id="end_at">
                            <label for="exampleFormControlSelect1">الي تاريخ</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" name="end_at"
                                    value="{{ $end_at ?? '' }}" placeholder="YYYY-MM-DD" type="text">
                            </div><!-- input-group -->
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-1 col-md-1">
                            <button class="btn btn-primary btn-block">بحث</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if (isset($products[0]))
                        <table id="example" class="table key-buttons text-md-nowrap" style=" text-align: center">
                            <thead>
                                <tr>
                                    <th class="wd-10p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">الشرکة</th>
                                    <th class="wd-15p border-bottom-0">اسم المنتج</th>
                                    <th class="wd-20p border-bottom-0">الصنف</th>
                                    <th class="wd-15p border-bottom-0">رقم طلبية التوريد</th>
                                  
                                    <th class="wd-15p border-bottom-0">المورد</th>
                                    <th class="wd-15p border-bottom-0">الحالة </th>
                                    <th class="wd-15p border-bottom-0">حالة البيع</th>

                                    <th class="wd-15p border-bottom-0">رقم طلبية التصدير</th>
                                    <th class="wd-15p border-bottom-0">اسم المستورد</th>
                                    <th class="wd-15p border-bottom-0">حالة التغليف</th>
                                    <th class="wd-15p border-bottom-0">رقم الصندوق</th>
                                    <th class="wd-15p border-bottom-0">حالة الشحن</th>
                                    <th class="wd-15p border-bottom-0">رقم الشحنة</th>
                                    <th class="wd-15p border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">العمليات</th>

                                    

                                </tr>
                            </thead>
                            <tbody>
                          
                               
                                  
                                    <tr>

                                        <td style="text-align: center;vertical-align: middle;">{{ $products[0]->products_id }}</td>
                                        <td style="text-align: center;vertical-align: middle;">{{$products[0]->company_name }}</td>

                                        <td style="text-align: center;vertical-align: middle;">
                                            
                                       
                                                <div>
                                                    {{ $products[0]->product_name }}</div>
                                          

                                            
                                            </td>
                                      
                                        <td style="text-align: center;vertical-align: middle;">{{ $products[0]->group_name }}</td>
                                      

                                        <td style="text-align: center;vertical-align: middle;">
                                            <a href="{{url('OrderDetails')}}/{{$products[0]->orders_id}}"style="text-align: center;vertical-align: middle;">
                                                {{$products[0]->orders_id}}
                                                </a>
                                            </td>
                                        <td style="text-align: center;vertical-align: middle;">{{ $products[0]->name }}</td>
                                                
                                        <td style="text-align: center;vertical-align: middle;">{{$satatus->status_name}}</td>
                                       
                                            @if($products[0]->selling_date==null)
                                                <td style="text-align: center;vertical-align: middle;">غير مباع</td>
                                                <td style="text-align: center;vertical-align: middle;">غير مخصص</td>
                                                <td style="text-align: center;vertical-align: middle;">غير مخصص</td>
                                                

                                             

                                            @else{
                                                <td style="text-align: center;vertical-align: middle;">مباع</td>
                                                <td style="text-align: center;vertical-align: middle;">
                                                <a href="{{url('OrderDetails')}}/{{$products[1]->orders_id}}"style="text-align: center;vertical-align: middle;">
                                                    {{$products[1]->orders_id}}
                                                    </a>
                                                </td>
                                                <td style="text-align: center;vertical-align: middle;">{{$products[1]->name}}</td>
                                          
                                            }
                                            @endif
                                            @if($products[0]->box_id==null)
                                        {<td style="text-align: center;vertical-align: middle;">غير مغلف</td>

                                            <td style="text-align: center;vertical-align: middle;">غير مخصص</td>
                                                  }
                                            @else{
                                            <td style="text-align: center;vertical-align: middle;">غير مغلف</td>
                                                
                                                
                                                
                                                <td style="text-align: center;vertical-align: middle;">{{$products[0]->box_code}}</td>}
                                            @endif

                                            @if($products[0]->shipment_id==null)
                                            {<td style="text-align: center;vertical-align: middle;">لم یتم الشحن</td>
    
                                                <td style="text-align: center;vertical-align: middle;">غير مخصص</td>
                                                      }
                                                @else{
                                                <td style="text-align: center;vertical-align: middle;">تم الشحن</td>
                                                    
                                                    
                                                    
                                                    <td style="text-align: center;vertical-align: middle;">{{$products[0]->shipment_id}}</td>}
                                                @endif

                                                <td style="text-align: center;vertical-align: middle;">{{$products[0]->note}}</td>

                                        <td style="text-align: center;vertical-align: middle;" >
                                            @if($satatus->id!=7 && $satatus->id!=0)
                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                data-products_id="{{ $products[0]->products_id }}" 
                                                data-status_id="{{ $satatus->id }}"
                                                data-status_name="{{ $satatus->status_name}}"
                                                

                                           

                                                

                                                data-toggle="modal" href="#delete" title="تعديل"><i
                                                    class="las la-pen"></i></a>

                                                @endif

                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                            data-products_id="{{ $products[0]->products_id }}" 
                                          
                                                data-toggle="modal" href="#delete" title="حذف"><i
                                                    class="las la-trash"></i></a>

                                        </td>
                                      
                                    </tr>
                              
                            </tbody>
                        </table>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تحديد منتج كانقص قطع</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="product_set_proken" method="post">
                        
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متاكد من العملية  ؟</p><br>
                            <input type="hidden" name="products_id" id="products_id" value="">
                           <label for="exampleTextarea">ملاحظات</label>
                                <textarea class="form-control" id="note" name="note" rows="1"></textarea>
                             
                        </div>
                         
                                
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<!--Internal  Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

<!--Internal  Datepicker js -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<!-- Internal Select2.min js -->
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!--Internal Ion.rangeSlider.min js -->
<script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
<!-- Ionicons js -->
<script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
<!--Internal  pickerjs js -->
<script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
<!-- Internal form-elements js -->
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
<script>
    var date = $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();

</script>

<script>
    $(document).ready(function() {

        $('#invoice_number').hide();

        $('input[type="radio"]').click(function() {
            if ($(this).attr('id') == 'type_div') {
                $('#invoice_number').hide();
                $('#type').show();
                $('#start_at').show();
                $('#end_at').show();
            } else {
                $('#invoice_number').show();
                $('#type').hide();
                $('#start_at').hide();
                $('#end_at').hide();
            }
        });
    });

</script>
<script>
    $('#delete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var products_id = button.data('products_id')
        var note = button.data('note')
        var modal = $(this)
        modal.find('.modal-body #products_id').val(products_id);
        modal.find('.modal-body #product_name').val(note);
    })
</script>

@endsection
