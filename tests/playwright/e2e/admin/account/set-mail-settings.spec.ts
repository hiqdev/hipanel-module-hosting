import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import AccountHelper from "@hipanel-module-hosting/helper/AccountHelper";
import Index from "@hipanel-core/page/Index";

const account: string = "hipanel_test_user"

test("Set mail settings @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const accountHelper = new AccountHelper(adminPage);
  const index = new Index(adminPage);

  await accountHelper.gotoIndexAccount();
  await accountHelper.gotoAccountPage(account);

  await index.clickProfileMenuOnViewPage('Mail settings');
  await accountHelper.saveMailSettings('1000');

  await accountHelper.seeSuccessAlert('Mail settings have been changed');
});
