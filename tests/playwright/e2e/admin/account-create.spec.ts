import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import AccountHelper from "@hipanel-module-hosting/helper/AccountHelper";
import Account from "@hipanel-module-hosting/model/Account";
import AccountForm from "@hipanel-module-hosting/page/AccountForm";

const account: Account = {
  client: "hipanel_test_reseller",
  server: "DSTEST02",
  login: "gadezist_test",
}

test("Create account @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const accountHelper = new AccountHelper(adminPage);
  const accountForm = new AccountForm(adminPage);

  await accountHelper.gotoIndexAccount();
  await accountHelper.gotoCreateAccount();

  await accountForm.fill(account);
  await accountForm.save();
  await accountForm.seeSuccessAccountCreatingAlert();
});
