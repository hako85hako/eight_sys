<html>
@extends('mylayouts/header_layout')
@section('content')
<div class="container">
    @include('mylayouts/headpanel_layout', ['target' => 'attendance'])
	<div class="row">
    <!-- 月の設定 -->
        <div class="form-group row">
            <div class='col-sm-1 col-xs-3'>
                <button class='form-control' type="submit" class="btn btn-xs bg-transparent" form='back_month' aria-label="Left Align"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button>
            </div>
            <div class='col-sm-3 col-xs-6'>
                <input class='form-control' type="month" name="select_month" value={{$month_inf}} form='select_month' onchange="selectMonthChange()">
            </div>
            <div class='col-sm-1 col-xs-3'>
                <button class='form-control' type="submit" class="btn btn-xs bg-transparent" form='next_month' aria-label="Left Align"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>
            </div>
            <form action="/attendance"  method="get" id='select_month'></form>
            <form action="/attendance"  method="get" id='next_month'><input type='hidden' name='move_month' value='next'><input type="hidden" name="select_month" value={{$month_inf}}></form>
            <form action="/attendance"  method="get" id='back_month'><input type='hidden' name='move_month' value='back'><input type="hidden" name="select_month" value={{$month_inf}}></form>
        </div>
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
    		<table class="table text-center">
        		<tr>
                    <th class="text-center">月日</th>
                    <th class="text-center">出勤状況</th>
                    <th class="text-center">労働時間</th>
                    <th class="text-center"></th>
                </tr>
                @foreach($date_items as $date_item)
                    @if($date_item[2]== 'error')
                    <tr class="bg-danger">
                    @else
                    <tr>
                    @endif
                        <td>{{$date_item[0]}}</td>
                        <td>{{$date_item[2]}}</td>
                        <td>{{$date_item[3]}}</td>
                        <td>
                            @if($month_inf>=$date_item[7])
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal{{$date_item[1]}}">
                                    登録
                                </button>
                            @endif
                            <!-- モーダル・ダイアログ -->
                            <div class="modal fade" id="Modal{{$date_item[1]}}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                                            <h4 class="modal-title">{{$date_item[0]}}</h4>
                                        </div>
                                        <!-- モーダル本文 -->
                                        @if($date_item[5] == '-')
                                            <div class="modal-body">
                                            @if($month_inf>=$date_item[7])
                                                <div class="form-group row">
                                                    <label for="status_items{{$date_item[1]}}" class="col-sm-3 col-form-label">ステータス</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name='status_item' id="status_items{{$date_item[1]}}" form="create{{$date_item[1]}}">
                                                        @foreach($status_items as $status_item)
                                                            <option value="{{$status_item->id}}">{{$status_item->status_name}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="start_time_items{{$date_item[1]}}" class="col-sm-3 col-form-label">開始時間</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name='start_time_item' id="start_time_items{{$date_item[1]}}" form="create{{$date_item[1]}}">
                                                        @foreach($time_items as $time_item)
                                                            <option>{{$time_item}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>  
                                                </div>
                                                <div class="form-group row">
                                                    <label for="stop_time_items{{$date_item[1]}}" class="col-sm-3 col-form-label">終了時間</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name='stop_time_item' id="stop_time_items{{$date_item[1]}}" form="create{{$date_item[1]}}">
                                                        @foreach($time_items as $time_item)
                                                            <option>{{$time_item}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>  
                                                </div>
                                                <form action="/attendanceDetail/create" method="get" id="create{{$date_item[1]}}">
                                                    <input type="hidden" name="date" value="{{$date_item[1]}}">
                                                </form>
                                            @else
                                                <div>データなし</div>
                                            @endif
                                            </div>
                                        @else
                                            <!-- すでに登録がある場合 -->
                                             <div class="modal-body">
                                                @if($month_inf>=$date_item[7])
                                                    <div class="form-group row">
                                                        <label for="status_items{{$date_item[1]}}" class="col-sm-3 col-form-label">ステータス</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" name='status_item' id="status_items{{$date_item[1]}}" form="create{{$date_item[1]}}">
                                                            @foreach($status_items as $status_item)
                                                                <option value="{{$status_item->id}}">{{$status_item->status_name}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="start_time_items{{$date_item[1]}}" class="col-sm-3 col-form-label">開始時間</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" name='start_time_item' id="start_time_items{{$date_item[1]}}" form="create{{$date_item[1]}}">
                                                            @foreach($time_items as $time_item)
                                                                <option>{{$time_item}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>  
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="stop_time_items{{$date_item[1]}}" class="col-sm-3 col-form-label">終了時間</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" name='stop_time_item' id="stop_time_items{{$date_item[1]}}" form="create{{$date_item[1]}}">
                                                            @foreach($time_items as $time_item)
                                                                <option>{{$time_item}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>  
                                                    </div>
                                                    <form action="/attendanceDetail/create" method="get" id="create{{$date_item[1]}}">
                                                        <input type="hidden" name="attendance_id" value="{{$date_item[5]}}">
                                                        <input type="hidden" name="date" value="{{$date_item[1]}}">
                                                    </form>
                                                @endif
                                                    <table class="table text-center">
                                                        <tr>
                                                            <th class="text-center">勤務状態</th>
                                                            <th class="text-center">開始</th>
                                                            <th class="text-center">終了</th>
                                                            <th class="text-center"></th>
                                                        </tr>
                                                        @foreach($date_item[6] as $attendance_detail)
                                                        <form action="/attendanceDetail/{{$attendance_detail->id}}" method="post" id="delete{{$attendance_detail->id}}">
                                                            <input type="hidden" name="_method" value="PUT">
                                                            <input type="hidden" name="attendance_id" value="{{$date_item[5]}}">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        </form>
                                                            <tr>
                                                                <td>
                                                                    @foreach($status_items as $status_item)
                                                                        @if($attendance_detail->status == $status_item->id)
                                                                            {{$status_item->status_name}}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                                <td>{{$attendance_detail->start_time}}</td>
                                                                <td>{{$attendance_detail->stop_time}}</td>
                                                                <td>
                                                                    <button type="submit" class="btn btn-danger" form="delete{{$attendance_detail->id}}">削除</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                @endif
                                            </div>
                                        @if($month_inf>=$date_item[7])
                                        <div class="modal-footer">
                                            <button type="submit" form="create{{$date_item[1]}}" class="btn btn-default" aria-label="Right Align">登録</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
		</div>
    </div>
    @endsection
</html>