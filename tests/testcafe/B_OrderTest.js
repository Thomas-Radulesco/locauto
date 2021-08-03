import { Selector, ClientFunction } from 'testcafe';
import {
    fromDateSelector,
    toDateSelector,
    searchButton,
    firstResult,
    firstResultTotalPrice,
    firstOrderButton,
    secondResult,
    secondResultTotalPrice,
    thirdResult,
    thirdResultTotalPrice,
    bookedVehicle,
    bookedVehicleDailyPrice,
    bookedFromDate,
    bookedToDate,
    bookedTotalPrice,
    confirmReservationCheckbox,
    bookingButton,
} from './selectors';
import { dateToLocaleISOString, toLocaleText } from './functions';
import { today } from './variables';
import { user, admin } from './roles';

fixture `Order Test`
    .page `https://localhost:8000/`;
    
const getWindowLocation = ClientFunction(() => window.location.href);

test('A : passer une commande après l\'indisponibilité avec vérification de la nouvelle disponibilité', async t => {

    let fromDateValue = dateToLocaleISOString(new Date(today.addDays(12))); // dans 12 jours
    let toDateValue = dateToLocaleISOString(new Date(today.addDays(14))); // dans 14 jours
    let fromDateText = toLocaleText(new Date(today.addDays(12)));
    let toDateText = toLocaleText(new Date(today.addDays(14)));

    await t
        .useRole(user)
        .typeText(fromDateSelector, fromDateValue)
        .typeText(toDateSelector, toDateValue)
        .click(searchButton)
        .wait(2000)
        .expect(Selector(fromDateSelector).value).eql(fromDateValue)
        .expect(Selector(toDateSelector).value).eql(toDateValue)
        .expect(Selector(firstResult).innerText).eql('X')
        .expect(Selector(firstResultTotalPrice).innerText).eql('Prix total : 600€')
        .expect(Selector(secondResult).innerText).eql('Y')
        .expect(Selector(secondResultTotalPrice).innerText).eql('Prix total : 300€')
        .expect(Selector(thirdResult).innerText).eql('Z')
        .expect(Selector(thirdResultTotalPrice).innerText).eql('Prix total : 900€')
        .click(firstOrderButton)
        .wait(2000)
        .expect(getWindowLocation()).contains('booking/create')
        .expect(Selector(bookedVehicle).innerText).eql('X')
        .expect(Selector(bookedVehicleDailyPrice).innerText).eql('200 €')
        .expect(Selector(bookedFromDate).innerText).eql(fromDateText)
        .expect(Selector(bookedToDate).innerText).eql(toDateText)
        .expect(Selector(bookedTotalPrice).innerText).eql('600 €')
        .click(confirmReservationCheckbox)
        .click(bookingButton)
        .wait(2000)
        .typeText(fromDateSelector, fromDateValue)
        .typeText(toDateSelector, toDateValue)
        .click(searchButton)
        .wait(2000)
        .expect(Selector(fromDateSelector).value).eql(fromDateValue)
        .expect(Selector(toDateSelector).value).eql(toDateValue)
        .expect(Selector(firstResult).innerText).notEql('X')
    ;

});