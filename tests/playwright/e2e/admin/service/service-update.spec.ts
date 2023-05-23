import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import ServiceHelper from "@hipanel-module-hosting/helper/ServiceHelper";

const service: object = {
  object: 'apache22',
  ip: 'DSTEST02: 127.0.0.199',
  status: 'stopped',
};

test("Update service @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const serviceHelper = new ServiceHelper(adminPage);

  await serviceHelper.gotoIndexService();
  await serviceHelper.gotoUpdatePage(service['object']);

  await serviceHelper.updateData(service);
  await serviceHelper.save();

  await serviceHelper.seeSuccessAlert('Service was updated successfully');

});
