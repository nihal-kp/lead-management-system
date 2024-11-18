@extends('layouts.app')

@section('title', 'Imports')

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

            <span class="text-muted font-weight-bold mr-4">Verify Import</span>

           
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
						<h3 class="card-label"></h3>
					</div>
                    <div class=" row w-100 mt-4">
				    <div class="col-lg-5" id="ready-button">
                    <a data-toggle="modal" href="#ready-import-modal" data-href="{{ route('imports.change-status', $import->id) }}" class="btn btn-info ready-import" title="Ready To Import"><i class="la la-check" ></i> Ready To Import</a>
                    </div>
                    </div>
				</div>
				<div class="card-body">
			
						<table class="table table-separate table-head-custom table-checkable" id="verify-table">
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

    <div class="modal fade" id="ready-import-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="">Confirmation</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
	
				<div class="modal-body">
					<p>Are you Ready To Import the following leads?</p>
				</div>
	
				<div class="modal-footer">
					<button type="button" class="btn btn-success btn_ready_import "><i class="la la-check"></i>Proceed</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')

<script type="text/javascript">

   $(function() {

    $verifyTable= $('#verify-table').DataTable({

        processing: true,
        serverSide: true,
        ajax: '{{ route("imports.verify", $import->id) }}',

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


    $('.ready-import').on('click', function() {
		var href=$(this).data('href');

		$('.btn_ready_import').off().click(function() {

	  		$.ajax({
			  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
			  type: 'POST',
			  //data:{},
			  dataType : 'JSON', 
			  url : href,
			  success: function(response){
				  $('#ready-import-modal').modal('hide');
				  if(response.status=='success')
				  {
					   toastr.success("Imported successfully", "Success"); 
                       $('#ready-button').html('<h3 class="text-success">Success!</h3>');
                       window.location.href="/imports";
				  }
			  },
              error: function(xhr, status, error) {
                $('#ready-import-modal').modal('hide');
                toastr.error("Something went wrong: " + error, "Error");
              }
			}); 
		});
	});

   });

</script>

@endpush