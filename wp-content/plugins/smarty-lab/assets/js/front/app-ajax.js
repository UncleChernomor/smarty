jQuery(document).ready(function ($) {
    getData();

    $('#filter-form').on('submit', function (event) {
        event.preventDefault();
        getData(this);
    })

    console.log('hi');
    console.dir($('.real-estate__box a'));

    function getData(formInstance) {
        $.ajax({
            url: smartyLabAjaxData.ajaxurl,
            type: 'POST',
            data: {
                'action': 'show_real_estate',
                'nonce': smartyLabAjaxData.nonce,
                'form-data': $(formInstance).serialize(),
            },
            success: function (data) {
                const realEstateBox = $('.real-estate__box');
                realEstateBox.children().remove();
                realEstateBox.append(data);

                getDataPagination();

            },
            error: function (error) {

            }
        });
    }

    function getDataPagination() {
        $('.real-estate__box a.page-numbers').on('click', function (event) {
            event.preventDefault();
            $.ajax({
                url: smartyLabAjaxData.ajaxurl,
                type: 'POST',
                data: {
                    'action': 'show_real_estate',
                    'nonce': smartyLabAjaxData.nonce,
                    'paged': this.search.slice(-1),
                    'form-data': $('#filter-form').serialize(),
                },
                success: function (data) {
                    const realEstateBox = $('.real-estate__box');
                    realEstateBox.children().remove();
                    realEstateBox.append(data);

                    getDataPagination();

                },
                error: function (error) {

                }
            });
        });
    }
});