@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    
@endsection
@section('title')
    تفاصيل الطلبية
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">طلبيات {{$order->category->category_name}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
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
                                            <li><a href="#tab8" class="nav-link" data-toggle="tab">المرفقات</a></li>

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
                                            <div class="table-responsive ">
                                              
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; " >رقم المنتج</th>
                                    <th class="border-bottom-0"  style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الشركة</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">اسم المنتج</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الصنف</th>
                                    
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">بلد المنشأ</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">العدد </th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">عدد المغلف </th>



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
                                                <a class="modal-effect " data-effect="effect-scale" 
                                                data-id="{{ $x->id }}" data-order_id="{{ $id }}"
                                                data-toggle="modal" href="#modaldemo9" >{{ $x->aggregate }}</a>
                                        </td>
                                        <td class="cart-product-quantity" width="130px" style="text-align: center;vertical-align: middle;">
                                            <a class="modal-effect " data-effect="effect-scale" 
                                            data-id="{{ $x->id }}" data-order_id="{{ $id }}"
                                            data-toggle="modal" href="#modaldemo9" >{{ $x->box_count }}</a>
                                    </td>
                                       
                                        <td style="text-align: center;vertical-align: middle;" >

                                            <div class="dropdown">
        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary"
        data-toggle="dropdown" type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
        <div class="dropdown-menu tx-13">
            <a class="dropdown-item" href="#">بيع قطعة </a>
            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
            data-id="{{ $x->id }}" data-order_id="{{ $id }}"
            data-toggle="modal" href="#capsalation" title="حذف"> تغليف قطعة</a>
           
        </div>
    </div>
    
    
    
    
                                          
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                  
                                                


                                            </div>
                                        </div>


                                                     <div class="tab-pane" id="tab6">
                                            <div class="table-responsive ">
                                              
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                     <th class="border-bottom-0" style="text-align: center;vertical-align: middle; " >رقم المنتج</th>
                                    <th class="border-bottom-0"  style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الشركة</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">اسم المنتج</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الصنف</th>
                                    
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">بلد المنشأ</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">العدد </th>


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
                                            <a class="modal-effect " data-effect="effect-scale" 
                                            data-id="{{ $x->id }}" data-order_id="{{ $id }}"
                                            data-toggle="modal" href="#modaldemo9" >{{ $x->aggregate }}</a>
                                    </td>
                                    <td class="cart-product-quantity" width="130px" style="text-align: center;vertical-align: middle;">
                                        <a class="modal-effect " data-effect="effect-scale" 
                                        data-id="{{ $x->id }}" data-order_id="{{ $id }}"
                                        data-toggle="modal" href="#modaldemo9" >{{ $x->box_count }}</a>
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
                                            <div class="table-responsive ">
                                              
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                              <th class="border-bottom-0" style="text-align: center;vertical-align: middle; " >رقم المنتج</th>
                                    <th class="border-bottom-0"  style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الشركة</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">اسم المنتج</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الصنف</th>
                                    
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">بلد المنشأ</th>
                                    <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">العدد </th>


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
                                            <a class="modal-effect " data-effect="effect-scale" 
                                            data-id="{{ $x->id }}" data-order_id="{{ $id }}"
                                            data-toggle="modal" href="#modaldemo9" >{{ $x->aggregate }}</a>
                                    </td>

                                    <td class="cart-product-quantity" width="130px" style="text-align: center;vertical-align: middle;">
                                        <a class="modal-effect " data-effect="effect-scale" 
                                        data-id="{{ $x->id }}" data-order_id="{{ $id }}"
                                        data-toggle="modal" href="#modaldemo9" >{{ $x->box_count }}</a>
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

                                        <div class="tab-pane" id="tab8">
                                            <!--المرفقات-->
                                            <div class="card card-statistics">
                                                
                                                    <div class="card-body">
                                                     @if ($order->image_name=="")
                                                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                        <h5 class="card-title">اضافة مرفقات</h5>
                                                        <form method="post" action="{{route("addAttachments")}}" 
                                                            enctype="multipart/form-data">
                                                            {{ csrf_field() }}
                                                            
                                                            <div class="custom-file">
                                                            
                                                                <input type="file" class="custom-file-input" id="customFile"
                                                                    name="file_name" required>
                                                                <input type="hidden" id="order_id" name="order_id"
                                                                    value="{{$order->id}}">
                                                                
                                                                <label class="custom-file-label" for="customFile">حدد
                                                                    المرفق</label>
                                                            </div><br><br>
                                                            <button type="submit" class="btn btn-primary btn-sm "
                                                                name="uploadedFile">تاكيد</button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                
                                                <br>
                                                 @if ($order->image_name=="")
                                                                <div>
                                                               
                                                                
                                                                <span
                                                                        class="text-muted mt-1 tx-13 mr-2 mb-0">لا يوجد مرفقات</span>
                                                                </div>
                                                           
                                                            @else

                                                <div class="table-responsive mt-15">
                                                     <div class="table-responsive mt-15">
                                                    <table class="table center-aligned-table mb-0 table table-hover"
                                                        style="text-align:center">
                                                        <thead>
                                                            <tr class="text-dark">
                                                                <th scope="col">م</th>
                                                                <th scope="col">اسم الملف</th>
                                                                
                                                                <th scope="col">العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                                    
                                                               
                                                            
                                                         <tr>
                                                                    <td>####</td>
                                                                    <td>{{ $order->image_name }}</td>
                                                                    
                                                                    <td>{{ $order->created_at }}</td>
                                                                    <td colspan="2">

                                                                        <a class="btn btn-outline-success btn-sm"
                                                                            href="{{ url('View_file') }}/{{ $order->id }}/{{ $order->image_name }}"
                                                                            role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                            عرض</a>

                                                                        <a class="btn btn-outline-info btn-sm"
                                                                            href="{{ url('download') }}/{{ $order->id  }}/{{ $order->image_name }}"
                                                                            role="button"><i
                                                                                class="fas fa-download"></i>&nbsp;
                                                                            تحميل</a>

                                                                       
                                                                            <button class="btn btn-outline-danger btn-sm"
                                                                                data-toggle="modal"
                                                                                data-image_name="{{ $order->image_name}}"
                                                                                data-order_id="{{ $order->id }}"
                                
                                                                                data-target="#delete_file">حذف</button>
                                                                        

                                                                    </td>
                                                                </tr>
                                                            <?php $i = 0; ?>
                                                            @foreach ($order as $attachment)
                                                                <?php $i++; ?>
                                                               
                                                            @endforeach
                                                        </tbody>
                                                  
                                                    </table>
                                                              @endif  
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
                <form action="{{route('delete_file')}}" method="post">

                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>

                        
                        <input type="hidden" name="image_name" id="image_name" value="">
                        <input type="hidden" name="order_id" id="order_id" value="">

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
     <div class="modal fade" id="capsalation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">تغليف منتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    
                    <form action="{{ route('box.store') }}" method="post" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body">
                           
                          

                          
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="order_id" id="order_id" value="">

                                <label for="exampleInputEmail1">كود المنتج</label>
                                <input type="text" class="form-control" id="box_code" name="box_code" required>
                           
                            
                           
                        <br>
                            
                            <h5 class="card-title">المرفقات</h5>
    
                            <div class="col-sm-12 col-md-12">
                                <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                    data-height="70" />
                            </div><br>
                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">تاكيد</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="removeProdect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ازالة المنتج من الطلبية </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    
                    <form action="{{route("remove_product_fom_order")}}" method="post" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body">
                           
                          

                          
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="order_id" id="order_id" value="">

                                <label for="exampleInputEmail1">هل انت متأكد من ازالة المنتج؟ </label>
                                <div>
                                    <h6 style="color:red">سوف یتم ازالة قیمة هذا المنتج من الفاتورة الاساسية</h6>
                                    <input name="product_price" id="product_price"  readonly>
                              
                            </div>
                            
                           
                        
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">تاكيد</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- Container closed -->



    
    </div>
    <!-- main-content closed -->

    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تفاصيل الوصول</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                
                    </div>
        </div>
    </div>
    </div>
    <div class="modal" id="rechose">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تفاصيل الوصول</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                
                    </div>
        </div>
    </div>
    </div>



    <div class="modal fade" id="sharcapsalation" name ='sharcapsalation' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">تغليف  منتج</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> 
				
				<form  action="{{route("sharbox")}}"   method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="modal-body">
					   
					  

					  
						<input name="id" id="id" value="" hidden>
						<input name="order_id" id="order_id" value="" hidden>

						<div class="col">
							<label for="inputName" class="control-label">كود الصندوق المشترك</label>
							<select name="box_id" class="form-control SlectBox"
								>
								<!--placeholder-->
								<option value="" selected disabled>حدد  الصندوق</option>
								@foreach ($boxes as $box)
									<option value="{{ $box->id }}"> {{ $box->box_code }}</option>
								@endforeach
							</select>
						</div>
					   
						
					   
					<br>
						
						
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">تاكيد</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
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
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>





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
        $('#modaldemo9').on('show.bs.modal', function(event) {
            const zIndex = 1040 + 10 * $('.modal:visible').length;
  $(this).css('z-index', zIndex);
  setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
            var button = $(event.relatedTarget)
            var id = button.data('id')
            
            var order_id = button.data('order_id')
            
            $.ajax({
            type : 'GET',
          
            url :"{{URL::to('export_productDetails_box/')}}?product_id="+id+"&order_id="+order_id,
            
            success: function(result) {
                alert(1);
                $('#modaldemo9 div.modal-body').html(result);
            }
        });
            
           // modal.find('.modal-body #company_name').innerHTML = "yourTextHere";
        })
    
    </script>

<script>
    $('#rechose').on('show.bs.modal', function(event) {
        const zIndex = 1040 + 10 * $('.modal:visible').length;
$(this).css('z-index', zIndex);
setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
        var button = $(event.relatedTarget)
        var product_id = button.data('id')
        
        var category_id = button.data('category_id')
        var product_price = button.data('product_price')
        
        var order_id = button.data('order_id')
        
        $.ajax({
        type : 'GET',
      
        url :"{{URL::to('export_product_rechose_product/')}}?product_id="+product_id+"&order_id="+order_id+"&category_id="+category_id,
        
        success: function(result) {
            alert(result);
            $('#rechose div.modal-body').html(result);
        }
    });
        
       // modal.find('.modal-body #company_name').innerHTML = "yourTextHere";
    })

</script>




    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
           
            var image_name = button.data('image_name')
            var order_id = button.data('order_id')
            var modal = $(this)

            
            modal.find('.modal-body #image_name').val(image_name);
            modal.find('.modal-body #order_id').val(order_id);
        })


        $('#capsalation').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var order_id = button.data('order_id')

        
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #order_id').val(order_id);
       
    })

    $('#removeProdect').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var order_id = button.data('order_id')
        var product_price = button.data('product_price')
       alert(product_price);
        
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #order_id').val(order_id);
        modal.find('.modal-body #product_price').val(product_price);
       
    })

    </script>

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

    </script>
    <script>
        $('#sharcapsalation').on('show.bs.modal', function(event) {
            alert(122);
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var order_id = button.data('order_id')
            
            
        var modal = $(this)
        
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #order_id').val(order_id);
    
       
    })
    
    </script>

@endsection
