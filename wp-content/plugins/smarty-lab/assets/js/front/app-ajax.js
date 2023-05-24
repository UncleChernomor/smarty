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

// document.addEventListener('DOMContentLoaded', () => {
//     document.addEventListener('submit', (e) => {
//         e.preventDefault();
//
//         console.log('run js');
//         const location = document.querySelector('select[name=smarty-location]');
//         const name = document.querySelector('input[name=smarty-lab-name]');
//         const coords = document.querySelector('input[name=smarty-lab-coords]');
//         const minFloor = document.querySelector('select[name=min-floor]');
//         const maxFloor = document.querySelector('select[name=max-floor]');
//         const typeBuilding = document.querySelector('select[type-building]');
//
//         console.dir(smarty_lab_ajax_data);
//         const params = {
//             method: 'POST',
//             body: new FormData(document.querySelector('#filter-form')),
//         };
//
//         console.dir(params);
//     //
//         fetch(smarty_lab_ajax_data.ajaxurl, params)
//             .then(response => {
//                 if (response.status === 200) {
//                     console.log('200 OK');
//                     console.dir(response);
//                     debugger;
//                     return response.formData();
//                 } else {
//                     throw new Error("Something went wrong on API server!");
//                 }
//             })
//             .then(answer => {
//                 console.log('answer OK');
//                 document.querySelector('#app').innerHTML = answer;
//             })
//             .catch(error => {
//                 console.log('error OK');
//                 console.log(error);
//             });
//     });
// });