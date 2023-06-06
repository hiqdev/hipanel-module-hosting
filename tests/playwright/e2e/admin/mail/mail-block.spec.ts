import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import MailHelper from "@hipanel-module-hosting/helper/MailHelper";
import Index from "@hipanel-core/page/Index";

const mail: string = 'hipanel_test@test.hiqdev';

test.describe("Test mail block @hipanel-module-hosting @admin", () => {

  let mailHelper: MailHelper;
  let index: Index;

  test.beforeEach(async ({ adminPage }) => {
    mailHelper = new MailHelper(adminPage);
    index = new Index(adminPage);

    await mailHelper.gotoIndexMail();
    const rowNumber = await index.getRowNumberInColumnByValue("E-mail", mail);
    await index.chooseNumberRowOnTable(rowNumber);
  });

  test("Disable mail @hipanel-module-hosting @admin", async ({ managerPage }) => {

    await index.clickBulkButton('Disable');

    await mailHelper.seeSuccessAlert('Mailbox has been disabled.');
    await mailHelper.seeMailStatus(mail, 'Disabled');
  });

  test("Enable mail @hipanel-module-hosting @admin", async ({ managerPage }) => {

    await index.clickBulkButton('Enable');

    await mailHelper.seeSuccessAlert('Mailbox has been enabled.');
    await mailHelper.seeMailStatus(mail, 'Active');
  });
});

