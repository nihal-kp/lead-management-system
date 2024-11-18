<!--SAMAH-->
@extends('layouts.app')
@section('title', 'Imports')
<!--begin::Content-->
@section('subheader')
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
        <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Page Title-->
                <a href="{{ route('home') }}">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
                </a>
                <!--end::Page Title-->
                <!--begin::Actions-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <a href="{{ route('imports.index') }}"><span class="text-muted font-weight-bold mr-4">Imports</span></a>
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold mr-4">{{ $import->id ? 'Edit' : 'Add' }} Import</span>
                <!--end::Actions-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Subheader-->
@endsection
@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class=" container ">
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">{{ $import->id ? 'Edit' : 'Add' }} Import</h3>
                </div>
                <!--begin::Form-->
                <form class="form"
                    action="{{ $import->id ? route('imports.update', $import->id) : route('imports.store') }}"
                    id="weight-class-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{ $import->id ? method_field('PUT') : '' }}
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label>Upload Excel: <span class="text-danger">*</span></label>
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                    <label class="custom-file-label selected" for="customFile">Choose File</label>
                                </div>
                                @if($errors->has('excel'))
                                    <div class="fv-plugins-message-container">
                                        <div  class="fv-help-block">{{ $errors->first('excel') }}</div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button type="submit" class="btn btn-primary mr-2">Save</button>
                                <a href="{{ route('imports.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
    <!--end::Content-->
@endsection

@push('styles')

@endpush

@push('scripts')

    <script>
        $(function() {
            new KTImageInput('kt_image_1');
        });
    </script>

    <script>
        $(function() {
            // minimum setup
            $('#kt_datepicker_1_modal').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                orientation: "bottom left",
                templates: arrows
            });
        });
    </script>

@endpush
