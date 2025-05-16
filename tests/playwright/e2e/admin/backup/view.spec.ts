import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import BackupHelper from "@hipanel-module-hosting/helper/BackupHelper";
import Input from "@hipanel-core/input/Input";

let backup: object = {
  id: '',
  client: 'hipanel_test_reseller',
  server: 'DSTEST02',
}

test("Correct view backup @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const backupHelper = new BackupHelper(adminPage);
  const index = new Index(adminPage);

  await backupHelper.gotoIndexBackup();
  backup['id'] = await index.getValueInColumnByNumberRow('ID', 1);
  await backupHelper.gotoBackupPage(1);

  await backupHelper.checkDetailViewData(backup);
});


