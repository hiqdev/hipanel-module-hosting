import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import HDomainHelper from "@hipanel-module-hosting/helper/HDomainHelper";

const domain: string = "test.hiqdev"
// const domain: string = "ffff.ua"

test("Delete domain @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const hdomainHelper = new HDomainHelper(adminPage);
  const index = new Index(adminPage);

  await hdomainHelper.gotoIndexDomain();

  const rowNumber = await index.getRowNumberInColumnByValue("Domain name", domain);
  await index.chooseNumberRowOnTable(rowNumber);

  await hdomainHelper.delete();
  await expect(await adminPage.locator(`text=${domain}`)).not.toBeVisible();
});
