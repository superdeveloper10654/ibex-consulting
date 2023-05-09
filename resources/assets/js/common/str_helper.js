/**
 * String helper
 */
let Str = {
    /**
     * Generate valid subdomain from raw string
     * @param {string} raw_str 
     * @returns {string}
     */
    subdomain: function(raw_str) {
        let str = raw_str.replace(/[^a-zA-Z0-9-_ ]/g, '')
                    .trim()
                    .slice(0, 62)
                    .toLowerCase();
        str = Str.replaceAll(str, ' ', '-');

        return _.trim(str, '-_');
    },

    /**
     * Replace all found occurrences in string with specific value
     * @param {string} str 
     * @param {string} replace_from 
     * @param {string} replace_to
     * @return {string}
     */
    replaceAll: function(str, replace_from, replace_to) {
        return str.split(replace_from).join(replace_to);
    }
};