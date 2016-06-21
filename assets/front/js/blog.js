(function ($) {
    var alert = $('#comment-form .reply-block');
    $('.comment-reply').click(function () {
        var commentId = $(this).data('id');
        var comment = $('#comment' + commentId);
        alert.find('.username').text(comment.find('.comment-user').first().text());
        alert.find('.message').text(comment.find('.comment-text').first().text());
        alert.addClass('active');
        $('#comment-parent_id').val(commentId);
        $("html, body").animate({scrollTop: $('#comment-form').offset().top}, "fast");
    });
    alert.find('.close').click(function(){
        $('#comment-parent_id').val(null);
        alert.removeClass('active');
    });
})(jQuery);