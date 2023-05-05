import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import AccountHelper from "@hipanel-module-hosting/helper/AccountHelper";
import Index from "@hipanel-core/page/Index";

const account: string = "hipanel_test_user"

test("Set empty global vhost options @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const accountHelper = new AccountHelper(adminPage);
  const index = new Index(adminPage);

  await accountHelper.gotoIndexAccount();
  await accountHelper.gotoAccountPage(account);

  await index.clickProfileMenuOnViewPage('Global vhost options');
  await index.clickButton('Save');

  await accountHelper.seeSuccessAlert('Global vhost options have been changed');
});
