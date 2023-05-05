import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import AccountHelper from "@hipanel-module-hosting/helper/AccountHelper";
import Index from "@hipanel-core/page/Index";

const account: string = "hipanel_test_user"
const systemSettings = {
  group: 'test',
  id: '42',
};

test("Set system settings @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const accountHelper = new AccountHelper(adminPage);
  const index = new Index(adminPage);

  await accountHelper.gotoIndexAccount();
  await accountHelper.gotoAccountPage(account);

  await index.clickProfileMenuOnViewPage('System settings');
  await accountHelper.saveSystemSettings(systemSettings);

  await accountHelper.seeSuccessAlert('System settings have been changed');
});
