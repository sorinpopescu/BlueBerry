// BlueBerry Scripts
$(document).ready(function() {
    // Alter register link
    $('.login a').each(function() {
        if ($(this).attr('href') === '/register') {
            $(this).attr('href') = 'customer-register';
        };
    });
});