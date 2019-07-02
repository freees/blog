
layui.use(['element'], function(){})

layui.use('layer', function(){
    var layer = layui.layer;
    $(document).on('click','#getAisle',function(){
        layer.msg('登录后才能跳转o(╥﹏╥)o',function() {
        })

    });
});


