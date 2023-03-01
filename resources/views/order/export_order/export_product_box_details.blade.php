
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
					<div class="col-lg-6">
					 
						<div class="card item-card" >
							<div class="card-body pb-0 h-100">
								
								<div class="card-body cardbody relative">
									<div class="cardtitle">
										<span>  رقم المنتج</span>
										<span>اسم المنتج</span>
										<span>حالة المنتج </span>
										<span>حالة التغليف </span>
										<span>رقم الصندوق</span>
									</div>
									<div class="cardprice">
										<span >PNO{{$x->products_id}}</span>
										<span>{{$x->product_name}}</span>
										@if ($x->statuses_id==4)
										<span class="text-danger">{{$x->status_name}} </span>
									
									
									@else
									
										<span class="text-warning">{{$x->status_name}}</span>
										
									@endif
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
									
										<span class="text-danger">ORNO {{$x->orders_id}}</span>
									</div>
									</div>
							</div>
							<div class="text-center border-top pt-3 pb-3 pl-2 pr-2 ">

								@if ($x->statuses_id==4)
								<a
								data-id="{{ $x->products_id }}" data-order_id="{{ $x->orders_id }}" data-product_price="{{ $x->selling_price_with_comm }}" data-category_id="{{ $x->category_id }}"
								data-toggle="modal"
								href="#rechose" class="btn btn-primary"> استبدال </a>
								<a
								data-id="{{ $x->products_id }}" data-order_id="{{ $x->orders_id }}" data-product_price="{{ $x->selling_price_with_comm }}" 
								data-toggle="modal"
								href="#removeProdect" class="btn btn-primary"> تخلي </a>
								@else 
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
								
								
								
								
								<a
								data-id="{{ $x->products_id }}" data-order_id="{{ $x->orders_id }}" 
								data-toggle="modal"
								href="#sharcapsalation" class="btn btn-success"> تغليف مشترك</a>
								@endif
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
		
@section('js')

<!-- Internal Select2.min js -->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!-- Internal Nice-select js-->
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>
@endsection