/*******************************************************************************
 * Copyright (c) 2018, WP Popup Maker
 ******************************************************************************/

(function ($) {
    "use strict";

    /**
     * Gets a url from the trigger or its children.
     *
     * @returns string|boolean
     */
    function trigger_link($trigger) {
        var _$trigger = $trigger,
            link = false;

        if ($trigger === false || !$trigger.length) {
            return false;
        }

        if (!_$trigger.is('a[href]')) {
            if (_$trigger.find('a[href]').length) {
                _$trigger = _$trigger.find('a[href]');
            } else {
                _$trigger = false;
            }
        }

        if (_$trigger) {
            link = _$trigger.prop('href');
        }

        return link;
    }

    $(document)
        /** Close the parent popup on continue link click. */
        .on('click', '.pum-continue-link a, .popmake-continue-link a', function () {
            PUM.close(this);
        })
        .on('pumBeforeOpen', '.pum.leaving-notice', function () {
            var $popup = PUM.getPopup(this),
                url = '#',
                $trigger = false;

            try {
                $trigger = $($.fn.popmake.last_open_trigger);
                url = trigger_link($trigger);
            } catch (error) {
                $trigger = false;
            }

            /** Prevent the popup from reopening if its already open. */
            if ($popup.has($trigger).length) {
                $popup.addClass('preventOpen');
            }

            $popup.find('.pum-continue-link a, .popmake-continue-link a').prop('href', url);
        });
}(window.jQuery));