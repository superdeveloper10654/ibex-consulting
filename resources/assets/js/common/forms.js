jQuery($ => {
    /**
     * Prevent forms autofilling
     */
    if ($('form[do-not-autofill]').length) {
        let i_counter = 0;
        let interval = setInterval(() => {
            $('form[do-not-autofill] input:-internal-autofill-selected').each((i, el) => {
                $(el).val('');
            });

            if (i_counter >= 500) {
                clearInterval(interval);
            }

            i_counter++;
        }, 10);
    }

    $(document).on('change input select', '.is-invalid', function(e) {
        if (this.tagName == 'SELECT' && e.type == 'change') { // fix bug of cascading selects update
            return ;
        }

        $(this).removeClass('is-invalid');
        $(this).nextAll('[data-error]').text('');
    });
});

/**
* Add errors for elements by data-error attribute
* @param {jQuery} form to append errors to 
* @param {object} res of response from server
*/
function addFormErrors(form, res) {
    for (let key in res.responseJSON.errors) {
        // for arrays returned dotted notation - need to format it to array
        let key_arr = key.split('.');

        if (key_arr.length > 1) {
            key_arr = key_arr.map((item, i) => {
                return i == 0 ? item : `[${item}]`;
            });
        }
        key = key_arr.join('');

        let elem = $(form).find(`[name='${key}']`);
        elem.addClass('is-invalid');
        elem.nextAll('[data-error]').text(res.responseJSON.errors[key]);
    }
}

/**
 * Remove texts from form elements by data-error attribute
 * 
 * @param {object} form
 */
function removeFormErrors(form) {
    let elems = $(form).find('input.is-invalid, select.is-invalid, textarea.is-invalid');
    elems.removeClass('is-invalid');
    elems.nextAll('[data-error]').text('');
}

/**
 * Show validation errors from backend JSON response if any
 * @param {object} post_result result returned by jquery post function
 * @return {void}
 */
function showValidationErrors(post_result) {
    if (typeof post_result.responseJSON.errors !== 'undefined') {
        for (let key in post_result.responseJSON.errors) {
            errorMsg(post_result.responseJSON.errors[key]);
        }
    } else {
        errorMsg(post_result.responseJSON.message);
    }
}