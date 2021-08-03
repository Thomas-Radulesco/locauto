import { Selector } from 'testcafe';

export const fromDateSelector = Selector('input[type=datetime-local]#fromDate');
export const toDateSelector = Selector('input[type=datetime-local]#toDate');
export const searchButton = Selector('.available-vehicle-search-form button.btn.btn-success');
export const firstResult = Selector('.vehicles-list.container')
    .child('.vehicles-list-item')
    .child('.vehicle-item')
    .child('.vehicle-item-details')
    .child('.vehicle-item-details-title')
;
export const firstResultTotalPrice = firstResult
    .nextSibling('.vehicle-item-details-price')
;
export const secondResult = Selector('.vehicles-list.container')
    .child('.vehicles-list-item')
    .nth(1)
    .child('.vehicle-item')
    .child('.vehicle-item-details')
    .child('.vehicle-item-details-title')
;
export const secondResultTotalPrice = secondResult
    .nextSibling('.vehicle-item-details-price')
;
export const thirdResult = Selector('.vehicles-list.container')
    .child('.vehicles-list-item')
    .nth(2)
    .child('.vehicle-item')
    .child('.vehicle-item-details')
    .child('.vehicle-item-details-title')
;
export const thirdResultTotalPrice = thirdResult
    .nextSibling('.vehicle-item-details-price')
;
export const firstOrderButton = firstResult
    .nextSibling('.text-start')
    .child('form')
    .child('button[type=submit]')
;
export const bookedVehicle = Selector('table.table')
    .find('td')
;
export const bookedVehicleDailyPrice = Selector('table.table')
    .child('tbody')
    .child('tr')
    .nth(3)
    .find('td')
;
export const bookedFromDate = Selector('table.table')
    .child('tbody')
    .child('tr')
    .nth(4)
    .find('td')
;
export const bookedToDate = Selector('table.table')
    .child('tbody')
    .child('tr')
    .nth(5)
    .find('td')
;
export const bookedTotalPrice = Selector('table.table')
    .child('tbody')
    .child('tr')
    .nth(6)
    .find('td')
;
export const confirmReservationCheckbox = Selector('input[type=checkbox]#order_confirm');

export const bookingButton = Selector('button[type=submit]');