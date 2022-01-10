<html>
@extends('mylayouts/header_layout')
@section('content')
<div class="container">
    @include('mylayouts/headpanel_layout', ['target' => 'setting'])
    <details open>
        <summary>勤務状態設定</summary>
        @include('setting/flg_setting')
    </details>
    
    <!-- 幅調整 -->
    <div class="row">　</div>

    <details>
        <summary>所属設定</summary>
        @include('setting/department_setting')
    </details>

    <!-- 幅調整 -->
    <div class="row">　</div>

    <details>
        <summary>有給休暇付与設定</summary>
        @include('setting/requestRest_setting')
    </details>
	
    @endsection
</html>