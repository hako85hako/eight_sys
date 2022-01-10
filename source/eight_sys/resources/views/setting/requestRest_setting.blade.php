        <table class="table text-center">
            <tr>
                <th class="text-center">勤続年数</th>
                <th class="text-center">付与日数</th>
                <th class="text-center">有効</th>
                <th class="text-center"></th>
                <th class="text-center"></th>
            </tr>
            @foreach($requestRest_settings as $requestRest_setting)
                <tr>
                    <td>{{$requestRest_setting->pass_date}}</td>
                    <td>{{$requestRest_setting->give_date}}</td>
                    <td>
                        @if($requestRest_setting->active_flg == 1)
                            ✔︎ 
                        @else
                            
                        @endif   
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal_requestRest{{$requestRest_setting->id}}">
                            編集
                        </button>
                        <!-- モーダル・ダイアログ -->
                        <div class="modal fade" id="Modal_requestRest{{$requestRest_setting->id}}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- モーダルヘッダー -->
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                                        <h4 class="modal-title"></h4>
                                    </div>
                                    <!-- モーダル本文 -->
                                    <div class="modal-body">
                                        <table class="table text-center">
                                            <tr>
                                                <th class="text-center">勤続年数</th>
                                                <th class="text-center">付与日数</th>
                                                <th class="text-center">有効</th>
                                                <th class="text-center"></th>
                                                <th class="text-center"></th>
                                            </tr>
                                            <form action="/companyRequestRestSetting/{{$requestRest_setting->id}}" method="post" id="update_requestRest{{$requestRest_setting->id}}">
                                                <input type="hidden" name="_method" value="PUT">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            </form>
                                            <tr>
                                                <td>                                                   
                                                    <select class="form-control" name='pass_date' form="update_requestRest{{$requestRest_setting->id}}">
                                                        @for ($i = 0; $i < 10; $i += 0.5)
                                                            @if($i == $requestRest_setting->pass_date)
                                                                <option selected>{{$i}}</option>
                                                            @else
                                                                <option>{{$i}}</option>
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name='give_date' form="update_requestRest{{$requestRest_setting->id}}">
                                                        @for ($i = 20; $i > 0; $i -= 1)
                                                            @if($i == $requestRest_setting->give_date)
                                                                <option selected>{{$i}}</option>
                                                            @else
                                                                <option>{{$i}}</option>
                                                            @endif
                                                        @endfor
                                                    </select>
                                                </td>
                                                <td>
                                                    @if($requestRest_setting->active_flg == 1)
                                                        <input type="checkbox" class="form-check-input" name="active_flg" form="update_requestRest{{$requestRest_setting->id}}" checked>
                                                    @else
                                                        <input type="checkbox" class="form-check-input" name="active_flg" form="update_requestRest{{$requestRest_setting->id}}">
                                                    @endif
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- モーダルフッター -->
                                    <div class="modal-footer">
                                        <button type="submit" form="update_requestRest{{$requestRest_setting->id}}" class="btn btn-default" aria-label="Right Align">変更</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                   
                    <td></td>
                </tr>
            @endforeach
        </table>

        <button type="button" class="btn btn-primary" form="create_requestRest" data-toggle="modal" data-target="#Modal_requestRest_create">
            新規作成
        </button>
        <!-- モーダル・ダイアログ -->
        <div class="modal fade" id="Modal_requestRest_create" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- モーダルヘッダー -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <!-- モーダル本文 -->
                    <div class="modal-body">
                        <table class="table text-center">
                                <tr>
                                    <th class="text-center">勤続年数</th>
                                    <th class="text-center">付与日数</th>
                                    <th class="text-center">有効</th>
                                </tr>
                            <form action="/companyRequestRestSetting/create" method="get" id="create_requestRest">
                                
                            </form>
                            <tr>
                                <td>                                                   
                                    <select class="form-control" name='pass_date' form="create_requestRest">
                                        @for ($i = 0; $i < 10; $i += 0.5)
                                            <option>{{$i}}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name='give_date' form="create_requestRest">
                                        @for ($i = 20; $i > 0; $i -= 1)
                                            <option>{{$i}}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input" name="active_flg" form="create_requestRest" checked>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- モーダルフッター -->
                    <div class="modal-footer">
                        <button type="submit" form="create_requestRest" class="btn btn-default" aria-label="Right Align">作成</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>