            <table class="table text-center">
        		<tr>
                    <th class="text-center">所属1</th>
                    <th class="text-center">所属2</th>
                    <th class="text-center"></th>
                </tr>
                @foreach($department_items as $department_item)
                    <tr>
                        <td>{{$department_item->department_name_1}}</td>
                        <td>{{$department_item->department_name_2}}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal_departments{{$department_item->id}}">
                                編集
                            </button>
                            <!-- モーダル・ダイアログ -->
                            <div class="modal fade" id="Modal_departments{{$department_item->id}}" tabindex="-1">
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
                                                    <th class="text-center">所属1</th>
                                                    <th class="text-center">所属2</th>
                                                    <th class="text-center"></th>
                                                </tr>
                                                <form action="/setting/{{$department_item->id}}" method="post" id="update_department{{$department_item->id}}">
                                                    <input type="hidden" name="select" value="department">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                </form>
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control" name="department_name_1" form="update_department{{$department_item->id}}" value="{{$department_item->department_name_1}}">  
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="department_name_2" form="update_department{{$department_item->id}}" value="{{$department_item->department_name_2}}">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!-- モーダルフッター -->
                                        <div class="modal-footer">
                                            <button type="submit" form="update_department{{$department_item->id}}" class="btn btn-default" aria-label="Right Align">変更</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
            <button type="button" class="btn btn-primary" form="create_department" data-toggle="modal" data-target="#Modal_departments_create">
                新規作成
            </button>
            <!-- モーダル・ダイアログ -->
            <div class="modal fade" id="Modal_departments_create" tabindex="-1">
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
                                    <th class="text-center">所属1</th>
                                    <th class="text-center">所属2</th>
                                    <th class="text-center"></th>
                                </tr>
                                <form action="/setting/create" method="get" id="create_department">
                                    <input type="hidden" name="select" value="department">
                                </form>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" name="department_name_1" form="create_department">  
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="department_name_2" form="create_department">
                                    </td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <!-- モーダルフッター -->
                        <div class="modal-footer">
                            <button type="submit" form="create_department" class="btn btn-default" aria-label="Right Align">作成</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                        </div>
                    </div>
                </div>
            </div>