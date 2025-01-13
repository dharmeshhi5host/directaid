@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">Dashboard</h2>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    



@endsection
@section('js')
    <script>
        var options = "";
        var option = "";
        var userVehicle = "";
        var user = "";
        var chart = "";
    </script>

    <script src="{{asset('assets/js/apexcharts.js')}}"></script>
    <script src="{{asset('assets/js/custom/index.js')}}"></script>
    <script src="{{asset('assets/js/custom/userChart.js')}}"></script>
@endsection
