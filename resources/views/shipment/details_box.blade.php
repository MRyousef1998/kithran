
@section('css')
<!--Internal  Nice-select css  -->
<link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet"/>
<!-- Internal Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection


				<!-- row -->
				

				<!-- row -->
				<div class="row">
				@foreach ($detailBox as $x)
				<div class="col-lg-3">
					<div class="card item-card">
						<div class="card-body pb-0 h-100">
							<div class="text-center">
								<img src="{{URL::asset('assets/img/ecommerce/01.jpg')}}" alt="img" class="img-fluid">
							</div>
							<div class="card-body cardbody relative">
								<div class="cardtitle">
									<span>Items</span>
									<a>Sport shoes</a>
								</div>
								<div class="cardprice">
									<span class="type--strikethrough">$999</span>
									<span>$799</span>
								</div>
							</div>
						</div>
						<div class="text-center border-top pt-3 pb-3 pl-2 pr-2 ">
							<a href="#" class="btn btn-primary"> View More</a>
							<a href="#" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Add to cart</a>
						</div>
					</div>
				</div>
					@endforeach
					
				
					
				</div>
				<!-- /row -->

				<!-- row -->
				
			<!-- Container closed -->
		
		<!-- main-content closed -->

@section('js')
<!-- Internal Select2.min js -->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!-- Internal Nice-select js-->
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>
@endsection