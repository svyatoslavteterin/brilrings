$().ready(function(){

  $('.steps a').click(function(e){
    e.preventDefault();

    var step=$(this).data('step');
      store.state.step=step;

    $(this).parents('.steps').find('li').removeClass('active');
    $(this).parents('.steps').find('a[data-step="'+step+'"]').parent().addClass('active');
  });

});
