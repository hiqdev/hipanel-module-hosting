import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import RequestHelper from "@hipanel-module-hosting/helper/RequestHelper";
import Index from "@hipanel-core/page/Index";

const request: object = {
  'account': "hipanel_test_account",
  'server': 'DSTEST02',
}

test("Delete request @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const requestHelper = new RequestHelper(adminPage);
  const index = new Index(adminPage);

  await requestHelper.gotoIndexRequest();
  await requestHelper.gotoViewPage(request['account']);

  await requestHelper.checkDetailViewData(request);
});
