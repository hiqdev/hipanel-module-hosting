import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import ServiceHelper from "@hipanel-module-hosting/helper/ServiceHelper";
import Index from "@hipanel-core/page/Index";

const service: object = {
  reseller: 'hipanel_test_reseller',
  client: 'hipanel_test_user1',
  server: 'TEST-DS-07',
};

test("Correct view service @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const serviceHelper = new ServiceHelper(adminPage);

  await serviceHelper.gotoIndexService();
  await serviceHelper.gotoServicePage(service['server']);

  await serviceHelper.checkDetailViewData(service);

});
