

$(document).ready(function() {

    jQuery("a[class*=lightbox]").each(function(index,link) {
        if (link.href.split('#')[0] == (window.location.origin+window.location.pathname)) {
            link.href = "#" + link.href.split('#')[1];
        }
    });


});