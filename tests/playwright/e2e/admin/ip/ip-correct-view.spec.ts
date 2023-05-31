import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import IPHelper from "@hipanel-module-hosting/helper/IPHelper";
import Index from "@hipanel-core/page/Index";

const ip: object = {
  ip: '127.0.0.199',
  links: 'DSTEST02',
};

test("Correct view IP @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const ipHelper = new IPHelper(adminPage);

  await ipHelper.gotoIndexIP();
  await ipHelper.gotoIPPage(ip['ip']);

  await ipHelper.checkDetailViewData(ip);

});
