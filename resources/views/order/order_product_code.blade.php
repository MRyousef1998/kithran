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
   
@stop
 
 
@section('page-header')
    <!-- breadcrumb -->

   
    
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">تفاصیل مع اکواد</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    قائمة </span>
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

    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('edit') }}</strong>
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

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row -->
    <div class="row">

      <div class="col-xl-12">
						<div class="card mg-b-20" >
							<div class="card-header pb-0">
                                     <div class="d-flex justify-content-between">

                    
                    </div>

                      <form action="/order_prodect_code_serch" method="POST" role="search" autocomplete="off">
                    {{ csrf_field() }}


                    

                    <div class="row">
                        
                        <div class="col-lg-2 mg-t-20 mg-lg-t-0" id="type">
                            <p class="mg-b-10">تحديد الصنف</p><select class="form-control select2" name="productCatgory"
                               required >
                                <option value="{{ $typeproductCatgories->id ?? null }}" selected>
                                    {{ $typeproductCatgories->category_name ?? 'يرجى اختيار الصنف' }}
                                </option>
                 
                                @foreach ($productCategories as $productCatgory)
                                <option value="{{ $productCatgory->id }}"> {{ $productCatgory->category_name }}</option>
                            @endforeach
                                

                            </select>
                        </div><!-- col-4 -->


                        <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}">
                        
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
                       
                        <table id="example" class="table key-buttons text-md-nowrap" >
                            <thead>
                                <tr>
                                    <th class="border-bottom-0"  style="text-align: center;vertical-align: middle;  " >کود المنتج</th>
                                    <th class="border-bottom-0"  style="text-align: center;vertical-align: middle;  ">الشركة</th>
                                    <th class="border-bottom-0"  style="text-align: center;vertical-align: middle;  ">مكان التواجد</th>
                                    
                                    
                                    <th class="border-bottom-0"  style="text-align: center;vertical-align: middle;  ">العمليات</th>


                                </tr>
                            </thead>
                            @if (isset($machines))
                            <tbody>
                                
                             <?php $i = 0; ?>
                                @foreach ($machines as $x)
                                   
                                    <tr>  
                                       
                                        <td style="text-align: center;vertical-align: middle;">P{{ $x->products_id }}OR{{$order->id}}</td>

                             
                                      
                                        <td style="text-align: center;vertical-align: middle;">{{$x->company_name}} {{$x->product_name}} {{ $x->group_name }}</td>
                                        @if($x->value_location=1){
                                      <td style="text-align: center;vertical-align: middle;">المستودع</td>

                                        }
                                        @elseif ($x->value_location=2){
                                      <td style="text-align: center;vertical-align: middle;">محل كبير</td>
                                            
                                        }
                                        @else{
                                      <td style="text-align: center;vertical-align: middle;">محل صغير</td>

                                        }
                                        @endif


                                        <td>
                                         @if($order->category_id=1)
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    <a class="dropdown-item" 
                                                    data-id="{{ $x->products_id }}" data-order_id="{{ $order->id }}"
								data-toggle="modal"
								href="#capsalation"    
                                                     
                                                    
                                                    
                                                    ><i
                                                        class="text-success fas fa-check"></i>&nbsp;&nbsp;
                                                    تغليف
                                                </a>
                                                <a class="dropdown-item" href="{{url('OrderDetails_not_recive_product')}}/{{$x->id}}">
                                                    <i
                                                    class="text-success fas fa-check"></i>&nbsp;&nbsp;الجرد و الاستلام
                                                    </a>   
                                                <a class="dropdown-item" href= "{{ URL::route('order_report', [$x->id]) }}"
                                       
                                                 
                                                        
                                                        ><i
                                                        class="text-success fas fa-check"></i>&nbsp;&nbsp;
                                             التقاریر
                                                </a>

                                                 <a class="dropdown-item" href="{{url('order_prodect_code')}}/{{$x->id}}">
                                                    <i
                                                     class="text-success fas fa-check"></i>&nbsp;&nbsp;تفاصيل المنتجات  
                                                                                                                   </a>   
                                                    @can('حذف الفاتورة')
                                                        <a class="dropdown-item" href="#" data-invoice_id="{{ $x->id }}"
                                                            data-toggle="modal" data-target="#delete_invoice"><i
                                                                class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                            الفاتورة</a>
                                                    @endcan

                                                    
                                                       
                                                  

                                                  
                                                        <a class="dropdown-item" href="#" data-invoice_id="{{ $x->id }}"
                                                            data-toggle="modal" data-target="#Transfer_invoice"><i
                                                                class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي
                                                            الارشيف</a>
                                                   

                                                 
                                                        
                                                   
                                                </div>
                                            </div>
                                            @else
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    <a class="dropdown-item" href="#update_status"
                                                    data-order_id="{{ $x->id }}"
                                                    data-toggle="modal"
                                                        
                                                        ><i
                                                        class="text-success fas fa-check"></i>&nbsp;&nbsp;
                                                    تأكيد استلام
                                                </a>
                                                <a class="dropdown-item" href="{{url('OrderDetails_not_recive_product')}}/{{$x->id}}">
                                                    <i
                                                    class="text-success fas fa-check"></i>&nbsp;&nbsp;الجرد و الاستلام
                                                    </a>   
                                                <a class="dropdown-item" href= "{{ URL::route('order_report', [$x->id]) }}"
                                       
                                                 
                                                        
                                                        ><i
                                                        class="text-success fas fa-check"></i>&nbsp;&nbsp;
                                             التقاریر
                                                </a>

                                                 <a class="dropdown-item" href="{{url('order_prodect_code')}}/{{$x->id}}">
                                                    <i
                                                     class="text-success fas fa-check"></i>&nbsp;&nbsp;تفاصيل المنتجات  
                                                                                                                   </a>   
                                                    @can('حذف الفاتورة')
                                                        <a class="dropdown-item" href="#" data-invoice_id="{{ $x->id }}"
                                                            data-toggle="modal" data-target="#delete_invoice"><i
                                                                class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                            الفاتورة</a>
                                                    @endcan

                                                    
                                                       
                                                  

                                                  
                                                        <a class="dropdown-item" href="#" data-invoice_id="{{ $x->id }}"
                                                            data-toggle="modal" data-target="#Transfer_invoice"><i
                                                                class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي
                                                            الارشيف</a>
                                                   

                                                 
                                                        
                                                   
                                                </div>
                                            </div>
                                            @endif

                                        </td>
                                        
                                    </tr>
                                @endforeach
                                </tbody>




                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>



    </div>


<!--update-->

           




    <!-- row closed -->
    </div>


    <!-- Container closed -->
    </div>

<!--CAPSALATION-->

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
<!--CAPSALATION-->

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
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

  
    <script>
        $('#capsalation').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var order_id = button.data('order_id')
    
            
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #order_id').val(order_id);
           
        })
    
    
    </script>

	

@endsection
