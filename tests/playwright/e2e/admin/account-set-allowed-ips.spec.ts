import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import AccountHelper from "@hipanel-module-hosting/helper/AccountHelper";
import Index from "@hipanel-core/page/Index";

const account: string = 'hipanel_test_user';
const allowedIps: string = '88.208.52.222, 213.174.0.0/16';

test("Set allowed ips @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const accountHelper = new AccountHelper(adminPage);
  const index = new Index(adminPage);

  await accountHelper.gotoIndexAccount();
  await accountHelper.gotoAccountPage(account);

  await index.clickProfileMenuOnViewPage('IP address restrictions');
  await accountHelper.saveAllowedIps(account, allowedIps);

  await accountHelper.seeSuccessAlert('Allowed IPs changing task has been successfully added to queue');
});
