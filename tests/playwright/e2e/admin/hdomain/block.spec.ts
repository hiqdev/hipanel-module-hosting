import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import HDomainHelper from "@hipanel-module-hosting/helper/HDomainHelper";

const domain: string = 'test.hiqdev';

test.describe("Test domain block @hipanel-module-hosting @admin", () => {

  let hdomainHelper: HDomainHelper;
  let index: Index;

  test.beforeEach(async ({ adminPage }) => {
    hdomainHelper = new HDomainHelper(adminPage);
    index = new Index(adminPage);

    await hdomainHelper.gotoIndexDomain();
    const rowNumber = await index.getRowNumberInColumnByValue("Domain name", domain);
    await index.chooseNumberRowOnTable(rowNumber);
  });

  test("Enable domain block @hipanel-module-hosting @admin", async ({ managerPage }) => {

    await index.clickDropdownBulkButton('Block', 'Enable');
    await hdomainHelper.confirmEnableBlock();

    await hdomainHelper.seeHdomainStatus(domain, 'Blocked');
  });

  test("Disable domain block @hipanel-module-hosting @admin", async ({ managerPage }) => {

    await index.clickDropdownBulkButton('Block', 'Disable');
    await hdomainHelper.confirmDisableBlock();

    await hdomainHelper.seeHdomainStatus(domain, 'Ok');
  });
});

