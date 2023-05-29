import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import AccountHelper from "@hipanel-module-hosting/helper/AccountHelper";
import Index from "@hipanel-core/page/Index";

const account: string = 'hipanel_test_user';

test.describe("Test account block @hipanel-module-hosting @admin", () => {

  let accountHelper: AccountHelper;
  let index: Index;

  test.beforeEach(async ({ adminPage }) => {
    accountHelper = new AccountHelper(adminPage);
    index = new Index(adminPage);

    await accountHelper.gotoIndexAccount();
    const rowNumber = await index.getRowNumberInColumnByValue("Account", account);
    await index.chooseNumberRowOnTable(rowNumber);
  });

  test("Disable account block @hipanel-module-hosting @admin", async ({ adminPage }) => {

    await index.clickDropdownBulkButton('Basic actions', 'Disable block');
    await accountHelper.confirmDisableBlock();

    await accountHelper.seeSuccessAlert('Account was unblocked successfully');
    await accountHelper.seeAccountStatus(account, 'Ok');
  });

  test("Enable account block @hipanel-module-hosting @admin", async ({ adminPage }) => {

    await index.clickDropdownBulkButton('Basic actions', 'Enable block');
    await accountHelper.confirmEnableBlock();

    await accountHelper.seeSuccessAlert('Account was blocked successfully');
    await accountHelper.seeAccountStatus(account, 'Blocked');
  });
});

