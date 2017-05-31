<div class="panel panel-warning">
    <!-- panel heading -->
            <ol class="breadcrumb">
        <li class="active">修改密码</li>
        </ol>
    <!-- panel body -->
    <div class="panel-body main">
        <div class="row">
            <form class="form-inline">
                <div class="col-sm-10 col-md-10 col-lg-10">
                    用户名<input type="text" class="form-control" id="username" name="username" disabled value="<?php echo Yii::$app->user->identity->username;?>">
                    <input type="hidden" class="form-control" id="auid" name="auid" disabled value="<?php echo Yii::$app->user->identity->id;?>"/>
                    原密码<input type="password" class="form-control" id="oldpassword" name="oldpassword"/>
                    新密码<input type="password" class="form-control" id="newpassword" name="newpassword"/>

                    <button class="btn btn-primary"  id="btn_submit">
                        <span class="glyphicon glyphicon-search"></span>
                        <span>提交</span>
                    </button>&nbsp;
                </div>
             <form>
        </div>
    </div>
    <!-- panel footer -->
    <div class="panel-footer">
    </div>
</div>

<!-- ------------------------------------------------------------------------javascript---------------------------------------------------------------------->
<script src="/js/sdk/alert.js"></script>
<script src="/js/sdk/util.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

    });


    $('#btn_submit').on('click', (function(event){
        event.preventDefault();
        var error_num = validInput();
        if(error_num == 0) {
            $('#btn_submit').attr('disabled', true);
            var url = '/modify-password/modify-password';
            var data = {
                'auid' : $('#auid').val(),
                'oldpassword' : $('#oldpassword').val(),
                'newpassword' : $('#newpassword').val()
            };

            var method = 'get';
            var successFunc = function (result) {
                if (parseInt(result) == 1) {
                    alert(MESSAGE_MODIFY_SUCCESS);
                } else if (parseInt(result) == 0) {
                    alert(MESSAGE_MODIFY_ERROR);
                } else if(parseInt(result) == -1){
                    alert('修改失败！原密码错误');
                }
                $('#oldpassword').val('');
                $('#newpassword').val('');
                $('#btn_submit').attr('disabled', false);
            };
            callAjaxWithFunction(url, data, successFunc, method);
        }
    }));


    function validInput(){
        var error_num = 0;
        var oldpassword = $('#oldpassword').val();
        var newpassword = $('#newpassword').val();
        if(oldpassword == '' ){
            error_num +=1;
            alert('请填写原密码');
        }else if(newpassword == ''){
            error_num +=1;
            alert('请填写新密码');
        }
        return error_num;
    }
</script>