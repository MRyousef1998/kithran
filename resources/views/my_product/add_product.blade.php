@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
    اضافة منتج
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المنتجات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    اضافة منتج</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

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

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        {{ csrf_field() }}
                        {{-- 1 --}}

                        <div class="row">
                            <div class="col">
                                         <label for="inputName" class="control-label">طلبية استيرادها </label>
                                <select name="productorder" class="form-control SlectBox" 
                                   >
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد الطلبية</option>
                                    @foreach ($orders as $order)
                                        <option value="{{ $order->id }}"> {{ $order->code }}</option>
                                    @endforeach
                                </select>
                            </div>

                           <div class="col">
                          


                                <label for="inputName" class="control-label">الصنف</label>
                                <select name="productCategory" class="form-control SlectBox"
                                    >
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد  الصنف</option>
                                    @foreach ($productCatgories as $productCatgory)
                                        <option value="{{ $productCatgory->id }}"> {{ $productCatgory->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                              <div class="col">
                                <label for="inputName" class="control-label">الشركة المصنعة</label>
                                <select name="productCompanies" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد الشركة المصنعة</option>
                                    @foreach ($productCompanies as $productCompany)
                                        <option value="{{ $productCompany->id }}"> {{ $productCompany->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                         

                        </div>

                        {{-- 2 --}}
                        <div class="row">
                          

                            <div class="col">
                                <label for="inputName" class="control-label"  onclick="console.log($(this).val())"
                                onchange="console.log('change is firing')">المنتج</label>
                                <select id="product" name="product" class="form-control">
                                    <option value="" selected disabled>حدد  منتج</option>
                                </select>
                            </div>
                               <div class="col">
                            <label for="inputName" class="control-label">الفئة</label>
                                <select id="productClass" name="productClass" class="form-control"
                                    >
                                    <!--placeholder-->
                                    
                                
                                </select>
                               
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">العدد</label>
                                <input type="text" class="form-control form-control-lg" id="selling_price" name="selling_price"
                                    title="يرجي العدد "
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    value=1 required>
                            </div>
                        </div>


                        {{-- 3 --}}

                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label">السعر </label>
                                <input type="text" class="form-control form-control-lg" id="primary_price"
                                    name="primary_price" title="يرجي ادخال السعر  "
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">سعر المبيع</label>
                                <input type="text" class="form-control form-control-lg" id="selling_price" name="selling_price"
                                    title="يرجي السعر "
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    value=0 required>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الحالة   </label>
                                <select name="Rate_VAT" id="Rate_VAT" class="form-control" onchange="myFunction()">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد الحالة </option>
                                    <option value="1">لم تصل</option>
                                    <option value="2">تم الاستلام</option>
                                    <option value="3">مستلمة وغير مباعة </option>
                                    <option value="3">قيد التغليف   </option>
                                    <option value="3">  تم الشحن </option>




                                </select>
                            </div>

                        </div>

                        {{-- 4 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="Total" name="Total" readonly>
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">ملاحظات</label>
                                <textarea class="form-control" id="exampleTextarea" name="note" rows="3"></textarea>
                            </div>
                        </div><br>

                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                        <h5 class="card-title">المرفقات</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                data-height="70" />
                        </div><br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                        </div>


                    </form>
                </div>
            </div>
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
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('select[name="productCompanies"]').on('change', function() {
                var productCompaniesId = $(this).val();
                if (productCompaniesId) {
                    $.ajax({
                        url: "{{URL::to('products')}}/" + productCompaniesId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product"]').empty();
                            $('select[name="product"]').append('<option value="" selected disabled>حدد  منتج</option>');
                            
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });

    </script>

   <script>
        $(document).ready(function() {
            $('select[name="product"]').on('change', function() {
                var productid = $(this).val();
                
                if (productid) {
                    $.ajax({
                        url: "{{URL::to('productsgroup')}}/" + productid,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="productClass"]').empty();
                            $.each(data, function(key, value) {
                                
                                $('select[name="productClass"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        },
                    });


                } else {
                    console.log('AJAX load did not work');
                }
            });

        });

    </script>

    <script>
        function myFunction() {

            var Amount_Commission = parseFloat(document.getElementById("Amount_Commission").value);
            var Discount = parseFloat(document.getElementById("Discount").value);
            var Rate_VAT = parseFloat(document.getElementById("Rate_VAT").value);
            var Value_VAT = parseFloat(document.getElementById("Value_VAT").value);

            var Amount_Commission2 = Amount_Commission - Discount;


            if (typeof Amount_Commission === 'undefined' || !Amount_Commission) {

                alert('يرجي ادخال مبلغ العمولة ');

            } else {
                var intResults = Amount_Commission2 * Rate_VAT / 100;

                var intResults2 = parseFloat(intResults + Amount_Commission2);

                sumq = parseFloat(intResults).toFixed(2);

                sumt = parseFloat(intResults2).toFixed(2);

                document.getElementById("Value_VAT").value = sumq;

                document.getElementById("Total").value = sumt;

            }

        }

    </script>



@endsection
