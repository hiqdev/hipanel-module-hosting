import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import MailHelper from "@hipanel-module-hosting/helper/MailHelper";
import MailForm from "@hipanel-module-hosting/page/MailForm";
import Mail from "@hipanel-module-hosting/model/Mail";
import Index from "@hipanel-core/page/Index";

const mail: Mail = {
  client: "hipanel_test_reseller",
  server: "DSTEST02",
  account: "hipanel_test_account",
  email: "hipanel_test",
  domain: "test.hiqdev",
  password: "12345",
};

test.describe("It tests Mail common behavior", () => {

  test("Create IP @hipanel-module-hosting @admin", async ({ adminPage }) => {

    const mailHelper = new MailHelper(adminPage);
    const mailForm = new MailForm(adminPage);

    await mailHelper.gotoIndexMail();
    // await mailHelper.gotoCreateMail();
    //
    // await mailForm.fill(mail);
    // await mailForm.save();
    //
    // await mailForm.seeSuccessMailCreatingAlert();
  });

  test("Delete mail @hipanel-module-hosting @admin", async ({ adminPage }) => {

    // const mailHelper = new MailHelper(adminPage);
    // const index = new Index(adminPage);
    //
    // await mailHelper.gotoIndexMail();
    // const rowNumber = await index.getRowNumberInColumnByValue("E-mail", mail);
    // await index.chooseNumberRowOnTable(rowNumber);
    //
    // await mailHelper.delete();
    //
    // await mailHelper.seeSuccessAlert("Mailbox delete task has been created successfully");
  });
});
