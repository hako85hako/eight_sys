
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
        	@if($mode == 'store')
            <form action="/userDetail" method="post">
            @elseif($mode == 'update')
            <form action="/userDetail/{{ $edit_user_detail->id }}" method="post">
                <input type="hidden" name="user_id" value="{{ $edit_user_detail->user_id }}">
                <input type="hidden" name="_method" value="PUT">
            @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="name">Name</label>
                    @if($mode == 'store')
                	    <input type="text" class="form-control" name="name">
                    @elseif($mode == 'update')
                        <input type="text" class="form-control" name="name" value="{{$edit_user_detail->name}}">
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    @if($mode == 'store')
                	    <input type="text" class="form-control" name="email">
                    @elseif($mode == 'update')
                        <input type="text" class="form-control" name="email" value="{{$userEmail}}">
                    @endif
                </div>
                <label for="hire_year">Hire date</label>
                <div class="form-group row">   
                    @if($mode == 'store')
                        <div class='col-sm-6 col-xs-12'>
                            <input type="date" class="form-control" name="hire_date">
                        </div>
                    @elseif($mode == 'update')
                        <div class='col-sm-6 col-xs-12'>
                            <input type="date" class="form-control" name="hire_date" value="{{$edit_user_detail->hire_date}}">
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="department">department</label>
                    <select class="form-control" name="department">
                    @if($mode == 'store')
                        <option selected></option>
                        @foreach($department_items as $department_item)
                            <option value='{{$department_item->id}}'>{{$department_item->department_name_1}}  {{$department_item->department_name_2}}</option>               
                        @endforeach
                    @elseif($mode == 'update')
                        @if($edit_user_detail->department_id=="")
                                <option selected></option>
                        @endif
                        @foreach($department_items as $department_item)
                            @if($department_item->id == $edit_user_detail->department_id)
                                <option selected value='{{$department_item->id}}'>{{$department_item->department_name_1}}  {{$department_item->department_name_2}}</option>               
                            @else
                                <option value='{{$department_item->id}}'>{{$department_item->department_name_1}}  {{$department_item->department_name_2}}</option>               
                            @endif
                        @endforeach
                    @endif
                    </select>
                </div>
                
                <div class="form-group">
                    @if($mode == 'store')
                        <button type="submit" class="btn btn-default">登録</button>
                        <button type="submit" form="nonPush" class="btn btn-default">登録せずに戻る</button>
                    @elseif($mode == 'update')
                        <button type="submit" class="btn btn-default">保存</button>
                        <button type="submit" form="nonPush" class="btn btn-default">保存せずに戻る</button>
                    @endif
                </div>
            </form>
            <form action="/userDetail" id="nonPush" method="get"></form>
        </div>
    </div>