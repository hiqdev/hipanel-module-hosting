import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import BackupHelper from "@hipanel-module-hosting/helper/BackupHelper";
import Input from "@hipanel-core/input/Input";

const backup: object = {
  objectId: '40112902',
  client: 'hipanel_test_reseller',
}

test("Correct view backup @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const backupHelper = new BackupHelper(adminPage);
  const index = new Index(adminPage);

  await backupHelper.gotoIndexBackup();
  await Input.filterBy(adminPage, 'Object ID').setValue(backup['objectId']);
  await backupHelper.gotoBackupPage(1);

  await backupHelper.checkDetailViewData(backup);
});


