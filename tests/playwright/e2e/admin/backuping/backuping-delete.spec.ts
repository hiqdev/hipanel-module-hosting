import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import BackupingHelper from "@hipanel-module-hosting/helper/BackupingHelper";

const backupName: string = 'TEST02:\nService';

test("Delete backup statistic @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const backupingHelper = new BackupingHelper(adminPage);
  const index = new Index(adminPage);

  await backupingHelper.gotoIndexBackuping();
  await backupingHelper.chooseRowOnTableByName(backupName);
  await index.clickBulkButton('Delete');

  await backupingHelper.seeSuccessAlert('Deleted');
});


