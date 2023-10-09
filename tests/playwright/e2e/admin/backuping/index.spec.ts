import { test } from "@hipanel-core/fixtures";
import BackupingHelper from "@hipanel-module-hosting/helper/BackupingHelper";
import Index from "@hipanel-core/page/Index";
import { expect } from "@playwright/test";

test.describe("It tests Backuping common behavior", () => {

  test("Enable backup statistic @hipanel-module-hosting @admin", async ({ adminPage }) => {

    const backupingHelper = new BackupingHelper(adminPage);
    const index = new Index(adminPage);

    await backupingHelper.gotoIndexBackuping();
  });

});
