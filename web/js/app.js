var nv = nv || {};

nv.EmployeeAPI = function () {
    'use strict';

    /**
     * @class
     * @param {object} options
     */
    function EmployeeAPI(options) {
        this.init(options);
    };

    EmployeeAPI.DEFAULTS = {
        index: {
            url: 'api/employees',
            method: 'GET'
        }
    };

    EmployeeAPI.prototype = {
        /**
         * @param {object} options
         */
        init: function (options) {
            this.options = $.extend({}, EmployeeAPI.DEFAULTS, options);
        },

        /**
         * @param {string} expression
         */
        fetchEmployeesBy: function (condition) {

            return $.ajax({
                type: this.options.index.method,
                url: this.options.index.url,
                data: condition,
            });
        }
    };

    return EmployeeAPI;
}();

