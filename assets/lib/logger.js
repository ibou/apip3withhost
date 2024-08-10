
export default class Logger
{
    _debug;

    /**
     * @param debug boolean
     */
    constructor(debug) {
        this._debug = debug;
    }

    debug(data) {
        if (!this._debug) {
            return false;
        }

        console.debug(data);
        return true;
    }
}
