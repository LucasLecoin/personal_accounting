// $('.js-submit-on-change').on('change', function(e) {
//     let $form = $(e.currentTarget).parents('form');
//     $form.submit();
//     console.log($form);
// })
import __ from './_ymnnjq.js';

console.log(__);
__.on('change', '.js-submit-on-change', function(e) {
    let form = __.parents(e.currentTarget, 'form');
    if(form[0]) {
        form[0].submit();
    }
});