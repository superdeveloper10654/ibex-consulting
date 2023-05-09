
// messages functional
toastr.options.extendedTimeOut = 10000;
toastr.options.timeout = 6000;
toastr.options.closeButton = true;

/**
 * Toastr error message
 * @param {string} msg
 * @param {string} title
 * @param {object} options
 */
function errorMsg(msg, title = '', options = {}) {
    toastr.error(msg, title, options)
}

/**
 * Toastr success message
 * @param {string} msg
 * @param {string} title
 * @param {object} options
 */
function successMsg(msg, title = '', options = {}) {
    toastr.success(msg, title, options);
}

/**
 * Toastr info message
 * @param {string} msg
 * @param {string} title
 * @param {object} options
 */
function infoMsg(msg, title = '', options = {}) {
    toastr.info(msg, title, options);
}