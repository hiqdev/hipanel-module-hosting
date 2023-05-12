import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import HDomainHelper from "@hipanel-module-hosting/helper/HDomainHelper";

const domain: string = "test.hiqdev"
const domainView: object = {
  client: 'hipanel_test_reseller',
  reseller: 'reseller',
  account: 'hipanel_test_account',
  server: 'DSTEST02',
}

test("Domain view correct @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const hdomainHelper = new HDomainHelper(adminPage);
  const index = new Index(adminPage);

  await hdomainHelper.gotoIndexDomain();
  await hdomainHelper.gotoDomainPage(domain);

  await hdomainHelper.checkDetailViewData(domainView);
});
