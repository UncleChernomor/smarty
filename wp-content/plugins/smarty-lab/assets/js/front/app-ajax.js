'use strict';

document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const location = document.querySelector('select[name=smarty-location]');
        const name = document.querySelector('input[name=smarty-lab-name]');
        const coords = document.querySelector('input[name=smarty-lab-coords]');
        const minFloor = document.querySelector('select[name=min-floor]');
        const maxFloor = document.querySelector('select[name=max-floor]');
        const typeBuilding = document.querySelector('select[type-building]');

        console.dir(smarty_lab_ajax_data);
        const params = {
            method: 'POST',
            body: new FormData(document.querySelector('#filter-form')),
        };

        fetch(smarty_lab_ajax_data.ajaxurl, params)
            .then(response => {
                if (response.status === 200) {
                    return response.formData();
                } else {
                    throw new Error("Something went wrong on API server!");
                }
            })
            .then(answer => {
                document.querySelector('#app').innerHTML = answer;
            })
            .catch(error => {
                console.log(error);
            });

    });
});