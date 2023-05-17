import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import BackupingHelper from "@hipanel-module-hosting/helper/BackupingHelper";

const backupName: string = 'TEST01:\nService';

test("Update backuping settings @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const backupingHelper = new BackupingHelper(adminPage);
  const index = new Index(adminPage);

  await backupingHelper.gotoIndexBackuping();
  await backupingHelper.gotoBackupingPage(backupName);

  await index.clickProfileMenuOnViewPage('Update settings');
  await backupingHelper.saveUpdatedSettings();

  await backupingHelper.seeSuccessAlert('Backup settings have been changed');
});
