@extends('layouts.master')
<style>
    table,
    table td {
      border: 0.5px solid #cccccc;
    }
    td {
      height: 80px;
      width: 160px;
      text-align: center;
      vertical-align: middle;
    }
  </style>
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
  اضافة طلبية 
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">طلبيات الاستيراد</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    اضافة طلبية</span>
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
    @if (session()->has('Erorr'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('Erorr') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

    @if (session()->has('Edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Edit') }}</strong>
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

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        {{ csrf_field() }}
                        {{-- 1 --}}

                        <div class="row">
                            <div class="col">
                                         <label for="inputName" class="control-label">نوع الطلبية   </label>
                                <label name="productorder" class="form-control SlectBox" 
                                   >
                                    <!--placeholder-->
                                    طبية استيراد
                                   
                                </label>
                            </div>

                           <div class="col">
                          


                                <label for="inputName" class="control-label">المورد</label>
                                <select name="importer" class="form-control SlectBox"
                                    >
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد  المورد</option>
                                    @foreach ($importClints as $importClint)
                                        <option value="{{ $importClint->id }}"> {{ $importClint->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                              <div class="col">
                                <label for="inputName" class="control-label">حدد العميل </label>
                                <select name="clint" id="clint" class="form-control SlectBox" onchange="">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد العميل </option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"> {{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                         

                        </div>

               

                        {{-- 3 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">الحالة   </label>
                                <select name="status" id="status" class="form-control" onchange="myFunctiontoToDisableReadOnly()">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد الحالة </option>
                                    <option value="1">لم تصل</option>
                                    <option value="2">تم الاستلام</option>
                                    <option value="3">مستلمة وغير مباعة </option>
                                    <option value="4">قيد التغليف   </option>
                                    <option value="5">  تم الشحن </option>




                                </select>
                            </div>

                            <div class="col">
                                <label>تاريخ الفاتورة</label>
                                <input class="form-control appearance-none block w-full  "type="date"  name="order_Date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input class="form-control appearance-none block w-full  " type="date" name="Due_date" placeholder="YYYY-MM-DD"
                                    type="text" required>
                            </div>
                          

                        </div>
                       
                            

                        

                    
                        {{-- 4 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ العمولة</label>
                                <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                    name="Amount_Commission" title="يرجي ادخال مبلغ العمولة "
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    readonly>
                            </div>
                            <div class="col">
                                <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control form-control-lg" id="Value_VAT" name="Value_VAT" value=0>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label"> السعر الاجمالي مع العمولة مع الضريبة </label>
                                <input type="text" class="form-control form-control-lg" id="Total" name="Total" readonly>
                            </div>
                        </div>
                        

                        {{-- 5 --}}
                        
                        <br>

                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                        <h5 class="card-title">المرفقات</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                data-height="70" />
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                        </div>
                        
                        <br>
                            
                        
                        
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card mg-b-20">
                                    <div class="card-header pb-0">
                                 
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table key-buttons text-md-nowrap" data-page-length='50'>
                                                <thead>
                                                    <tr>
                                                         <th><input name="select_all" id="example-select-all" type="checkbox" onclick="CheckAll('box1', this)" /></th>
                                                        <th class="border-bottom-0" style="text-align: center;vertical-align: middle; " >رقم المنتج</th>
                                                        <th class="border-bottom-0"  style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الشركة</th>
                                                        <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">اسم المنتج</th>
                                                        <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">الصنف</th>
                                                        
                                                        <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">بلد المنشأ</th>
                                                        <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">العدد</th>
                                                        <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">السعر</th>
                                                        <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">العمولة</th>
                                                        <th class="border-bottom-0" style="text-align: center;vertical-align: middle; background-color:rgb(97, 134, 255);">السعر الاجمالي</th>                                 
                    
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <?php $i = 0; ?>
                                                    @foreach ($productDetail as $x)
                                                        <?php $i++; ?>
                                                        <div class="all_row">
                                                        <tr>
                                                            
                                                            <td style="text-align: center;vertical-align: middle; width:5"><input type="checkbox"  value="{{ $x->id }}" class="box1"  ></td>
                                                            <td  style="text-align: center;vertical-align: middle; background-color:rgb(11, 107, 16);width:5" >{{ $i }}</td>
                                                            <td style="text-align: center;vertical-align: middle;">{{ $x->companies->company_name }}</td>
                    
                                                            <td style="text-align: center;vertical-align: middle;">
                                                                
                                                                <div class = "vertical"   ><div>
                                                                    <img src="Attachments/{{ $x->id }}/{{ $x->image_name }}"  width="140"  height="80" /></div>
                                                                    <div>
                                                                        {{ $x->product_name }}</div>
                                                                </div>
                    
                                                                
                                                                </td>
                                                          
                                                            <td style="text-align: center;vertical-align: middle;">{{ $x->groups->group_name }}</td>
                    
                                                            <td style="text-align: center;vertical-align: middle; color:rgb(207, 14, 14); " >{{ $x->companies->country_of_manufacture }}</td>
                                                            
                                                            <td   style="text-align: center;vertical-align: middle;width:15% ;height:15%">
                                                                <div class="input-group quantity" style=" ">
                                                                    <div class="input-group-prepend decrement-btn" style="cursor: pointer">
                                                                        <span class="input-group-text" >-</span>
                                                                    </div>
                                                                    <input type="text" class="qty-input form-control  "  id= "quntity" name ="quntity"style="text-align: center;vertical-align: middle;" maxlength="3" max="10" value="0">
                                                                    <div class="input-group-append increment-btn" style="cursor: pointer">
                                                                        <span class="input-group-text"  >+</span>
                                                                    </div>
                                                                </div>
                                                            </td>




                                                                                 <td class="cart-product-quantity"  style="text-align: center;vertical-align: middle;width:15% ;height:15%">
                                                                <div class="input-group " style=" ">
                                                                    
                                                                    <input type="text" class="price form-control " style="text-align: center;vertical-align: middle;"id="price" name ="price" onchange="myFun()" maxlength="5"  value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"readonly>
                                                                    
                                                                </div>
                                                            </td>

                                                            <td class="cart-product-quantity"  style="text-align: center;vertical-align: middle;width:15% ;height:15%">
                                                                
                                                                    
                                                                    <input type="text" class="commission_pice form-control" style="text-align: center;vertical-align: middle;"id="commission_pice"  name ="commission_pice" onchange="myFun()"  maxlength="5"  value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                                                                    
                                                                
                                                            </td>
                                                            <td class="cart-product-quantity"  style="text-align: center;vertical-align: middle;width:15% ;height:15%">
                                                                <div class="input-group" style=" ">
                                                                    
                                                                    <input type="text" class="total_price form-control" style="text-align: center;vertical-align: middle;"id="total_price" name ="total_price" maxlength="5"  value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"onchange="finalTotal('total1')" readonly>
                                                                    
                                                                </div>
                                                            </td>

                                                             
                                                            
                                                            
                                                        </tr>
                                                    </div>
                                                   
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                    
                    
                        </div>

                    </form>
                    
                </div>
            </div>
        </div>
    </div>
  
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
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>
<script>

    
$(document).ready(function () {

$('.increment-btn').click(function (e) {
    e.preventDefault();
    var incre_value = $(this).parents('.quantity').find('.qty-input').val();
    var price_elem=$(this).parent().parent().parent().find('.price');
    
    
   


    var value = parseInt(incre_value, 10);
    value = isNaN(value) ? 0 : value;
    if(value<100){
         var commission_pice= $(this).parent().parent().parent().find('.commission_pice').removeAttr("readonly");
       commission_pice.removeAttr("readonly");
     value++;
        $(this).parents('.quantity').find('.qty-input').val(value);
        price_elem.removeAttr("readonly");
       var clint=document.getElementById("clint").value;
    if(clint!=""){
           $(this).parent().parent().parent().find('.commission_pice').removeAttr("readonly");
        }
        var total=(price_elem.val()*value )+(commission_pice.val());
        alert(total);
        var total_pirce_elem=$(this).parent().parent().parent().find('.total_price');
        total_pirce_elem.val(total);

        
    }

});

$('.decrement-btn').click(function (e) {
    e.preventDefault();
    var decre_value = $(this).parents('.quantity').find('.qty-input').val();
    var value = parseInt(decre_value, 10);
    value = isNaN(value) ? 0 : value;
    
    if(value>0){
        value--;
        $(this).parents('.quantity').find('.qty-input').val(value);
     
    }
    if(value==0){
         $(this).parent().parent().parent().find('.price').attr("readonly","true");
         
         
        
            $(this).parent().parent().parent().find('.commission_pice').attr("readonly","true");

    
         
       
         document.getElementById("total_price").value = 0;
    }
});

});
</script>

<script>
        function myFunctiontoToDisableReadOnly() {

            var selected = new Array();
           
            $("#datatable input[type=text]").each(function() {
            
                selected.push(this.value);
            });
             alrt(selected.length);
                 document.getElementsByClassName('commission_pice').removeAttribute('readonly');

                
            

        }

    </script>
     <script>
        function myFun(elem) {

            var quntity = parseFloat(document.getElementById("quntity").value);
             
            var pirce = parseFloat(document.getElementById("price").value);
            var commission_pice = parseFloat(document.getElementById("commission_pice").value);
            var Value_VAT = parseFloat(document.getElementById("Value_VAT").value);

            var total_pirce = (pirce *quntity)+(commission_pice*quntity);


            if (typeof total_pirce === 'undefined'  ) {

                alert('يرجي ادخال مبلغ العمولة ');

            } 
            
            document.getElementById("total_price").value = total_pirce;
            var total_order=0;
             var total_commission=0;
        var total_elements=document.getElementsByClassName("total1");
        
        var commission_pice_elements=document.getElementsByClassName("commission_pice");
              

        var l=total_elements.length;

            for(var i=0;i<l;i++)
            {

           total_order=+total_elements[i].value;
           
           
            total_commission=+commission_pice_elements[i].value;
               
            }
           

            document.getElementById("Total").value =total_order+Value_VAT;
            document.getElementById("Amount_Commission").value =total_commission;




            
            {{-- else {
                var intResults = Amount_Commission2 * Rate_VAT / 100;

                var intResults2 = parseFloat(intResults + Amount_Commission2);

                sumq = parseFloat(intResults).toFixed(2);

                sumt = parseFloat(intResults2).toFixed(2);

                

                document.getElementById("Total").value = sumt;

            } --}}

        }

    </script>
    <script>


        function CheckAll(className,elem){

            var elements=document.getElementsByClassName(className);
            var l=elements.length;
           
            if(elem.checked){
                for(var i=0;i<l;i++){

                    elements[i].checked=true;

                }


            }
            else{
                for(var i=0;i<l;i++){
                    elements[i].checked=false;
                }
            }


        }
    </script>
@endsection
