@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.payment_gateway_settings') }}</h2>

            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-vcenter" id="data-table" aria-describedby="payment-gateway-setting-table">
                            <thead class="table-active">
                                <tr>
                                    <th scope="row">{{ config('languageString.no') }}</th>
                                    <th scope="row">{{ config('languageString.publish_key') }}</th>
                                    <th scope="row">{{ config('languageString.secret_key') }}</th>
                                    <th scope="row">{{ config('languageString.status') }}</th>
                                    <th scope="row">{{ config('languageString.environment') }}</th>
                                    <th scope="row">{{ config('languageString.actions') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        const sweetalert_title = "{{ config('languageString.payment_gateway_settings').'?' }}"
        const sweetalert_text = "{{ config('languageString.sweetalert_text') }}"
        const status_msg = "{{ config('languageString.status_msg') }}"
        const confirmButtonText = "{{ config('languageString.yes_delete_it') }}"
        const cancelButtonText = "{{ config('languageString.no_cancel_plx') }}"
    </script>
    <script src="{{URL::asset('assets/js/custom/paymentGatewaySettings.js')}}?v={{time()}}"></script>
@endsection
