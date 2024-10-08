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
    MaskEmail: (val) => {
        let last = val.slice(-1);
       /* if (last.match(/\d+/g) === null && last.match(/[a-z\-_]/g) === null) {
            val = val.substring(0, val.length - 1);
        }*/
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
    MaskCount: (val, min = 1, max = null) => {
        let last = val.slice(-1);
        if (last.match(/\d+/g) === null) {
            val = val.substring(0, val.length - 1);
        }
        if (val < min) val = min;
        if (max !== null && val > max) val = max;
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
    phone: (val) => {
        if (val === null || val === '' || val === 0 || val === undefined) return '';
        //return val
        return val.substr(0, 1) + ' ' + val.substr(1, 3) + '-' + val.substr(4, 3) + '-' + val.substr(7, 4);

        //return mb_substr($value, 0, 1) . ' ' . mb_substr($value, 1, 3) . '-' . mb_substr($value, 6, 3) . '-' . mb_substr($value, 7, 4);
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
    date: (val) => {
        const _date_ = new Date(val);
        let month = _date_.getMonth() + 1;
        if (month < 10) month = '0' + month;
        let day = _date_.getDate();
        if (day < 10) day = '0' + day;
        return  _date_.getFullYear() + '-' + month + '-' + day;
    },

    displayedInfo: (model = null, image = null, icon = null) => {
        if (model === null) return {
            name: null,
            slug: null,
            meta: {
                h1: null,
                title: null,
                description: null,
            },
            breadcrumb: {
                photo_id: null,
                caption: null,
                description: null,
            },
            awesome: null,
            template: null,
            text: null,
            image: null,
            icon: null,
            clear_image: false,
            clear_icon: false,
        }
        return {
            name: model.name,
            slug: model.slug,
            meta: model.meta,
            breadcrumb: model.breadcrumb,
            awesome: model.awesome,
            template: model.template,
            text: model.text,
            image: image,
            icon: icon,
            clear_image: false,
            clear_icon: false,
        };
    },
    displayedImage: (model) => {

    }
}
