import { test } from "@hipanel-core/fixtures";
import AccountHelper from "@hipanel-module-hosting/helper/AccountHelper";
import Index from "@hipanel-core/page/Index";

const account: string = "gadezist_test";

test("Delete account @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const accountHelper = new AccountHelper(adminPage);
  const index = new Index(adminPage);

  await accountHelper.gotoIndexAccount();

  const rowNumber = await index.getRowNumberInColumnByValue("Account", account);
  await index.chooseNumberRowOnTable(rowNumber);

  await index.clickDropdownBulkButton("Basic actions", "Delete");
  await accountHelper.confirmDelete();

  await accountHelper.seeSuccessAlert("Account deleting task has been added to queue");
  await accountHelper.seeAccountStatus(account, "Deleting");
});
