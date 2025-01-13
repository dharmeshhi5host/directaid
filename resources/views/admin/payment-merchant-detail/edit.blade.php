@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">{{ config('languageString.edit_payment_merchant_detail') }}</h2>

            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                        @csrf
                        <input type="hidden" id="edit_value" name="edit_value" value="{{ $paymentMerchantDetail->id }}">
                        <input type="hidden" id="form-method" value="edit">
                        <div class="row row-sm">

{{--                            <div class="col-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="center_id">center_id<span class="error">*</span></label>--}}
{{--                                    <input type="number" class="form-control"--}}
{{--                                           name="center_id"--}}
{{--                                           id="center_id"--}}
{{--                                           value="{{ $paymentMerchantDetail->center_id }}"--}}
{{--                                           placeholder="center_id" required/>--}}
{{--                                    <div class="help-block with-errors error"></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="center_id">{{ config('languageString.center_id') }}<span class="error">*</span></label>--}}
{{--                                    <select class="form-control" name="center_id[]" id="center_id" multiple></select>--}}
{{--                                    <div class="help-block with-errors error"></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="center_id">{{ config('languageString.center_id') }}<span class="error">*</span></label>
                                    <select class="form-control" name="center_id[]" id="center_id" multiple>
                                        @foreach ($merchantCenters as $merchantCenter)
                                            <option value="{{ $merchantCenter->center_id }}" selected >
                                                {{ $merchantCenter->center_id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title">title<span class="error">*</span></label>
                                    <input type="text" class="form-control"
                                           name="title"
                                           id="title"
                                           value="{{ $paymentMerchantDetail->title }}"
                                           placeholder="title" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="merchant_id">merchant_id<span class="error">*</span></label>
                                    <input type="number" class="form-control"
                                           name="merchant_id"
                                           id="merchant_id"
                                           value="{{ $paymentMerchantDetail->merchant_id }}"
                                           placeholder="merchant_id" required/>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">description</label>
                                    <textarea class="form-control"
                                              name="description"
                                              id="description"
                                              placeholder="description">{{ $paymentMerchantDetail->description }}</textarea>
                                    <div class="help-block with-errors error"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-success">{{ config('languageString.submit') }}
                                        </button>
                                        <a href="{{ route('admin.payment-merchant-detail.index') }}"
                                           class="btn btn-secondary">{{ config('languageString.cancel') }}</a>
                                    </div>
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
    <script>
        $( document ).ready(function() {
            $("#center_id").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            })

            $('#center_id').on('select2:select', function(e) {
                const newValue = e.params.data.text;

                if (!/^\d+$/.test(newValue)) {
                    const $option = $("#center_id").find(`option[value="${newValue}"]`);
                    $option.remove();
                    $("#center_id").trigger('change');
                }
            });
        });
    </script>
    <script src="{{URL::asset('assets/js/custom/paymentMerchantDetail.js')}}?v={{ time() }}"></script>
@endsection
