@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('title')
    تفاصيل الطلبية
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">طلبيات الاستيراد</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الطلبية</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    <!-- row opened -->
    <div class="row row-sm">

        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات
                                                    الطلبية</a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">مكنات القهوة</a></li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab">المطاحن</a></li>
                                            <li><a href="#tab7" class="nav-link" data-toggle="tab">قطع تبديل</a></li>
                                            <li><a href="#tab7" class="nav-link" data-toggle="tab">المرفقات</a></li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">


                                        <div class="tab-pane active" id="tab4">
                                            <div class="table-responsive mt-15">

                                                <table class="table table-striped" style="text-align:center">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">رقم الطلبية</th>
                                                            <td>{{ $order->id }}</td>
                                                             <th scope="row">توع الطلبية</th>
                                                            <td>{{ $order->category->category_name }}</td>
                                                            <th scope="row">المورد</th>
                                                            <td>{{ $order->importer->name  }}</td>
                                                            <th scope="row">العميل</th>
                                                            <td>{{ $order->representative->name  }}</td>
                                                            <th scope="row">تاريخ الطلب</th>
                                                            <td>{{ $order->order_date }}</td>
                                                            
                                                           
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">الحالة الحالية</th>
                                                            @if ($order->status->id==2)
                                                                <td><span
                                                                        class="badge badge-pill badge-success">{{ $order->status->status_name }}</span>
                                                                </td>
                                                           @elseif ($order->status->id==1)
                                                                <td><span
                                                                        class="badge badge-pill badge-danger">{{ $order->status->status_name }}</span>
                                                                </td>
                                                            @else
                                                                <td><span
                                                                        class="badge badge-pill badge-warning">{{ $order->status->status_name }}</span>
                                                                </td>
                                                            @endif
                                                            <th scope="row">مبلغ العمولة</th>
                                                            <td>{{ $order->Amount_Commission }}</td>
                                                            <th scope="row">الضرائب</th>
                                                            <td>{{ $order->Value_VAT }}</td>
                                                            <th scope="row">التكلفة الاجمالية</th>
                                                            <td>{{ $order->Total }}</td>
                                                            <th scope="row">تاريخ الوصول</th>
                                                            <td>{{ $order->order_due_date }}</td>
                                                        </tr>


                                                       
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab5">
                                            <div class="table-responsive mt-15">
                                              
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; " >رقم المنتج</th>
                                    <th class="border-bottom-0"  style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الشركة</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">اسم المنتج</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الصنف</th>
                                    
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">بلد المنشأ</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الصورة </th>


                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($machines as $x)
                                    <?php $i++; ?>
                                    <tr>
                                        <td  style="text-align: center;vertical-align: middle; background-color:rgb(11, 107, 16);width:5" >{{ $i }}</td>
                                        <td style="text-align: center;vertical-align: middle;">{{ $x->company_name }}</td>

                                        <td style="text-align: center;vertical-align: middle;">
                                            
                                            <div class = "vertical"><div>
                                                <img src="http://127.0.0.1:8000/Attachments/{{ $x->id }}/{{ $x->image_name }}"  width="180"  height="120" /></div>
                                                <div>
                                                    {{ $x->product_name }}</div>
                                            </div>

                                            
                                            </td>
                                      
                                        <td style="text-align: center;vertical-align: middle;">{{ $x->group_name }}</td>

                                        <td style="text-align: center;vertical-align: middle; color:rgb(207, 14, 14); " >{{ $x->country_of_manufacture }}</td>
                                        
                                        <td class="cart-product-quantity" width="130px" style="text-align: center;vertical-align: middle;">
                                            <div class="input-group quantity">
                                                <div class="input-group-prepend decrement-btn" style="cursor: pointer">
                                                    <span class="input-group-text">-</span>
                                                </div>
                                                <input type="text" class="qty-input form-control" maxlength="2" max="10" value="1">
                                                <div class="input-group-append increment-btn" style="cursor: pointer">
                                                    <span class="input-group-text">+</span>
                                                </div>
                                            </div>
                                        </td>


                                        <td style="text-align: center;vertical-align: middle;" >

                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-product_name="{{ $x->product_name }}"

                                                data-company_name="{{ $x->company_name }}"
                                                data-company_id="{{ $x->id }}"
                                                data-product_g="{{ $x->group_name }}"
                                                {{-- data-group_id="{{ $x->group_id }}" --}}
                                                data-image-name ="{{ $x->image_name}}"
                                                {{-- data-product_category_name ="{{ $x->category->category_name}}"
                                                data-product_category_id ="{{ $x->category->id}}" --}}

                                                

                                                data-toggle="modal" href="#edit_Product" title="تعديل"><i
                                                    class="las la-pen"></i></a>



                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-product_name="{{ $x->product_name }}"
                                                data-toggle="modal" href="#delete" title="حذف"><i
                                                    class="las la-trash"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                  
                                                


                                            </div>
                                        </div>


                                                     <div class="tab-pane" id="tab6">
                                            <div class="table-responsive mt-15">
                                              
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; " >رقم المنتج</th>
                                    <th class="border-bottom-0"  style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الشركة</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">اسم المنتج</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الصنف</th>
                                    
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">بلد المنشأ</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الصورة </th>


                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($grinders as $x)
                                    <?php $i++; ?>
                                    <tr>
                                        <td  style="text-align: center;vertical-align: middle; background-color:rgb(11, 107, 16);width:5" >{{ $i }}</td>
                                        <td style="text-align: center;vertical-align: middle;">{{ $x->company_name }}</td>

                                        <td style="text-align: center;vertical-align: middle;">
                                            
                                            <div class = "vertical"><div>
                                                <img src="http://127.0.0.1:8000/Attachments/{{ $x->id }}/{{ $x->image_name }}"  width="180"  height="120" /></div>
                                                <div>
                                                    {{ $x->product_name }}</div>
                                            </div>

                                            
                                            </td>
                                      
                                        <td style="text-align: center;vertical-align: middle;">{{ $x->group_name }}</td>

                                        <td style="text-align: center;vertical-align: middle; color:rgb(207, 14, 14); " >{{ $x->country_of_manufacture }}</td>
                                        
                                        <td class="cart-product-quantity" width="130px" style="text-align: center;vertical-align: middle;">
                                         {{ $x->aggregate }}   
                                        </td>


                                        <td style="text-align: center;vertical-align: middle;" >

                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-product_name="{{ $x->product_name }}"

                                                data-company_name="{{ $x->company_name }}"
                                                data-company_id="{{ $x->id }}"
                                                data-product_g="{{ $x->group_name }}"
                                                {{-- data-group_id="{{ $x->group_id }}" --}}
                                                data-image-name ="{{ $x->image_name}}"
                                                {{-- data-product_category_name ="{{ $x->category->category_name}}"
                                                data-product_category_id ="{{ $x->category->id}}" --}}

                                                

                                                data-toggle="modal" href="#edit_Product" title="تعديل"><i
                                                    class="las la-pen"></i></a>



                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-product_name="{{ $x->product_name }}"
                                                data-toggle="modal" href="#delete" title="حذف"><i
                                                    class="las la-trash"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                                            </div>
                                        </div>


                         <div class="tab-pane" id="tab7">
                                            <div class="table-responsive mt-15">
                                              
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; " >رقم المنتج</th>
                                    <th class="border-bottom-0"  style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الشركة</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">اسم المنتج</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الصنف</th>
                                    
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">بلد المنشأ</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الصورة </th>


                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($parts as $x)
                                    <?php $i++; ?>
                                    <tr>
                                        <td  style="text-align: center;vertical-align: middle; background-color:rgb(11, 107, 16);width:5" >{{ $i }}</td>
                                        <td style="text-align: center;vertical-align: middle;">{{ $x->company_name }}</td>

                                        <td style="text-align: center;vertical-align: middle;">
                                            
                                            <div class = "vertical"><div>
                                                <img src="http://127.0.0.1:8000/Attachments/{{ $x->id }}/{{ $x->image_name }}"  width="180"  height="120" /></div>
                                                <div>
                                                    {{ $x->product_name }}</div>
                                            </div>

                                            
                                            </td>
                                      
                                        <td style="text-align: center;vertical-align: middle;">{{ $x->group_name }}</td>

                                        <td style="text-align: center;vertical-align: middle; color:rgb(207, 14, 14); " >{{ $x->country_of_manufacture }}</td>
                                        
                                        <td class="cart-product-quantity" width="130px" style="text-align: center;vertical-align: middle;">
                                         {{ $x->aggregate }}   
                                        </td>


                                        <td style="text-align: center;vertical-align: middle;" >

                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-product_name="{{ $x->product_name }}"

                                                data-company_name="{{ $x->company_name }}"
                                                data-company_id="{{ $x->id }}"
                                                data-product_g="{{ $x->group_name }}"
                                                {{-- data-group_id="{{ $x->group_id }}" --}}
                                                data-image-name ="{{ $x->image_name}}"
                                                {{-- data-product_category_name ="{{ $x->category->category_name}}"
                                                data-product_category_id ="{{ $x->category->id}}" --}}

                                                

                                                data-toggle="modal" href="#edit_Product" title="تعديل"><i
                                                    class="las la-pen"></i></a>



                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-product_name="{{ $x->product_name }}"
                                                data-toggle="modal" href="#delete" title="حذف"><i
                                                    class="las la-trash"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                  
                                                


                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab6">
                                            <!--المرفقات-->
                                            <div class="card card-statistics">
                                                
                                                    <div class="card-body">
                                                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                        <h5 class="card-title">اضافة مرفقات</h5>
                                                        <form method="post" action=""
                                                            enctype="multipart/form-data">
                                                            {{ csrf_field() }}
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="customFile"
                                                                    name="file_name" required>
                                                                <input type="hidden" id="customFile" name="invoice_number"
                                                                    value="">
                                                                <input type="hidden" id="invoice_id" name="invoice_id"
                                                                    value="">
                                                                <label class="custom-file-label" for="customFile">حدد
                                                                    المرفق</label>
                                                            </div><br><br>
                                                            <button type="submit" class="btn btn-primary btn-sm "
                                                                name="uploadedFile">تاكيد</button>
                                                        </form>
                                                    </div>
                                                
                                                <br>

                                                <div class="table-responsive mt-15">
                                                    
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /div -->
        </div>

    </div>
    <!-- /row -->

    <!-- delete -->
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post">

                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>

                        <input type="hidden" name="id_file" id="id_file" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })

    </script>

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

    </script>

@endsection
