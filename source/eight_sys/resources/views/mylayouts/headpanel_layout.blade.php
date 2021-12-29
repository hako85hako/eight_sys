<div class="row">　</div>
<div class="row">
    <!--  ナビゲーション表示① -->
    <ul class="nav nav-tabs nav-justified">
    @if($target == 'attendance')
        <li class="active">
    @else
        <li>
    @endif
            <a href="javascript:moveAttendance.submit()">勤怠管理</a>
            <form action="attendance" method="get" name="moveAttendance">
                <input type="hidden" name="monitor" value="parameters">
            </form>
        </li>
    @if($target == 'requestRest')
        <li class="active">
    @else
        <li>
    @endif
            <a href="javascript:moveRequestRest.submit()">有給申請</a>
            <form action="requestRest" method="get" name="moveRequestRest">
                <input type="hidden" name="monitor" value="parameters">
            </form>
        </li>
        
        @if($user_detail->role=='manager'||$user_detail->role=='admin')
            @if($target == 'requestRestManagement')
                <li class="active">
            @else
                <li>
            @endif
                <a href="javascript:moveRequestRestManagement.submit()">有給管理</a>
                <form action="requestRestManagement" method="get" name="moveRequestRestManagement">
                    <input type="hidden" name="monitor" value="parameters">
                </form>
            </li>
            @if($target == 'aggregate')
                <li class="active">
            @else
                <li>
            @endif
                <a href="javascript:moveAggregate.submit()">集計</a>
                <form action="aggregate" method="get" name="moveAggregate">
                    <input type="hidden" name="monitor" value="parameters">
                </form>
            </li>
            @if($target == 'userDetail')
                <li class="active">
            @else
                <li>
            @endif
                <a href="javascript:moveUserDetail.submit()">社員管理</a>
                <form action="userDetail" method="get" name="moveUserDetail">
                    <input type="hidden" name="monitor" value="parameters">
                </form>
            </li>
            <li>
                <a href="javascript:moveNewUser.submit()">新規社員登録</a>
                <form action="#" method="get" name="moveNewUser">
                    <input type="hidden" name="monitor" value="parameters">
                </form>
            </li>
            @if($target == 'setting')
                <li class="active">
            @else
                <li>
            @endif
                <a href="javascript:moveSetting.submit()">勤務設定</a>
                <form action="setting" method="get" name="moveSetting">
                    <input type="hidden" name="monitor" value="parameters">
                </form>
            </li>
        @endif
    </ul>
</div>
<div class="row">　</div>
