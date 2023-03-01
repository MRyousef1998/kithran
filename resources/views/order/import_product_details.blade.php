
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
										
										
										<div class="d-flex  mt-2">
											
										</div>
										<div class="action">
											
											<button class="add-to-cart btn btn-success" type="button">تأكيد</button>
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
										<span>الحالة</span>
										<a>كود </a>
									</div>
									<div class="cardprice">
										<span >{{$x->products_id}}</span>
										<span>{{$x->product_name}}</span>
										@if ($x->statuses_id==1)
										<span class="text-danger">غير مؤكد</span>
									
									
									@else
									
										<span class="text-success">{{$x->status_name}}</span>
										
									@endif
									@if ($x->statuses_id==1||$x->statuses_id=4)
									<span class="text-danger">غير مخصص</span>
								
								
								@else
								
									<span class="text-success">NO{{$x->statuses_id}}</span>
									
								@endif
								
									
								
								
								
								
								
									
								 
										
									</div>
									<div class="cardtitle">
										
									</div>
									<div class="cardprice">
										
									</div>
								</div>
								<div class="card-body cardbody relative">
								<div class="cardtitle">
									
									<span class="text-danger">كود طلبية التوريد</span>
										
									</div>
									<div class="cardprice">
									
										<span class="text-danger">No{{$x->orders_id}}</span>
									</div>
									</div>
							</div>
							<div class="text-center border-top pt-3 pb-3 pl-2 pr-2 ">
								@if ($x->statuses_id==1)
								<a
								data-id="{{ $x->products_id }}" data-order_id="{{ $x->orders_id }}"
								data-id="{{ $x->products_id }}" data-product_name="{{ $x->product_name }}"

                                                data-company_name="{{ $x->company_name }}"
                                               
                                                data-product_g="{{ $x->group_name }}"
                                                {{-- data-group_id="{{ $x->group_id }}" --}}
                                                data-image-name ="{{ $x->image_name}}"
                                                {{-- data-product_category_name ="{{ $x->category->category_name}}"
                                                data-product_category_id ="{{ $x->category->id}}" --}}



								data-toggle="modal"
								href="#submit1" class="btn btn-success"> تأكيد </a>
								
								@else
								<a class="text-success"
								> {{$x->status_name}}</a>
									
									
								@endif
								
								@if ($x->statuses_id==1)
								<a
								data-id="{{ $x->products_id }}" data-order_id="{{ $x->orders_id }}"
								data-id="{{ $x->products_id }}" data-product_name="{{ $x->product_name }}"

                                                data-company_name="{{ $x->company_name }}"
                                               
                                                data-product_g="{{ $x->group_name }}"
                                                {{-- data-group_id="{{ $x->group_id }}" --}}
                                                data-image-name ="{{ $x->image_name}}"
                                                {{-- data-product_category_name ="{{ $x->category->category_name}}"
                                                data-product_category_id ="{{ $x->category->id}}" --}}



								data-toggle="modal"

								href="#unsubmit" class="btn btn-danger"> عدم وصول</a>
								
								@else
								
									
								@endif
								
								
								
								
							</div>
						</div>
						
					</div>@endforeach
					
				
					
				</div>
				<!-- /row -->

				<!-- row -->
				
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