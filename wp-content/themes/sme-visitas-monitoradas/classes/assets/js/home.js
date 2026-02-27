jQuery(function () {
    jQuery(".carousel-cinemas").on("slide.bs.carousel", function (e) {
        var itemsPerSlide = parseInt(jQuery(this).attr('data-maximum-items-per-slide')),
            totalItems = jQuery(".carousel-item", this).length,
            reserve = 1,//do not change
            $itemsContainer = jQuery(".carousel-inner", this),
            it = (itemsPerSlide + reserve) - (totalItems - e.to);

        if (it > 0) {
            for (var i = 0; i < it; i++) {
                jQuery(".carousel-item", this)
                    .eq(e.direction == "left" ? i : 0)
                    // append slides to the end/beginning
                    .appendTo($itemsContainer);
            }
        }
    });
    jQuery(".carousel-museus").on("slide.bs.carousel", function (e) {
        var itemsPerSlide = parseInt(jQuery(this).attr('data-maximum-items-per-slide')),
            totalItems = jQuery(".carousel-item", this).length,
            reserve = 1,//do not change
            $itemsContainer = jQuery(".carousel-inner", this),
            it = (itemsPerSlide + reserve) - (totalItems - e.to);

        if (it > 0) {
            for (var i = 0; i < it; i++) {
                jQuery(".carousel-item", this)
                    .eq(e.direction == "left" ? i : 0)
                    // append slides to the end/beginning
                    .appendTo($itemsContainer);
            }
        }
    });
});