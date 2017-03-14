UE.registerUI('idialog',function(editor,uiName){

    //创建dialog
    idialog = new UE.ui.Dialog({
        //指定弹出层中页面的路径，这里只能支持页面,因为跟addCustomizeDialog.js相同目录，所以无需加路径
        iframeUrl:'/interest/top/interest_list',
        //需要指定当前的编辑器实例
        editor:editor,
        //指定dialog的名字
        name:uiName,
        //dialog的标题
        title:"选择兴趣",

        //指定dialog的外围样式
        cssRules:"width:600px;height:400px;",

        });

    //参考addCustomizeButton.js
    var btn = new UE.ui.Button({
        name:'dialogbutton' + uiName,
        title:'兴趣',
        //需要添加的额外样式，指定icon图标，这里默认使用一个重复的icon
        cssRules :'background-position: -600px 0;',
        onclick:function () {
            //渲染dialog
            idialog.render();
            idialog.open();
        }
    });

    return btn;
});



UE.registerUI('fdialog',function(editor,uiName){

    //创建dialog
    fdialog = new UE.ui.Dialog({
        //指定弹出层中页面的路径，这里只能支持页面,因为跟addCustomizeDialog.js相同目录，所以无需加路径
        iframeUrl:'/user/friend/friend_list',
        //需要指定当前的编辑器实例
        editor:editor,
        //指定dialog的名字
        name:uiName,
        //dialog的标题
        title:"选择朋友",

        //指定dialog的外围样式
        cssRules:"width:600px;height:400px;",
});

    //参考addCustomizeButton.js
    var btn = new UE.ui.Button({
        name:'dialogbutton' + uiName,
        title:'朋友',
        //需要添加的额外样式，指定icon图标，这里默认使用一个重复的icon
        cssRules :'background-position: -500px 0;',
        onclick:function () {
            //渲染dialog
            fdialog.render();
            fdialog.open();
        }
    });

    return btn;
});