$("#logout").click(function() {
	$.post("/login/logout",function(data){
	    var result = $.parseJSON(data);
	    if(result.errNo==0) {
			alertify.success('退出成功');
			//跳转
			location.href='/';
		}else {
			alertify.error(result.errMsg);
		}
	});
});
$('.form-group').on('focus', '.form-control', function () {
    $(this).closest('.input-group, .form-group').addClass('focus');
  }).on('blur', '.form-control', function () {
    $(this).closest('.input-group, .form-group').removeClass('focus');
  });

function uploadImg() {
	var $ = jQuery,
    $list = $('#thelist'),
    $btn = $('#ctlBtn'),
    state = 'pending',
    ratio = window.devicePixelRatio || 1,

    // 缩略图大小
    thumbnailWidth = 590 * ratio,
    thumbnailHeight = 300 * ratio,
    
    uploader;

uploader = WebUploader.create({
	 // 自动上传。
    auto: true,
    
    // 不压缩image
    resize: false,
    
    // swf文件路径
    swf: '/js/Uploader.swf',

    // 文件接收服务端。
    server: '/upload/img',

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#picker',
    //fileNumLimit: 1, 
 // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
    }
});

uploader.on( 'fileQueued', function( file ) {
    var $li = $(
            '<div id="' + file.id + '">' +
                '<img>' +
            '</div>'
            ),
        $img = $li.find('img');
    $list.html( $li );

    // 创建缩略图
    uploader.makeThumb( file, function( error, src ) {
        if ( error ) {
            $img.replaceWith('<span>不能预览</span>');
            return;
        }

        $img.attr( 'src', src );
    }, thumbnailWidth, thumbnailHeight );

});

// 文件上传过程中创建进度条实时显示。
uploader.on( 'uploadProgress', function( file, percentage ) {
    var $li = $( '#'+file.id ),
        $percent = $li.find('.progress .progress-bar');

    // 避免重复创建
    if ( !$percent.length ) {
        $percent = $('<div class="progress progress-striped active">' +
          '<div class="progress-bar" role="progressbar" style="width: 0%">' +
          '</div>' +
        '</div>').appendTo( $li ).find('.progress-bar');
    }

    $li.find('p.state').text('上传中');

    $percent.css( 'width', percentage * 100 + '%' );
});

uploader.on( 'uploadSuccess', function( file,response ) {
    var data =  $.parseJSON(response._raw);
	if(data.errNo==0) {
    	$("#picture").val(data.path);
		//$list.append("<input type=hidden id=picture value="+data.path+">");
    }else {
    	$( '#'+file.id ).find('p.state').text('上传出错,请重试');
    }
    
});

uploader.on( 'uploadError', function( file ) {
    $( '#'+file.id ).find('p.state').text('上传出错');
});

uploader.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').fadeOut();
});

uploader.on( 'all', function( type ) {
    if ( type === 'startUpload' ) {
        state = 'uploading';
    } else if ( type === 'stopUpload' ) {
        state = 'paused';
    } else if ( type === 'uploadFinished' ) {
        state = 'done';
    }

    if ( state === 'uploading' ) {
        $btn.text('暂停上传');
    } else {
        $btn.text('开始上传');
    }
});

$btn.on( 'click', function() {
    if ( state === 'uploading' ) {
        uploader.stop();
    } else {
        uploader.upload();
    }
});
}