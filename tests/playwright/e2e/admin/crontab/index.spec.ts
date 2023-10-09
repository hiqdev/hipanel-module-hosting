import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import Input from "@hipanel-core/input/Input";
import CrontabHelper from "@hipanel-module-hosting/helper/CrontabHelper";

const crontab: object = {
  account: 'hipanel_test_user',
  client: 'hipanel_test_reseller',
}

test("Correct view crontab @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const backupHelper = new CrontabHelper(adminPage);
  const index = new Index(adminPage);

  await backupHelper.gotoIndexCrontab();
});


