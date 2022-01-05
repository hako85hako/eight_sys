
<html>
@extends('mylayouts/header_layout')
@section('content')
<div class="container">
    @include('mylayouts/headpanel_layout', ['target' => 'userCreate'])
    @include('userEdit/frame', ['mode' => 'store'])
</div>
    @endsection
</html>