
<html>
@extends('mylayouts/header_layout')
@section('content')
<div class="container">
    @include('mylayouts/headpanel_layout', ['target' => 'userEdit'])
    @include('userEdit/frame', ['mode' => 'update'])
</div>
    @endsection
</html>