import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import RequestHelper from "@hipanel-module-hosting/helper/RequestHelper";
import Index from "@hipanel-core/page/Index";

const account: string = "hipanel_test_account"

test("Delete request @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const requestHelper = new RequestHelper(adminPage);
  const index = new Index(adminPage);

  await requestHelper.gotoIndexRequest();
  const rowNumber = await index.getRowNumberInColumnByValue("Account", account);
  await index.chooseNumberRowOnTable(rowNumber);

  await requestHelper.delete();
  await requestHelper.seeSuccessAlert('Deleted');
});
