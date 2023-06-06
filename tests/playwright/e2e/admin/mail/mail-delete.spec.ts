import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import MailHelper from "@hipanel-module-hosting/helper/MailHelper";
import Index from "@hipanel-core/page/Index";

const mail: string = "hipanel_test@test.hiqdev"

test("Delete mail @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const mailHelper = new MailHelper(adminPage);
  const index = new Index(adminPage);

  await mailHelper.gotoIndexMail();
  const rowNumber = await index.getRowNumberInColumnByValue("E-mail", mail);
  await index.chooseNumberRowOnTable(rowNumber);

  await mailHelper.delete();

  await mailHelper.seeSuccessAlert('Mailbox delete task has been created successfully');
});
