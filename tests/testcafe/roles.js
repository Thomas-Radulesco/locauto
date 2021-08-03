import { Role } from 'testcafe';

export const user = Role('https://localhost:8000/login', async t => {
    await t
        .typeText('#inputLogin', 'Yolo')
        .typeText('#inputPassword', 'TestPasswordUser123%')
        .click('button[type=submit]');
});

export const admin = Role('https://localhost:8000/login', async t => {
    await t
        .typeText('#inputLogin', 'Tom')
        .typeText('#inputPassword', 'TestPasswordAdmin123%')
        .click('button[type=submit]');
});