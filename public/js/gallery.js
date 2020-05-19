$(document).ready(function(){
    $('.gallery-tag').click(function(){
        var tag = $(this).attr('data-tag');
        var title = $(this).attr('data-title');
        
        $('.list-group-item').removeClass('active');
        $(this).parent().addClass('active');
        
        $('#galleryBox').addClass('hidden');
        $('#loadingBox').removeClass('hidden');
        
        $('#tagTitle').html(title + ' Photo Gallery');
        
        $.ajax({
            url: '/photo_gallery/tag/' + tag,
            type: 'GET',
            success: function(data){
                $('#loadingBox').addClass('hidden');
                
                $('#galleryBox').html(data);
                $('#galleryBox').removeClass('hidden');
            }
        });
    });
});