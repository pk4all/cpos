//Dialog show event handler 
$('#confirmDelete').on('show.bs.modal', function (e) {
    $message = $(e.relatedTarget).attr('data-message');
    $(this).find('.modal-body p').text($message);
    $title = $(e.relatedTarget).attr('data-title');
    $(this).find('.modal-title').text($title);

    // Pass form reference to modal for submission on yes/ok
    var get_url = $(e.relatedTarget).attr('data-href');
    $(this).find('.modal-footer #confirm').data('body', get_url);
});

//Form confirm (yes/ok) handler, submits form
$('#confirmDelete').find('.modal-footer #confirm').on('click', function () {
    var url = $(this).data('body');
    window.location.href = url;
});



//// select all check box 
$('#selecctall').click(function (event) {
    if (this.checked) {
        $('.permission-checkbox').each(function () {
            this.checked = true;
        });
    } else {
        $('.permission-checkbox').each(function () {
            this.checked = false;
        });
    }
});

$(function(){
    $('.catname-lists ul li').click(function(){
     var current = $(this).index();
     $('.catname-lists ul li').removeClass('active');
     $('.catname-lists ul li').eq(current).addClass('active');

     $('.cat_description .tab-content .boxes').removeClass('active');
     $('.cat_description .tab-content .boxes').eq(current).addClass('active');
   });

    
    $(".cat_description .tab-content .boxes").mCustomScrollbar({
      axis:"x" ,
      scrollButtons:{
        enable:true
      }
    });
    
    $(".categories_list ul").mCustomScrollbar({
      scrollButtons:{
        enable:true
      }
    });
});
