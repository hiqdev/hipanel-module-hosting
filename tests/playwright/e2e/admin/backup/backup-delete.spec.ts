import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import BackupHelper from "@hipanel-module-hosting/helper/BackupHelper";
import Input from "@hipanel-core/input/Input";

const objectId: string = '40112902';

test("Delete backup @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const backupHelper = new BackupHelper(adminPage);
  const index = new Index(adminPage);

  await backupHelper.gotoIndexBackup();
  await Input.filterBy(adminPage, 'Object ID').setValue(objectId);

  await index.chooseNumberRowOnTable(1);
  await backupHelper.deleteBackup();
  await backupHelper.seeSuccessAlert("Backup deleting task has been added to queue");
  await expect(adminPage.locator('//table/tbody/tr/td/div')).toHaveText("No results found.");
});


