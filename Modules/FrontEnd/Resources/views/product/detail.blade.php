@extends('frontend::layouts.master')
@section('css')
    <style type="text\css">
        .animated {
            -webkit-transition: height 0.2s;
            -moz-transition: height 0.2s;
            transition: height 0.2s;
        }

        .stars
        {
            margin: 20px 0;
            font-size: 24px;
            color: #d17581;
        }
    </style>
@endsection
@section('content')
    <detail-sanpham-fe></detail-sanpham-fe>
@endsection
