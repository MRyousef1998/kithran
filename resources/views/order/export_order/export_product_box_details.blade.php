
@section('css')
<!--Internal  Nice-select css  -->
<link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet"/>
<!-- Internal Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection


				<!-- row -->
				<div class="row row-sm">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-body h-100">
								<div class="row row-sm ">
									<div class=" col-xl-5 col-lg-12 col-md-12">
										<div class="preview-pic tab-content">
										  <div class="tab-pane active" id="pic-1"><img src="http://127.0.0.1:8000/Attachments/{{ $product[0]->id }}/{{ $product[0]->image_name }}" width="250"  height="250" alt="image"/></div>
										 
										</div>
										
									</div>
									<div class="details col-xl-7 col-lg-12 col-md-12 mt-4 mt-xl-0">
										<h1 class="product-title mb-1">{{$product[0]->company_name}}    {{$product[0]->product_name}}</h1>
										<h2 class="product-title mb-1"></h2>
										<h3 class="product-title mb-1">{{$product[0]->group_name}}</h3>
										<h4 class="product-title mb-1">{{$product[0]->country_of_manufacture}}</h4>


										<div class="rating mb-1">
											<div class="stars">
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star text-muted"></span>
												<span class="fa fa-star text-muted"></span>
											
										<h4 class="price"> اجمالي العدد المطلوب:    <span class="h3 ml-2"style="color: rgb(170, 24, 10) ;">  {{$product[0]->aggregate}}</span></h4>
										
										<h4 class="price">عدد المكنات المغلفة :    <span class="h3 ml-2"style="color: rgb(170, 24, 10) ;">  {{$product[0]->box_count}}</span></h4>
										<div class="d-flex  mt-2">
											
										</div>
										<div class="action">
											<button class="add-to-cart btn btn-danger" type="button">تغلیف</button>
											<button class="add-to-cart btn btn-success" type="button">تسلیم</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /row -->

				<!-- row -->
				<div class="row">
				@foreach ($detailProduct as $x)
					<div class="col-lg-4">
					 
						<div class="card item-card" >
							<div class="card-body pb-0 h-100">
								
								<div class="card-body cardbody relative">
									<div class="cardtitle">
										<span>  رقم المنتج</span>
										<a>اسم المنتج</a>
										<span>الحالة </span>
										<a>رقم الصندوق</a>
									</div>
									<div class="cardprice">
										<span >{{$x->products_id}}</span>
										<span>{{$x->product_name}}</span>
										@if ($x->box_id==null)
										<span class="text-danger">غير مغلف</span>
									
									
									@else
									
										<span class="text-warning">مغلف</span>
										
									@endif
									@if ($x->box_id==null)
									<span class="text-danger">غير مخصص</span>
								
								
								@else
								
									<span class="text-warning">{{$x->box_code}}</span>
									
								@endif
										
									</div>
									<div class="cardtitle">
										
									</div>
									<div class="cardprice">
										
									</div>
								</div>
								<div class="card-body cardbody relative">
								<div class="cardtitle">
									
									<span class="text-danger">طلبية توريدها</span>
										
									</div>
									<div class="cardprice">
									
										<span class="text-danger">{{$x->orders_id}}</span>
									</div>
									</div>
							</div>
							<div class="text-center border-top pt-3 pb-3 pl-2 pr-2 ">
								@if ($x->box_id==null)
								<a
								data-id="{{ $x->products_id }}" data-order_id="{{ $x->orders_id }}"
								data-toggle="modal"
								href="#capsalation" class="btn btn-primary"> تغليف </a>
								
								@else
								<a
								data-id="{{ $x->products_id }}" data-order_id="{{ $x->orders_id }}"
								data-toggle="modal"
								href="#capsalation" class="btn btn-warning"> تغیر کود </a>
									
									
								@endif
								
								
								
								
								<a href="#" class="btn btn-success"><i class="fa fa-shopping-cart"></i> تسليم</a>
							</div>
						</div>
						
					</div>@endforeach
					
				
					
				</div>
				<!-- /row -->

				<!-- row -->
				<div class="row row-sm">
					<div class="col-md-12 col-xl-4 col-xs-12 col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="feature2">
									<i class="mdi mdi-airplane-takeoff bg-purple ht-50 wd-50 text-center brround text-white"></i>
								</div>
								<h5 class="mb-2 tx-16">Free Shipping</h5>
								<span class="fs-14 text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua domenus orioneu.</span>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-xl-4 col-xs-12 col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="feature2">
									<i class="mdi mdi-headset bg-pink  ht-50 wd-50 text-center brround text-white"></i>
								</div>
								<h5 class="mb-2 tx-16">Customer Support</h5>
								<span class="fs-14 text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua domenus orioneu.</span>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-xl-4 col-xs-12 col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="feature2">
									<i class="mdi mdi-refresh bg-teal ht-50 wd-50 text-center brround text-white"></i>
								</div>
								<div class="icon-return"></div>
								<h5 class="mb-2  tx-16">30 days money back</h5>
								<span class="fs-14 text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua domenus orioneu.</span>
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
		<div class="modal fade" id="capsalation1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
					   
					  

					  
						<input name="id" id="id" value="">
						<input name="order_id" id="order_id" value="">

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

@section('js')


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
<!-- Internal Select2.min js -->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!-- Internal Nice-select js-->
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>
@endsection