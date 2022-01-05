<html>
@extends('mylayouts/header_layout')
@section('content')
<div class="container">
    @include('mylayouts/headpanel_layout', ['target' => 'requestRest'])
    @endsection
</html>