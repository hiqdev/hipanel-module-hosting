import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import IPHelper from "@hipanel-module-hosting/helper/IPHelper";
import Index from "@hipanel-core/page/Index";

test("Correct view IP @hipanel-module-hosting @admin", async ({ adminPage }) => {
  const ipHelper = new IPHelper(adminPage);
  await ipHelper.gotoIndexIP();
});
