export const func = {
    /**
     * Формат телефона 80000000000
     * @param val
     * @returns {string}
     * @constructor
     */
    MaskPhone: (val) => {
        if (val.length === 1) {
            if (val === '+') val = '8';
            if (val !== '8') val = '';
        }
        if (val.length > 1 && val.length < 12) {
            if (val.slice(-1).match(/\d+/g) === null)
                val = val.substring(0, val.length - 1);
        }
        if (val.length >= 12) val = val.substring(0, val.length - 1);
        return val;
    },
    /**
     * Формат логина - латиница и цифры
     * @param val
     * @returns {string}
     * @constructor
     */
    MaskLogin: (val) => {
        let last = val.slice(-1);
        if (last.match(/\d+/g) === null && last.match(/[a-z]/i) === null) {
            val = val.substring(0, val.length - 1);
        }
        return val;
    },
    MaskSlug: (val) => {
        let last = val.slice(-1);
        if (last.match(/\d+/g) === null && last.match(/[a-z\-_]/g) === null) {
            val = val.substring(0, val.length - 1);
        }
        return val;
    },
}
