@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('adminMessages.add_payment_gateway_setting') }}</h2>

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
                        <input type="hidden" id="edit_value" name="edit_value" value="">
                        <input type="hidden" id="form-method" value="add">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{trans('adminMessages.base_url')}} :</label>
                                    <input class="form-control" id="pgs_base_url" name="pgs_base_url"
                                           placeholder="{{trans('adminMessages.base_url')}}" type="text" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{trans('adminMessages.api_token')}} </label>
                                    <input class="form-control" id="pgs_api_key" name="pgs_api_key"
                                           placeholder="{{trans('adminMessages.api_token')}}" type="text" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{trans('adminMessages.Payment_Gateway')}} </label>
                                    <select id="pgs_payment_gateway" name="pgs_payment_gateway" class="form-control"
                                            required>
                                        <option value="">{{trans('adminMessages.please_select_payment_gateway')}} </option>
                                        <option value="cc">{{trans('adminMessages.credit_card')}} </option>
                                        <option value="knet">{{trans('adminMessages.k_net')}} </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{trans('adminMessages.currency_code')}} </label>
                                    <select id="pgs_currency_code" name="pgs_currency_code" class="form-control"
                                            required>
                                        <option value=""> {{trans('adminMessages.please_select_currency_code')}}</option>
                                        <option value="KWD">{{trans('adminMessages.kwd')}}</option>
                                        <option value="SAR">{{trans('adminMessages.sar')}}</option>
                                        <option value="USD">{{trans('adminMessages.usd')}}</option>
                                        <option value="BHD">{{trans('adminMessages.bhd')}}</option>
                                        <option value="EUR">{{trans('adminMessages.eur')}}</option>
                                        <option value="OMR">{{trans('adminMessages.omr')}}</option>
                                        <option value="QAR">{{trans('adminMessages.qar')}}</option>
                                        <option value="AED">{{trans('adminMessages.aed')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{trans('adminMessages.environment')}} </label>
                                    <select id="pgs_gateway_type" name="pgs_gateway_type" class="form-control" required>
                                        <option value="">{{trans('adminMessages.please_select_payment_environment')}} </option>
                                        <option value="production">{{trans('adminMessages.production')}} </option>
                                        <option value="sandbox">{{trans('adminMessages.sandbox')}} </option>
                                        <option value="test_env">{{trans('adminMessages.test')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <button type="reset"
                                            class="btn btn-danger">{{trans('adminMessages.reset')}} </button>
                                    <button type="submit"
                                            class="btn btn-primary">{{trans('adminMessages.save')}} </button>
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
