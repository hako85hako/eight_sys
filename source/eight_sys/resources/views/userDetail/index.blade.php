<html>
@extends('mylayouts/header_layout')
@section('content')
<div class="container">
    @include('mylayouts/headpanel_layout', ['target' => 'userDetail'])
        
    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
    		<table class="table text-center">
        		<tr>
                    <th class="text-center">氏名</th>
                    <th class="text-center">入社年月日</th>
                    <th class="text-center">所属1</th>
                    <th class="text-center">所属2</th>
                    <th class="text-center"></th>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->hire_date}}</td>
                        <td>
                            @foreach($department_items as $department_item)
                                @if($department_item->id == $user->department_id)
                                    {{$department_item->department_name_1}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($department_items as $department_item)
                                @if($department_item->id == $user->department_id)
                                    {{$department_item->department_name_2}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <form action="/userDetail/{{ $user->id }}/edit" method="get">
                                <button type="submit" class="btn btn-primary">
                                    詳細
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>


    @endsection
</html>