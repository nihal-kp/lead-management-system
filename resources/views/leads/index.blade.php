@extends('layouts.app')

@section('title', 'Leads')

@section('subheader')
<!--begin::Content-->

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">

            <!--begin::Page Title-->
            <a href="{{route('home')}}"><h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
                Dashboard                            </h5></a>
            <!--end::Page Title-->

            <!--begin::Actions-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>

            <span class="text-muted font-weight-bold mr-4">Leads</span>

           
            <!--end::Actions-->
        </div>
        <!--end::Info-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
        <!-- toolbar -->
       
        </div>
        <!--end::Toolbar-->
    </div>
</div>
 <!--end::Subheader-->
@endsection

@section('content')
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Notice-->


			<div class="card card-custom">
				<div class="card-header flex-wrap py-5">
					<div class="card-title">
						<h3 class="card-label">Leads
					
					</div>
					{{-- <div class="card-toolbar">
						<a href="{{route('leads.create')}}" class="btn btn-primary font-weight-bolder">
							<i class="la la-plus"></i>Add
						</a>
					</div> --}}
				</div>
				<div class="card-body">
			
						<table class="table table-separate table-head-custom table-checkable" id="lead-table">
							<thead>
								<tr>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Email</th>
									<th>Mobile Number</th>
									<th>Street 1</th>
									<th>Street 2</th>
									<th>City</th>
									<th>State</th>
									<th>Country</th>
									<th>Lead Source</th>
								</tr>
							</thead>
							<tbody>
						

							</tbody>
						</table>
			
					<!--end: Datatable-->
				</div>
			</div>
			<!--end::Card-->
				</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
@endsection

@push('scripts')

<script type="text/javascript">

   $(function() {

     $leadTable= $('#lead-table').DataTable({

         processing: true,
         serverSide: true,
         ajax: '{{ route("leads.index") }}',

         columns: [
	      	{ data: 'first_name', name: 'first_name'  },
			{ data: 'last_name', name: 'last_name'  },
			{ data: 'email', name: 'email'  },
			{ data: 'mobile_number', name: 'mobile_number'  },
			{ data: 'street_1', name: 'street_1'  },
			{ data: 'street_2', name: 'street_2'  },
			{ data: 'city', name: 'city'  },
			{ data: 'state', name: 'state'  },
			{ data: 'country', name: 'country'  },
            { data: 'lead_source', name: 'lead_source' },
         ],

     });

   });

</script>

@endpush