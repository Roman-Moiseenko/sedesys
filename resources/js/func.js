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
    MaskInteger: (val, max = 999) => {
        let last = val.slice(-1);
        if (last.match(/\d+/g) === null || val.length > max) {
            val = val.substring(0, val.length - 1);
        }
        return val;
    },
    MaskFloat: (val) => {
        let last = val.slice(-1);
        if (last.match(/\d+/g) === null && last.match(/\./g) === null) {
            val = val.substring(0, val.length - 1);
        }
        return val;
    },
    fullName: (val) => {
        return val.surname + ' ' + val.firstname + ' ' + val.secondname;
    },
    price: (val) => {
        if (val === null || val === '' || val === 0) return '';
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + '  ₽';
    },
    experience: (val) => {
        if (val === null || val === 0) return '';
        let year = new Date().getFullYear() - val;
        let div = year % 10;
        if (year === 0) return 'менее 1 года';
        if (year > 10 && year < 20) return year + ' лет';
        if (div === 1) return year + ' год';

        if (year > 1 && year < 5) return year + ' года';

        return year + ' лет';
    },
}
