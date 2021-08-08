import { ClientFunction } from 'testcafe';

Date.prototype.addDays = function(days) {
    var date = new Date();
    date.setDate(date.getDate() + days);
    return date;
};

export const dateToLocaleISOString = (date) => {
    return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, "0") + '-' + date.getDate().toString().padStart(2, "0") + 'T' + date.getHours().toString().padStart(2, "0") + ':' + date.getMinutes().toString().padStart(2, "0") + ':00';
};

export const toLocaleText = (date) => {
    return date.getDate().toString().padStart(2, "0") + '-' + (date.getMonth() + 1).toString().padStart(2, "0") + '-' + date.getFullYear() + ' ' + date.getHours().toString().padStart(2, "0") + ':' + date.getMinutes().toString().padStart(2, "0") + ':00';
}