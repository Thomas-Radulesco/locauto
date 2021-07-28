import { Selector } from 'testcafe';

fixture `Vehicle Availability Tests`
    .page `https://localhost:8000/`;

const fromDate = Selector('input[type=datetime-local]#fromDate');
const toDate = Selector('input[type=datetime-local]#toDate');

test('A : demande incluse dans l\'indisponibilité', async t => {
    await t
        .typeText(fromDate, '2021-07-30T17:15')
        .typeText(toDate, '2021-08-04T00:00')
        // .pressKey('tab')
        // .typeText('input#fromDate', '30072021')

        // .click('input#fromDate')

        .expect(Selector(fromDate).value).eql('2021-07-30T17:15');
});