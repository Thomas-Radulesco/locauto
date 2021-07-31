import { Selector } from 'testcafe';

fixture `Vehicle Availability Tests`
    .page `https://localhost:8000/`;

const fromDateSelector = Selector('input[type=datetime-local]#fromDate');
const toDateSelector = Selector('input[type=datetime-local]#toDate');
const searchButton = Selector('.available-vehicle-search-form button.btn.btn-success');
const firstResult = Selector('.vehicles-list.container')
    .child('.vehicles-list-item')
    .child('.vehicle-item')
    .child('.vehicle-item-details')
    .child('.vehicle-item-details-title')
;
const secondResult = Selector('.vehicles-list.container')
    .nth(1)
    .child('.vehicle-item')
    .child('.vehicle-item-details')
    .child('.vehicle-item-details-title')
;
const thirdResult = Selector('.vehicles-list.container')
    .nth(2)
    .child('.vehicle-item')
    .child('.vehicle-item-details')
    .child('.vehicle-item-details-title')
;

Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}

const today = new Date();

test('A : demande incluse dans l\'indisponibilité', async t => {
    
    let fromDateValue = new Date(today.addDays(8)).toISOString().slice(0,16); // dans 8 jours
    let toDateValue = new Date(today.addDays(10)).toISOString().slice(0,16); // dans 10 jours
    
    await t
        .typeText(fromDateSelector, fromDateValue)
        .typeText(toDateSelector, toDateValue)
        .click(searchButton)
        .wait(2000)
        .expect(Selector(fromDateSelector).value).eql(fromDateValue + ':00')
        .expect(Selector(toDateSelector).value).eql(toDateValue + ':00')
        .expect(Selector(firstResult).innerText).eql('Z')
    ;
});

test('B : demande encapsule l\'indisponibilité', async t => {

    let fromDateValue = new Date(today.addDays(3)).toISOString().slice(0,16); // dans 3 jours
    let toDateValue = new Date(today.addDays(12)).toISOString().slice(0,16); // dans 12 jours

    await t
        .typeText(fromDateSelector, fromDateValue)
        .typeText(toDateSelector, toDateValue)
        .click(searchButton)
        .wait(2000)
        .expect(Selector(fromDateSelector).value).eql(fromDateValue + ':00')
        .expect(Selector(toDateSelector).value).eql(toDateValue + ':00')
        .expect(Selector('.vehicles-list.container').exists).notOk()
    ;
});