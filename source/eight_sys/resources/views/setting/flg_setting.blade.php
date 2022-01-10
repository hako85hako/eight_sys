        <table class="table text-center">
            <tr>
                <th class="text-center">ステータス</th>
                <th class="text-center">勤務フラグ</th>
                <th class="text-center">休暇フラグ</th>
                <th class="text-center">有給休暇フラグ</th>
                <th class="text-center"></th>
                <th class="text-center"></th>
            </tr>
            @foreach($status_items as $status_item)
                <tr>
                    <td>{{$status_item->status_name}}</td>
                    <td>
                        @if($status_item->work_flg == 1)
                            ✔︎ 
                        @else
                            
                        @endif    
                    </td>
                    <td>
                        @if($status_item->rest_flg == 1)
                            ✔︎ 
                        @else
                            
                        @endif   
                    </td>
                    <td>
                        @if($status_item->request_rest_flg == 1)
                            ✔︎ 
                        @else
                            
                        @endif   
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal_status{{$status_item->id}}">
                            編集
                        </button>
                        <!-- モーダル・ダイアログ -->
                        <div class="modal fade" id="Modal_status{{$status_item->id}}" tabindex="-1">
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
                                                <th class="text-center">ステータス</th>
                                                <th class="text-center">勤務フラグ</th>
                                                <th class="text-center">休暇フラグ</th>
                                                <th class="text-center">有給休暇フラグ</th>
                                                <th class="text-center"></th>
                                            </tr>
                                            <form action="/setting/{{$status_item->id}}" method="post" id="update_status{{$status_item->id}}">
                                                <input type="hidden" name="select" value="status">
                                                <input type="hidden" name="_method" value="PUT">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            </form>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="status_name" form="update_status{{$status_item->id}}" value="{{$status_item->status_name}}">
                                                </td>
                                                <td>
                                                    @if($status_item->work_flg == 1)
                                                        <input type="checkbox" class="form-check-input" name="work_flg" form="update_status{{$status_item->id}}" checked>
                                                    @else
                                                        <input type="checkbox" class="form-check-input" name="work_flg" form="update_status{{$status_item->id}}">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($status_item->rest_flg == 1)
                                                        <input type="checkbox" class="form-check-input" name="rest_flg" form="update_status{{$status_item->id}}" checked>
                                                    @else
                                                        <input type="checkbox" class="form-check-input" name="rest_flg" form="update_status{{$status_item->id}}">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($status_item->request_rest_flg == 1)
                                                        <input type="checkbox" class="form-check-input" name="request_rest_flg" form="update_status{{$status_item->id}}" checked>
                                                    @else
                                                        <input type="checkbox" class="form-check-input" name="request_rest_flg" form="update_status{{$status_item->id}}">
                                                    @endif
                                                </td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- モーダルフッター -->
                                    <div class="modal-footer">
                                        <button type="submit" form="update_status{{$status_item->id}}" class="btn btn-default" aria-label="Right Align">変更</button>
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

        <button type="button" class="btn btn-primary" form="create_status" data-toggle="modal" data-target="#Modal_status_create">
            新規作成
        </button>
                <!-- モーダル・ダイアログ -->
                <div class="modal fade" id="Modal_status_create" tabindex="-1">
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
                                <th class="text-center">ステータス</th>
                                <th class="text-center">勤務フラグ</th>
                                <th class="text-center">休暇フラグ</th>
                                <th class="text-center">有給休暇フラグ</th>
                                <th class="text-center"></th>
                            </tr>
                            <form action="/setting/create" method="get" id="create_status">
                                <input type="hidden" name="select" value="status">
                            </form>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="status_name" form="create_status">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input" name="work_flg" form="create_status">
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input" name="rest_flg" form="create_status">
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <!-- モーダルフッター -->
                    <div class="modal-footer">
                        <button type="submit" form="create_status" class="btn btn-default" aria-label="Right Align">作成</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>