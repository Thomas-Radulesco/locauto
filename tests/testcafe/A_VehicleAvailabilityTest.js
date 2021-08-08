import { Selector } from 'testcafe';
import {
    fromDateSelector,
    toDateSelector,
    searchButton,
    firstResult,
    firstResultTotalPrice,
    secondResult,
    secondResultTotalPrice,
    thirdResult,
    thirdResultTotalPrice, 
} from './selectors';

import { dateToLocaleISOString } from './functions';
import { today } from './variables';

fixture `Vehicle Availability Tests`
    .page `https://localhost:8000/`;


test('A : demande incluse dans l\'indisponibilité', async t => {
    
    let fromDateValue = dateToLocaleISOString(new Date(today.addDays(8))); // dans 8 jours
    let toDateValue = dateToLocaleISOString(new Date(today.addDays(10))); // dans 10 jours
    
    await t
    .typeText(fromDateSelector, fromDateValue)
    .typeText(toDateSelector, toDateValue)
    .click(searchButton)
    .wait(2000)
    .expect(Selector(fromDateSelector).value).eql(fromDateValue)
    .expect(Selector(toDateSelector).value).eql(toDateValue)
    .expect(Selector(firstResult).innerText).eql('Z')
    .expect(Selector(firstResultTotalPrice).innerText).eql('Prix total : 900 €')
    ;
});

test('B : demande encapsule l\'indisponibilité', async t => {

    let fromDateValue = dateToLocaleISOString(new Date(today.addDays(3))); // dans 3 jours
    let toDateValue = dateToLocaleISOString(new Date(today.addDays(12))); // dans 12 jours

    await t
        .typeText(fromDateSelector, fromDateValue)
        .typeText(toDateSelector, toDateValue)
        .click(searchButton)
        .wait(2000)
        .expect(Selector(fromDateSelector).value).eql(fromDateValue)
        .expect(Selector(toDateSelector).value).eql(toDateValue)
        .expect(Selector('.vehicles-list.container').exists).notOk()
    ;
});

test('C : demande commence avant et s\'arrête pendant l\'indisponibilité', async t => {

    let fromDateValue = dateToLocaleISOString(new Date(today.addDays(3))); // dans 3 jours
    let toDateValue = dateToLocaleISOString(new Date(today.addDays(10))); // dans 10 jours

    await t
        .typeText(fromDateSelector, fromDateValue)
        .typeText(toDateSelector, toDateValue)
        .click(searchButton)
        .wait(2000)
        .expect(Selector(fromDateSelector).value).eql(fromDateValue)
        .expect(Selector(toDateSelector).value).eql(toDateValue)
        .expect(Selector('.vehicles-list.container').exists).notOk()
    ;
});

test('D : demande commence pendant et s\'arrête après l\'indisponibilité', async t => {

    let fromDateValue = dateToLocaleISOString(new Date(today.addDays(10))); // dans 10 jours
    let toDateValue = dateToLocaleISOString(new Date(today.addDays(12))); // dans 12 jours

    await t
        .typeText(fromDateSelector, fromDateValue)
        .typeText(toDateSelector, toDateValue)
        .click(searchButton)
        .wait(2000)
        .expect(Selector(fromDateSelector).value).eql(fromDateValue)
        .expect(Selector(toDateSelector).value).eql(toDateValue)
        .expect(Selector(firstResult).innerText).eql('Y')
        .expect(Selector(firstResultTotalPrice).innerText).eql('Prix total : 300 €')
        .expect(Selector(secondResult).innerText).eql('Z')
        .expect(Selector(secondResultTotalPrice).innerText).eql('Prix total : 900 €')
        .expect(Selector(thirdResult).exists).notOk()
    ;
});

test('E : demande coïncide avec l\'indisponibilité', async t => {

    let fromDateValue = dateToLocaleISOString(new Date(today.addDays(4))).slice(0, 11) + "08:00"; //  dans 4 jours, à 08h00
    let toDateValue = dateToLocaleISOString(new Date(today.addDays(11))).slice(0, 11) + "17:00"; // dans 11 jours, à 17h00

    await t
        .typeText(fromDateSelector, fromDateValue)
        .typeText(toDateSelector, toDateValue)
        .click(searchButton)
        .wait(2000)
        .expect(Selector(fromDateSelector).value).eql(fromDateValue + ":00")
        .expect(Selector(toDateSelector).value).eql(toDateValue + ":00")
        .expect(Selector('.vehicles-list.container').exists).notOk()
    ;
});

test('F : demande avant l\'indisponibilité', async t => {

    let fromDateValue = dateToLocaleISOString(new Date(today.addDays(1))); // dans 1 jour
    let toDateValue = dateToLocaleISOString(new Date(today.addDays(3))); // dans 3 jours

    await t
        .typeText(fromDateSelector, fromDateValue)
        .typeText(toDateSelector, toDateValue)
        .click(searchButton)
        .wait(2000)
        .expect(Selector(fromDateSelector).value).eql(fromDateValue)
        .expect(Selector(toDateSelector).value).eql(toDateValue)
        .expect(Selector(firstResult).innerText).eql('X')
        .expect(Selector(firstResultTotalPrice).innerText).eql('Prix total : 600 €')
        .expect(Selector(secondResult).exists).notOk()
        .expect(Selector(thirdResult).exists).notOk()
    ;
});

test('G : demande après l\'indisponibilité', async t => {

    let fromDateValue = dateToLocaleISOString(new Date(today.addDays(12))); // dans 12 jours
    let toDateValue = dateToLocaleISOString(new Date(today.addDays(14))); // dans 14 jours

    await t
        .typeText(fromDateSelector, fromDateValue)
        .typeText(toDateSelector, toDateValue)
        .click(searchButton)
        .wait(2000)
        .expect(Selector(fromDateSelector).value).eql(fromDateValue)
        .expect(Selector(toDateSelector).value).eql(toDateValue)
        .expect(Selector(firstResult).innerText).eql('X')
        .expect(Selector(firstResultTotalPrice).innerText).eql('Prix total : 600 €')
        .expect(Selector(secondResult).innerText).eql('Y')
        .expect(Selector(secondResultTotalPrice).innerText).eql('Prix total : 300 €')
        .expect(Selector(thirdResult).innerText).eql('Z')
        .expect(Selector(thirdResultTotalPrice).innerText).eql('Prix total : 900 €')
    ;
});