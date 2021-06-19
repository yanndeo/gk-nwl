/**
 * Shortcode to get Elt on the DOM
 *
 * @param x
 *
 * @returns {HTMLElement}
 */
export const getEltById = (x) => document.getElementById(x) ;

/**
 * @arr array you want to listen to
 * @callback function that will be called on any change inside array
 * @param myEventsQ
 * @param processQ
 */
export const listenChangeOnArray = (myEventsQ, processQ) => {
    myEventsQ.push = function() {
        Array.prototype.push.apply(this, arguments);  processQ();
    };
}
