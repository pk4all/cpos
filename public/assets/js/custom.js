
$(function(){
  $('.categories_list ul li').click(function(){
   var current = $(this).index();
   $('.categories_list ul li').removeClass('active');
   $('.categories_list ul li').eq(current).addClass('active');

   $('.cat_description .brandtab_content').removeClass('active');
   $('.cat_description .brandtab_content').eq(current).addClass('active');
   $('.cat_description .tab-content .boxes:first-child').addClass('active');
  });

  $('.catname-lists .nav-tabs li').click(function(){
    var current = $(this).index();
	var current_tab = $('.categories_list ul li.active').index();
    $('.catname-lists .nav-tabs li').removeClass('active');
    $('.catname-lists .nav-tabs li').eq(current).addClass('active');

    $('.cat_description .tab-content .boxes').removeClass('active');
    $('.cat_description .brandtab_content:eq('+current_tab+') .tab-content .boxes').eq(current).addClass('active');
  });



  $(".categories_list ul").mCustomScrollbar({
     scrollButtons:{
       enable:true
     }
   });
});
