import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import ServiceHelper from "@hipanel-module-hosting/helper/ServiceHelper";
import Index from "@hipanel-core/page/Index";

test("Correct view service @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const serviceHelper = new ServiceHelper(adminPage);

  await serviceHelper.gotoIndexService();
});
