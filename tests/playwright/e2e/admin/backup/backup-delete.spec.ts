import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import BackupHelper from "@hipanel-module-hosting/helper/BackupHelper";
import Input from "@hipanel-core/input/Input";

test("Delete backup @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const backupHelper = new BackupHelper(adminPage);
  const index = new Index(adminPage);

  await backupHelper.gotoIndexBackup();

  await index.chooseNumberRowOnTable(1);
  const backupId = await index.getValueInColumnByNumberRow('ID', 1);

  await backupHelper.deleteBackup();
  expect(await adminPage.locator(`text=${backupId}`)).not.toBeVisible();
});


