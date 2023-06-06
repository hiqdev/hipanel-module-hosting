import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import MailHelper from "@hipanel-module-hosting/helper/MailHelper";
import MailForm from "@hipanel-module-hosting/page/MailForm";
import Mail from "@hipanel-module-hosting/model/Mail";

const mail: Mail = {
  client: 'hipanel_test_reseller',
  server: 'DSTEST02',
  account: 'hipanel_test_account',
  email: 'hipanel_test',
  domain: 'domain.hiqdev',
  password: '12345',
};

test("Create IP @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const mailHelper = new MailHelper(adminPage);
  const mailForm = new MailForm(adminPage);

  await mailHelper.gotoIndexMail();
  await mailHelper.gotoCreateMail();

  await mailForm.fill(mail);
  await mailForm.save();

  await mailForm.seeSuccessMailCreatingAlert();
});
