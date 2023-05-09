toastr.options = {
    closeButton     : true,
    extendedTimeOut : 10000,
    newestOnTop     : true,
    timeout         : 6000,
};

let Notif = {
    /**
     * Toastr error message
     * @param {string} msg
     * @param {string} title
     * @param {object} options
     */
    error: function(msg, title = '', options = {}) {
        toastr.error(msg, title, options)
    },

    /**
     * Toastr info message
     * @param {string} msg
     * @param {string} title
     * @param {object} options
     */
    info: function(msg, title = '', options = {}) {
        toastr.info(msg, title, options);
    },

    /**
     * Toastr success message
     * @param {string} msg
     * @param {string} title
     * @param {object} options
     */
    success: function(msg, title = '', options = {}) {
        toastr.success(msg, title, options);
    },
};