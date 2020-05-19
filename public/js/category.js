$(document).ready(function(){
    $('.delete-category').click(function(){
        if (confirm('Are you sure?')) {
            $.ajax({
                url: '/category/delete/'+$(this).attr('data-id'),
                type: 'DELETE',
                success: function(){
                    window.location.reload();
                }
            });
        }
    });
});