import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import HDomainHelper from "@hipanel-module-hosting/helper/HDomainHelper";
import HDomain from "@hipanel-module-hosting/model/HDomain";
import HDomainForm from "@hipanel-module-hosting/page/HDomainForm";
import Index from "@hipanel-core/page/Index";

const domain: HDomain = {
  client: "hipanel_test_reseller",
  server: "DSTEST02",
  account: "hipanel_test_account",
  domainName: "test.hiqdev",
  ip: "apache22: 223.112.1.13",
};

test.describe("It tests HDomain common behavior", () => {

  test("Create domain @hipanel-module-hosting @admin", async ({ adminPage }) => {
    const hdomainHelper = new HDomainHelper(adminPage);
    const hdomainForm = new HDomainForm(adminPage);

    await hdomainHelper.gotoIndexDomain();
    // await hdomainHelper.gotoCreateDomain();
    //
    // await hdomainForm.fill(domain);
    // await hdomainForm.save();
    //
    // await hdomainForm.seeSuccessAccountCreatingAlert();
  });


  // test("Domain view correct @hipanel-module-hosting @admin", async ({ adminPage }) => {
  //
  //   const hdomainHelper = new HDomainHelper(adminPage);
  //   const index = new Index(adminPage);
  //
  //   await hdomainHelper.gotoIndexDomain();
  //   await hdomainHelper.gotoDomainPage(domain);
  //
  //   await hdomainHelper.checkDetailViewData(domainView);
  // });
  //
  // test("Delete domain @hipanel-module-hosting @admin", async ({ adminPage }) => {
  //
  //   const hdomainHelper = new HDomainHelper(adminPage);
  //   const index = new Index(adminPage);
  //
  //   await hdomainHelper.gotoIndexDomain();
  //
  //   const rowNumber = await index.getRowNumberInColumnByValue("Domain name", domain);
  //   await index.chooseNumberRowOnTable(rowNumber);
  //
  //   await hdomainHelper.delete();
  //   await expect(await adminPage.locator(`text=${domain}`)).not.toBeVisible();
  // });

});
