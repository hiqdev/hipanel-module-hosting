import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import Input from "@hipanel-core/input/Input";
import CrontabHelper from "@hipanel-module-hosting/helper/CrontabHelper";

test("Crontab update @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const backupHelper = new CrontabHelper(adminPage);
  const index = new Index(adminPage);

  await backupHelper.gotoIndexCrontab();
  await backupHelper.gotoCrontabPage(1);

  await Input.field(adminPage, '//textarea[contains(@class, "crontab-input")]').setValue('every day test')
  await index.clickButton('Save');

  await backupHelper.seeSuccessAlert('Success');
});


