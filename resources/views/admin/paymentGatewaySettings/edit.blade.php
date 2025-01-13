@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.edit_payment_gateway_settings') }}</h2>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                        @csrf
                        <input type="hidden" id="edit_value" name="edit_value" value="{{$payment->id}}">
                        <input type="hidden" id="form-method" value="add">

                        {{--                        <div class="row">--}}
                        {{--                            <div class="col-lg-12">--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label> {{trans('adminMessages.base_url')}}:</label>--}}
                        {{--                                    <input class="form-control" id="pgs_base_url" name="pgs_base_url"--}}
                        {{--                                           placeholder="{{trans('adminMessages.base_url')}}" type="text"--}}
                        {{--                                           value="{{$payment->pgs_base_url}}"--}}
                        {{--                                           required>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ config('languageString.publish_key') }}</label>
                                    <input class="form-control" id="pgs_api_key" name="pgs_api_key"
                                           placeholder="{{ config('languageString.publish_key') }}" type="text"
                                           value="{{$payment->pgs_api_key}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ config('languageString.secret_key') }}</label>
                                    <input class="form-control" id="pgs_password" name="pgs_password"
                                           placeholder="{{ config('languageString.secret_key') }}" type="text"
                                           value="{{$payment->pgs_password}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ config('languageString.environment') }}</label>
                                    <select id="pgs_gateway_type" name="pgs_gateway_type" class="form-control" required>
                                        <option value="">{{ config('languageString.please_select_payment_environment') }}</option>
                                        <option
                                                value="production" @if($payment->pgs_gateway_type == 'production')
                                            {{'selected'}}
                                                @endif>
                                            {{ config('languageString.production') }}
                                        </option>
{{--                                        <option--}}
{{--                                                value="sandbox" @if($payment->pgs_gateway_type == 'sandbox')--}}
{{--                                            {{'selected'}}--}}
{{--                                                @endif>--}}
{{--                                            {{ config('languageString.sandbox') }}--}}
{{--                                        </option>--}}
                                        <option
                                                value="test_env" @if($payment->pgs_gateway_type == 'test_env')
                                            {{'selected'}}
                                                @endif>
                                            {{ config('languageString.test') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <button type="submit"
                                            class="btn btn-primary">{{ config('languageString.submit') }}</button>
                                    <a href="{{route('admin.paymentSettings.index')}}"
                                       class="btn btn-secondary">{{ config('languageString.cancel') }}</a>
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
    <script src="{{URL::asset('assets/js/custom/paymentGatewaySettings.js')}}"></script>
@endsection
